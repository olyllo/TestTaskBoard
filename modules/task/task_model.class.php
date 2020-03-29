<?php
/**
 * Class for work with users in model
 *
 *
 */

class Task_Model extends DB_Driver {

	public $userID;
	public $userLogin;
	public $userName;
	public $userData;
    public $userAdmin;
    public $fileLink;

    function __construct (){
        $this->sessionLoadUser();
      parent::__construct ();
    }

	function modelLoginUser ($Email, $Pass){
      $userPswd=MD5($Pass);
        $sql = "SELECT * FROM `user` WHERE `user_email` = '$Email' AND `user_pass`= '$userPswd' "; 
        $this->sqlSendQuery($sql);
        $row = $this->sqlGetOneRow();
        if (isset($row['user_id'])){
            $this->id = $row['user_id'];
            $this->Name = $row['user_name'];
            $this->Email = $row['user_email'];
            $this->Role = $row['user_role'];
            $this->sessionSaveUser();
            return true;
        }
        else
        {
            return false;
        }
    }

    function modelSaveChanges($id, $text='',$status=''){
        if($status!=''){
            if(($status!='')&&($text!=''))
            {
                $sql="UPDATE `task` SET `task_text` = '$text', `task_status` = '$status'  WHERE `task`.`task_id` = '$id'";
            }
            else{
                $sql = "UPDATE `task` SET `task_status` = '$status' WHERE `task`.`task_id` = '$id'";
            }
        }
        elseif($text!=''){
            if(($status!='')&&($text!=''))
            {
                $sql="UPDATE `task` SET `task_text` = '$text'  `task_status` = '$status' WHERE `task`.`task_id` = '$id'";
            }
            else{
                $sql="UPDATE `task` SET `task_text` = '$text' WHERE `task`.`task_id` = '$id'";
            }
        }
        $rez=$this->sqlSendQuery($sql);
        if ($rez){
            return true;}
        else return false;
        
    }
    
    function modelAddTask($text,$status,$user){
        $sql = "INSERT INTO `task` (`task_text`, `task_status`, `created`, `updated`,`user`)
             VALUES ('" .$text . "', '" . $status . "', NOW(),NOW(),'" .$user."')";
        $this->sqlSendQuery($sql);
    }

    function modelAddUser($name, $email){
        $sql="INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_role`) VALUES (NULL, '$name', '', '$email', 'NEW_USER')";
        $this->sqlSendQuery($sql);

    }

    function modelCountNews(){
        $sql = "SELECT COUNT(*) FROM `task`"; 
        if ($this->sqlSendQuery($sql)){
            $num=$this->sqlGetOneRow();
            return $num['COUNT(*)'];
        }
        
                
    }

    function modelFindUser($email){
        $sql="SELECT `user_id` FROM `user` WHERE `user_email` = '$email'";
        if ($this->sqlSendQuery($sql)){
            $user=$this->sqlGetOneRow();
            return $user['user_id'];
        }
        else{
            return false;
        }
    }

    
    function modelGetAllTasks($sort)
    {
        $sql = "SELECT * FROM `task` ORDER BY `user` ASC"; 
        $this->sqlSendQuery($sql);
        $rows = $this->sqlGetAllRows ();
        return $rows;
    }

    function modelGetTasksForCurentPage($list,$orderBy='task_id',$direction='DESC'){
        $quantity=QUANTITY;
        $sql="SELECT * FROM task t JOIN user u ON t.user=u.user_id ORDER By $orderBy $direction LIMIT $quantity OFFSET $list";
        $this->sqlSendQuery($sql);
        $rows = $this->sqlGetAllRows ();
        return $rows;
    }

    function modelLogoutUser (){
	    session_destroy();
	    session_start();
        $this->sessionLoadUser();
    }

    function sessionSaveUser (){
        $_SESSION['user_id'] = $this->id;
        $_SESSION['user_name'] = $this->Name;
        $_SESSION['user_email'] = $this->Email;
        $_SESSION['user_role'] = $this->Role;
    }

    function getUserRole($id){
        $sql="SELECT `user_role` FROM `user` WHERE `user_id`=$id";
        $this->sqlSendQuery($sql);
        $role=$this->sqlGetOneRow();
        return $role;
    }

    function sessionLoadUser (){
        if (isset($_SESSION['user_id'])) {
            $this->id = $_SESSION['user_id'];
            $this->Name = $_SESSION['user_name'];
            $this->Email = $_SESSION['user_email'];
            $this->Role = $_SESSION['user_role'];
        }
    }



}

