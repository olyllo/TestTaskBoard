<?php
/**
 * Меню
 *
 *
 */

class MenuNew {
	private $menuItems; //Главный массив меню
	private $menuCount = 1; //Нумерация элемента
	private $menuId; //Внутреннее имя меню

	private $menuCssByLevel; //Таблица стилей для разных уровней
	private $menuCssDefault; //Значнеие CSS классов по умолчанию для всех элементов
	private $navCssClass; //Значение CSS класса для главного тега NAV

	function __construct (){
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


function getMenu () {
		$res = '<nav id="nav_' . $this->menuId  . '"  class="' . $this->navCssClass . '">' . PHP_EOL;
		//$res.= $this->getMenuMobileButton ();
		$res.= '<div' . $this->navDivCssClassId . '>' . PHP_EOL;
		$res.= $this->getMenuLevel(0);
		$res.= '</div></div></nav>' . PHP_EOL;
		return $res;

	}
}
