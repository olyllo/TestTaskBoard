<?php
/**
 * Class for work with users in view
 *
 *
 */


class Task_View extends Task_Model {

    public $dataSet;

	function __construct (){
		parent::__construct ();
	}

	
 	function getForm ($data = ''){

		if(isset($_SESSION['Loginning'])){
			if($_SESSION['Loginning']==1){
				include (CMS_MODULES_PATH . 'task/templates/authform.tpl.php');
			}
			elseif(($_SESSION['Loginning']==0)){
				include (CMS_MODULES_PATH . 'task/templates/listform.tpl.php');
			}
		}
		else{
			include (CMS_MODULES_PATH . 'task/templates/listform.tpl.php');
		}







}
}
