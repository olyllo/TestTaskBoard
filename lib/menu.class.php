<?php
/**
 * Меню
 *
 *
 */
 require('mysql.class.php');
class Menu extends DB_Driver {
	public $janres;
  public $janresCount=1;
	private $menuItems; //Главный массив меню
	private $menuCount = 1; //Нумерация элемента
	private $menuId; //Внутреннее имя меню


	private $menuCssByLevel; //Таблица стилей для разных уровней
	private $menuCssDefault; //Значнеие CSS классов по умолчанию для всех элементов
	private $navCssClass; //Значение CSS класса для главного тега NAV

	function __construct (){
		parent::__construct ();
		$this->menuId = get_class($this);
		$this->setCssDefault ();
	}

//устанавливает значения классов для элементов CSS по умолчанию
	function setCssDefault (){
		$this->menuCssDefault ['ul'] = 'navbar-nav';
		$this->menuCssDefault ['li'] = 'nav-item';
		$this->menuCssDefault ['a'] = 'nav-link';
		$this->menuCssDefault ['span'] = '';
		$this->navCssClass = 'navbar';
		$this->navDivCssClassId = 'class="collapse navbar-collapse"';
	}


//устанавливает значения CSS Bootstrap
	function setCssBootStrap (){
	}


//Определяет CSS класс элемента
	function getCssClass ($lev, $el, $menuNum) {
		$res = '';
		if (isset($this->menuCssByLevel[$lev][$el])) { //если определен класс для этого элемента
			$res = $this->menuCssByLevel[$lev][$el];

		}elseif (isset($this->menuCssDefault[$el])) {
			$res = $this->menuCssDefault[$el];
		}else {
			$res = '';
		}
		$res.= ' ' . $this->menuId . '_' . $el . '_' . $menuNum;
		return $res;
	}


//Добавляет элемент меню
	function addMenuItem ($text, $url, $parent = 0){
		$this->menuItems[$this->menuCount]['parent'] = $parent;
		if ($parent !=0 ) {
			$this->menuItems [$parent]['cildren'] = $this->menuCount;
		}
		$this->menuItems[$this->menuCount]['text'] = $text;
		$this->menuItems[$this->menuCount]['url'] = $url;
		$this->menuItems[$this->menuCount]['cildren'] = 0;
		$ret = $this->menuCount;
		$this->menuCount++;
		return $ret;
	}


//Возвращает массив данных по меню
	function getMenuItemsByArray (){
		return $this->menuItems;
	}

//Строит уровень меню, принимая номер элемента и фиксируя уровень во внешней переменной
	private $curMenuLevel = 0;
	function getMenuLevel ($el = 0){
		$res ='<link href="bootstrap.min.css" rel="stylesheet">
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<div class="navbar-header">
		 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			 <span class="sr-only">Toggle navigation</span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
		 </button>

	 </div>
	 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		';
		$res.= '<ul id="menu_' . $this->menuId  . '_' . $el . '"  class="nav' .$this->getCssClass ($this->curMenuLevel, 'ul', 0) . '">' . PHP_EOL;

		for ($i = 1; $i < $this->menuCount; $i++) {

			if ($this->menuItems[$i]['parent'] == $el  ){ //если элемент меню является предком (0 для меню первого уровня)

				$dd_li = ''; $dd_a = ''; //класс для выподающего меню
				if ($this->menuItems[$i]['cildren'] != 0) {
					$dd_li = ' dropdown ';
					$dd_a = ' dropdown-toggle ';
				};

				$res.= '<li  class="active' . $this->getCssClass ($this->curMenuLevel, 'li', $i) . ' ' . $dd_li . ' ">';
				$res.= '<span class="' . $this->getCssClass ($this->curMenuLevel, 'span', $i) . '">';
				$res.= '<a href="' . $this->menuItems[$i]['url']  . '"  class="' . $this->getCssClass ($this->curMenuLevel, 'a', $i) . ' ' . $dd_a . '" >' . $this->menuItems[$i]['text'];
				$res.= '</a></span>' . PHP_EOL;

				if ($this->menuItems[$i]['cildren'] != 0) { //Если есть наследники - поднять уровень на 1 и войти в рекурсию
					$this->curMenuLevel++;
					//$res.= ' будет строится меню уровня ' . $this->curMenuLevel; //Сообщение о начале рекурсии
					$res.= '<div class="dropdown-menu" >' . PHP_EOL;
					$res.= $this->getMenuLevel ($i);
					$res.= '</div>' . PHP_EOL;
					$this->curMenuLevel--;
				}

				$res.= '</li>' . PHP_EOL;
			}
		}
		$res.= '</ul>' . PHP_EOL;
		//echo htmlspecialchars($res); печать html
		return $res;
	}


	function getMenu () {
		$res = '<nav id="nav_' . $this->menuId  . '"  class="' . $this->navCssClass . '">' . PHP_EOL;
		//$res.= $this->getMenuMobileButton ();
		$res.= '<div' . $this->navDivCssClassId . '>' . PHP_EOL;
		$res.= $this->getMenuLevel(0);
		$res.= '</div></div></nav>' . PHP_EOL;
		return $res;

	}


	function getJanreMenu () {
			$sql = "SELECT janreID, janreName, UrlLink FROM `janre`".PHP_EOL;
			//var_dump ($sql);
			$this->sqlSendQuery ($sql); //s end sql query to server (/lib/mysql.class.php)
			$c = 0;
			while ($row = $this->sqlGetNextRow() ){
				$this->janres[$this->janresCount]['janreID'] = $row ['janreID'];
				$this->janres[$this->janresCount]['janreName'] = $row ['janreName'];
				$this->janres[$this->janresCount]['UrlLink'] = $row ['UrlLink'];
				$this->janresCount++;
			}
			return $this->janres;
}

	function echoJanreName($i){
		return $this->janres[$i]['janreName'];
	}

	function echoJanreUrl($i){
		return $this->janres[$i]['UrlLink'];

	}


	function echoBooksList ($data = ''){
		//prettyPrint ($this->dataSet);
		include(CMS_MODULES_PATH . 'books/templates/booklist.tpl.php');
	}


	function getMenuMobileButton () {
		$res = '<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>' . PHP_EOL;
		//$res.= '<a class="navbar-brand" href="#">Главное меню</a>' . PHP_EOL;
		return $res;
	}

}//end class Menu
