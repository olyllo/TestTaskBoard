<?php
/**
 * Class for work with users in ciontroller
 *
 *
 */

class Task_Controller extends Task_View {

	function __construct (){
		parent::__construct ();
		
		GLOBAL $_POST;
		GLOBAL $_GET;
		GLOBAL $GLOBALS;
		$this->model = array('NAMEERROR'=>'','EMAILERROR'=>'','TEXTERROR'=>'','NAMEVALUE'=>'','EMAILVALUE'=>'', 'TEXTVALUE'=>'','LOGGINERROR'=>'','TEXTCGANGED'=>'','LOGGINADMINERROR'=>'');
				
		if (isset ($_POST['doLogin']) ){
			$this->doLogin ($_POST['userLogin'], $_POST['userPswd']);
		}
		elseif (isset ($_POST['doSaveChanges'])) {
			$this->doSaveChanges ($_POST);
		}
        elseif ( isset ($_POST['doLogout']) ) {
            $this->doLogout ();
		}
		elseif(isset($_POST['doAddTask'])){
			$this->doAddTask($_POST);
		}
		elseif(isset($_POST['toLoginPage'])){
			$this->Logining(1);
		}
		elseif(isset($_POST['goBack'])){
			$this->Logining(0);
		}
		elseif(isset($_POST['doSort'])){
			$_SESSION['Set_sort']='yes';
			if($_POST['sortTask']=='By name ascending'){
				$_SESSION['fild_sort']='user_name';
				$_SESSION['order_sort']='ASC';
			}
			elseif($_POST['sortTask']=='By name descending'){
				$_SESSION['fild_sort']='user_name';
				$_SESSION['order_sort']='DESC';
			}
			elseif($_POST['sortTask']=='By email ascending'){
				$_SESSION['fild_sort']='user_email';
				$_SESSION['order_sort']='ASC';
			}
			elseif($_POST['sortTask']=='By email descending'){
				$_SESSION['fild_sort']='user_email';
				$_SESSION['order_sort']='DESC';
			}
			elseif($_POST['sortTask']=='By status ascending'){
				$_SESSION['fild_sort']='status';
				$_SESSION['order_sort']='ASC';
			}
			elseif($_POST['sortTask']=='By status descending'){
				$_SESSION['fild_sort']='status';
				$_SESSION['order_sort']='DESC';
			}
		}
		/*elseif(!isset($_POST['doSort'])){
				$_SESSION['fild_sort']='created';
				$_SESSION['order_sort']='ASC';

		}*/
	}
			
	
	//Make authorization
	function doLogin ($login, $pswd){
		if (!$this->modelLoginUser ($login, $pswd))
      	{	
			$this->setRegularERRORorVALUE('LOGGINADMINERROR', 'No such admin, please check your login or password and try again');
						
		}elseif($this->modelLoginUser ($login, $pswd))
		{
			$this->Logining(0);
		}
    
	}

	function Logining($i){
		$_SESSION['Loginning']=$i;

	} 

	//Выполняет выход поьзователя с сайта
    function doLogout (){
	    $this->modelLogoutUser();
	}
	
    function doUpdate (){
		GLOBAL $_POST;
	}
	
	
	
	function doAddTask($data){
		$chekemail=$this->ChekEmail($data['userofferEmail']);
		$chekname=$this->CheckName($data['userofferName']);
		$chektext=$this->CheckText($data['userofferText']);
		if(($chekemail)&&($chekname)&&($chektext))
		{
			$user_id=$this->modelFindUser($data['userofferEmail']);
			$email=$data['userofferEmail'];
			$text = $data['userofferText'];
			$name=$data['userofferName'];
			$status = NEW_TASK;
			if (isset($user_id)){
				$this->modelAddTask($text, $status, $user_id);
			}
			else{
				$this->modelAdduser($name,$email);
				$user_id=$this->modelFindUser($email);
				$this->modelAddTask($text, $status, $user_id);
			}
		}

	}

