<?php
/**
 * Главный класс нашего веб приложения
 *
 *
 */

class Site {
	private $timeStart;

	/**-----------------------------------------------------------------------------
 	 * Запуск сайта
 	 */
	function __construct (){
		$this->timeStart = microtime (true);
	}



	/**-----------------------------------------------------------------------------
 	 * Операции с названием сайта
 	 */
	private $siteName = 'Мой сайт';

	function getSiteName () {
		return $this->siteName;
 	}

	function setSiteName ($str) {
		$this->siteName = $str;
 	}


	/**-----------------------------------------------------------------------------
 	 * CSS
 	 */
 	private $siteCSSFiles;

 	function addCSSFile ($str) {
		$this->siteCSSFiles [] = $str;
 	}

 	function getCSSHead (){
		$res = '';
	 	for ($i = 0; $i < sizeof($this->siteCSSFiles); $i++ ){
			$res.= '<link type="text/css" rel="stylesheet" href="' . $this->siteCSSFiles [$i] . '"/>' . PHP_EOL;
	 	}
		return $res;
 	}

	/**-----------------------------------------------------------------------------
 	 * JS
 	 */
 	private $siteJSFiles;

 	function addJSFile ($str){
		$this->siteJSFiles [] = $str;
  	}


	function getJSHead () {
		$res = '';
	 	for ($i = 0; $i < sizeof($this->siteJSFiles); $i++ ){
			$res.= '<script type="text/javascript" src="' . $this->siteJSFiles [$i] . '"></script>' . PHP_EOL;
	 	}
		return $res;
 	}


	/**-----------------------------------------------------------------------------
 	 * Title
 	 */
	private $siteTitle = 'Мой сайт';

	function addToTitle ($str){
		$this->siteTitle .= ' * ' . $str;
 	}

	function getTitle (){
		$res = '<title> ' . $this->siteTitle . '</title>' . PHP_EOL;
		return $res;
 	}

	function getTitleStr (){
		return $this->siteTitle;
 	}

	//Вернуть заголовок сайта
	function getHead (){
		$res = '<!DOCTYPE html>' . PHP_EOL .'<html lang="en">' . PHP_EOL .'<head>' . PHP_EOL;
		$res.= $this->getTitle();
		$res.= '<meta charset="utf-8">' . PHP_EOL;
    $res.= '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">' . PHP_EOL;
		$res.= $this->getCSSHead();
		$res.= $this->getJSHead();
		$res.= '</head>' . PHP_EOL;
		$res.= '<body>' . PHP_EOL;
		return $res;
	}

	function start (){
		echo $this->getHead ();
	}

	function end (){
		//echo 'Система работала (с) : ' . (microtime (true) - $this->timeStart)  . PHP_EOL;
		echo '</body></html>' . PHP_EOL;
	}

}// end class Site
