<?php
/**
 * Абстрактный основой класс для работы с базой данных
 *
 *
 */

// Класс работы с базой данных напрямую
//$MySql_Driver = new mysqli(DB_HOST . ':' . DB_PORT, DB_USER, DB_PSWD, DB_NAME);
$MySql_Driver = new mysqli(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
	if ($MySql_Driver->connect_errno) {
		echo "Не удалось подключиться к MySQL: (" . $MySql_Driver->connect_errno . ") " . $MySql_Driver->connect_error;
		die ("Работа прервана");
	}


class DB_Driver {

	public $ptrDB;
	public $dbErrorNum = 0;
	public $dbErrorMsg;
	public $msgInfo;
	public $sqlRes;
	public $sqlRow;

	function __construct (){
		GLOBAL $MySql_Driver;
		$this->dbErrorNum = false;
		$this->dbErrorMsg = '';
		$this->ptrDB = $MySql_Driver;
	}
	/**
	 * Send Sql Query to server
	 * save result to sqlRes
	 */
	function sqlSendQuery ($sql){
	    $this->sqlRes = $this->ptrDB->query($sql);
	    $this->dbErrorNum = $this->ptrDB->errno;
	    $this->dbErrorMsg =  $this->ptrDB->error;
	    return $this->sqlRes;
    }

		/**
		 * Get One row from result
		 */
    function sqlGetOneRow (){
	    $this->sqlRow = $this->sqlRes->fetch_array(MYSQLI_ASSOC);
	    return $this->sqlRow;
	}
	
		/**
		 * Get One row from result
		 */
	function sqlGetAllRows (){
			$this->sqlRow = $this->sqlRes->fetch_all(MYSQLI_ASSOC);
			return $this->sqlRow;
		}

		/**
		 * Get next row from result
		 */
    function sqlGetNextRow (){
	    $this->sqlRow = $this->sqlRes->fetch_assoc();
	    return $this->sqlRow;
    }

}