	public function ChekEmail($email)
	{
		if (!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email))
		{
				$this->setRegularERRORorVALUE('EMAILVALUE', $email);
				$this->setRegularERRORorVALUE('EMAILERROR', 'Error at Email -  contain illegal symbols');
				return false;
						
		}
		else
		{
			$this->setRegularERRORorVALUE('EMAILVALUE', $email);
			return true;
		}
	}

	public function CheckName($name)
	{
		if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/', $name))
		{
			$this->setRegularERRORorVALUE('NAMEVALUE', $name);
			$this->setRegularERRORorVALUE('NAMEERROR', 'Error at Name -  contain illegal symbols');
			return false;
			
		}
		else
		{
			$this->setRegularERRORorVALUE('NAMEVALUE', $name);
			return true;
		}
	}

	public function CheckText($text)
	{
		if(iconv_strlen($text)==0)
		{
			$this->setRegularERRORorVALUE('TESTVALUE', $text);
			$this->setRegularERRORorVALUE('TEXTERROR', 'Empty fild plese write some task');
			return false;
		}
		elseif(iconv_strlen($text)<24){
			$this->setRegularERRORorVALUE('TESTVALUE', $text);
			$this->setRegularERRORorVALUE('TEXTERROR', 'Task should be more 24 symbols');
			return false;
		}
		else
		{
			$this->setRegularERRORorVALUE('TESTVALUE', $text);
			return true;
		}
	}

	public function CheckChangedText($text)
	{
		if(iconv_strlen($text)==0)
		{
			$this->setRegularERRORorVALUE('TEXTCGANGED', 'Empty fild plese write some task');
			return false;
		}
		elseif(iconv_strlen($text)<24){
			$this->setRegularERRORorVALUE('TEXTCGANGED', 'Task should be more 24 symbols');
			return false;
		}
		else
		{
			return true;
		}
	}


	public function setRegularERRORorVALUE ($ParamKey, $ParamVal)
	{
		$this->model[$ParamKey]=$ParamVal;
	}

	
	function setTakDone(){

	}

	function doSaveChanges($data){
		if (isset($_SESSION['user_role'])){
			if ($_SESSION['user_role']==1){
				$chektext=$this->CheckChangedText($data['userText']);
				if($chektext)
				{
					$id=$data['userId'];
					$text=$data['userText'];
					if (isset($data['userDone']))
					{
						$status=$data['userDone'];
						if($status=='on'){
							$status=TASK_DONE;
						}
						else{
							$status=TASK_UPDATED;
						}
						if($this->modelSaveChanges($id, $text,$status)){
							$this->setRegularERRORorVALUE('TEXTCGANGED', 'Pleas loggin as admin to change task');
						}
					}
					else
					{
						if($this->modelSaveChanges($id, $text)){
							$this->setRegularERRORorVALUE('TEXTCGANGED', 'Pleas loggin as admin to change task');
						}
					}
				}
			}
			elseif(isset($_SESSION['user_role'])!=1){
				$this->setRegularERRORorVALUE('LOGGINERROR', 'Pleas loggin as admin to change task');
			}
		}
		elseif(!isset($_SESSION['user_role'])){
			$this->setRegularERRORorVALUE('LOGGINERROR', 'Pleas loggin as admin to change task');
		}
	}

	function makePaginator($pageNumber=1,$orderBy='task_id',$direction='DESC'){		
		$pages=$this->getPageNum($pageNumber);
		$pages++;
		$this->setCurPage($pageNumber);
		if (!isset($list)) $list=0;
		$list=--$pageNumber*QUANTITY;
		$news_block = $this->modelGetTasksForCurentPage($list,$orderBy,$direction);
		return $news_block;


	}

	function makeArr(){
		if (isset($_GET['id']))
		{
			if($_GET['id']=='back')
			{
				$n=$this->getCurPage();
				if ($n>1) $n=$this->getCurPage()-1;
				$arr = $this->getSortData($n);
			}
			elseif($_GET['id']=='next'){
				$n=$this->getCurPage();
				if ($n<$this->getPageNum()) $n=$this->getCurPage()+1;
				$arr = $this->getSortData($n);
			}
			else
			{
				$arr = $this->getSortData($_GET['id']);
			}
		}
		else
		{
			$arr = $this->getSortData();
		}
		return $arr;
	}
	function getSortData($n=1){
		if(isset($_SESSION['Set_sort']))
		{
			$arr = $this->makePaginator($n,$_SESSION['fild_sort'],$_SESSION['order_sort']);
		}
		else{
			$arr = $this->makePaginator($n,'created','ASC');
		}
		return $arr;
	}

	function getPernissions(){
		if  (!isset($_SESSION['user_id'])){
			$abble='disabled';
		  }
		  elseif (isset($_SESSION['user_id'])){
			$role=$_SESSION['user_role'];
			if (!isset($role)){
				$abble='disabled';
			  }
			if ($role!=1){
			  $abble='disabled';
			}
			elseif($role==1)
			{
			  $abble='';
			}
		  }
		  return $abble;
	}

	function setCurPage($cur_page){
		setcookie("cur_page", $cur_page);
	}

	public function getCurPage(){
		return $_COOKIE["cur_page"];
	}

	function getPageNum(){
		$num = $this->modelCountNews();
		$pages = $num/QUANTITY;
		$pages = ceil($pages);
		return $pages;
	}




}
