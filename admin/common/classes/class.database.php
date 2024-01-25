<?php

class Database 

{

	private $host;

	private $user;

	private $password;

	private $dbname;

	

	public $db_connection; //used to check connection

	public $lastInsertedId; // used to get last inserted id in db

	public static $queries; // to check query status

	public $errorPage;

	public $errorMailTo;

	

	//singlton pattren to create instances of this class;

	private static $instance;

	public static function getInstance() {

	

	}

	

	/*function __construct($host, $user, $password, $dbname) {

		$this->host = $host;

		$this->user = $user;

		$this->password = $password;

		$this->dbname = $dbname;

		$this->errorPage = "http://" . $host . "/hr/error_page.php";

		$this->connect ();

	}*/
	function __construct() {

		

		$this->host = DB_HOST;

		$this->user = DB_USER;

		$this->password = DB_PASS;

		$this->dbname = DB_NAME;

		$this->errorPage = "http://" . $host . "/hr/error_page.php";

		$this->connect ();

	}
	function connect() {

		$this->db_connection = mysqli_connect ( $this->host, $this->user, $this->password );

		if ($this->db_connection) {

			$dbselect = mysqli_select_db ( $this->db_connection,$this->dbname ) or $this->notify ( mysql_error ($this->db_connection), true );

			return $dbselect;

		} else {

			$this->notify ( mysqli_error ($this->db_connection), true );

		}

		

		self::$queries = array (); //used to check total queries status

	}

	

	function query($sql) {

		self::$queries [] = $sql; //used to check total queries status

		$result = mysqli_query ( $this->db_connection, $sql ) or $this->notify ( mysqli_error ($this->db_connection), true );

		return $result;

	

	}

	

	function select($tableName, $arrColumns = '', $where = '1', $orderBy = '', $limit = '') {

		//echo "limit :".$limit;

		if ((is_array ( $arrColumns ))) {

			$arrColumns = implode ( ',', $arrColumns );

		} else {

			$this->notify ( 'function :  select() <br> Error: Passed argument should be an array!', true );

		}

		

		if ($orderBy != '') {

			

			$orderBy = ' ORDER BY ' . $orderBy;

		}

		if ($limit != '') {

			$limit = ' LIMIT ' . $limit;

		}

		$query = 'SELECT ' . $arrColumns . ' FROM ' . $tableName . ' WHERE ' . $where . $orderBy . $limit;

		//echo $query; 

		//die;

		return $this->getArrayResult( $query );

	}

	

	function insert($tableName, $arrColumns) {

	    $columnsKeys = join ( ", ", array_keys ( $arrColumns ) );

	   // echo $columnsKeys;

		$values = $this->quotedColumnValue ($arrColumns);

		//echo $values;

		$values = join ( ", ", $values );

		$sql = "INSERT INTO " . $tableName . " ($columnsKeys) VALUES ($values)";

	   // print_r($sql);die();

		$this->query ( $sql );

		$this->lastInsertedId = mysqli_insert_id ($this->db_connection); //Return inserted id

		return $this->lastInsertedId;

		

	

	}

	

	function update($tableName, $arrColumns, $where) 



	{

		

		$arrStuff = array ();

		

		if (! (is_array ( $arrColumns ))) {

			

			$this->notify ( 'function :  update() <br> Error: Passed argument should be an array!', true );

		}

		

		if ($where == '') {

			$this->notify ( 'function :  update() <br> Error:  where condition is missing !', true );

		}

		foreach ( $arrColumns as $key => $val ) 



		{

			$varPositionTwo = strpos ( $val, 'encode(' );

			if ($varPosition != false) {

				

				$arrStuff [] = "$key = " . mysqli_real_escape_string ($this->db_connection,$val);

			} else if ($varPositionTwo !== false) {

				

				$arrStuff [] = "$key = " . $val;

			

			} else {

				

				$arrStuff [] = "$key = '" . mysqli_real_escape_string ($this->db_connection,$val ) . "'";

			}

		  // print_r($arrStuff);

		}

		

		$stuff = implode ( ", ", $arrStuff );

		$sqlUpdate = 'UPDATE ' .$tableName. ' SET ' . $stuff . ' WHERE  ' . $where;

		//echo $sqlUpdate;die();

		$this->query ($sqlUpdate);

		return mysqli_affected_rows ($this->db_connection);

	

	}

	function updateList($tableName, $arrColumns, $idName, $idValues) {

		if (! (is_array ( $arrColumns )) || ! (is_array ( $idValues ))) {

			$this->notify ( 'function :  updateList() <br> Error: Passed argument should be an array!', true );

		}

		

		if (count ( $idValues ) > 0) {

			if (is_array ( $idValues )) {

				$idValues = implode ( ',', $idValues );

			}

		} else {

			$this->notify ( 'function :  updateList() <br> Error: Passed array is blank!', true );

		}

		$arrStuff = array ();

		foreach ( $this->formatColumnValue ( $arrColumns ) as $key => $val ) {

			$arrStuff [] = "$key = '" . mysqli_real_escape_string ( $val ) . "'";

		}

		$stuff = implode ( ", ", $arrStuff );

		

		$sql = "UPDATE " . $tableName . " SET " . $stuff . " WHERE " . $idName . " IN ( " . $idValues . " )";

		$this->query ( $sql );

		// Not always correct due to mysql update bug/feature

		return mysqli_affected_rows ($this->db_connection);

	}

	

	function delete($tableName, $where) {

		if ($where == '') {

			$this->notify ( 'function :  delete() <br> Error: where condition is missing !', true );

		}

		

		$idValue = mysqli_real_escape_string ($this->db_connection,$idValue );

		$query = "DELETE FROM " . $tableName . " WHERE " . $where;

		//echo $query;die;

		$varDel = $this->query ( $query );

		return mysqli_affected_rows ($this->db_connection);

	

	}

	

	function formatColumnValue($columnVals) {

		foreach ( $columnVals as $key => $val ) {

			$columnVals [$key] = mysqli_real_escape_string ( $val );

		}

		return $columnVals;

	}

	

	function quotedColumnValue($columnVals) {

		foreach ( $columnVals as $key => $val ) {

			if ($val == "now()") {

			

				$columnValues [$key] = mysqli_real_escape_string ( $val );

			} elseif (substr_count ( $val, 'encode(' ) > 0) {

			

				$columnValues [$key] = $val;

			} else {

				//echo "@@@".$val;'</br>';

				$clmValue = mysqli_real_escape_string ($this->db_connection,$val);

				$columnValues [$key] = "'" . $clmValue . "'";

			

			}

		}

		//print_r($columnValues);

		//die;

		return $columnValues;

	}

	

	function getArrayResult($sql)

	 {

		$res = $this->query ( $sql );

		if ($res) {

			while ( $row = mysqli_fetch_assoc ( $res ) ) {

				$row = $this->formatDbValue ( $row );

				$resultProvider [] = $row;

			}

		}

		return $resultProvider;

	}

	

	function formatDbValue($text, $nl2br = false) {

		if (is_array ( $text )) {

			$tmp_array = array ();

			foreach ( $text as $key => $value ) {

				$tmp_array [$key] = $this->formatDbValue ( $value );

			}

			return $tmp_array;

		} else {

			$text = htmlspecialchars ( stripslashes ( $text ) );

			if ($nl2br) {

				return nl2br ( $text );

			} else {

				return $text;

			}

		}

	}

	

	function deleteList($tableName, $idName, $idValues) 

	{

		if (is_array ( $idValues )) {

			$idValues = implode ( ',', $idValues );

		} else {

			$this->notify ( 'function :  deleteList() <br> Error: passargument should be an array (idValues)!', true );

		

		}

		$sqlDel = 'DELETE FROM ' . $tableName . ' WHERE ' . $idName . ' IN (' . $idValues . ')';

		$this->query ( $sqlDel );

		return mysqli_affected_rows ();

	

	}

	

	function getNumRows($argTableName, $argClmn, $argWhr = '') {

		

		$varWhr = "1";

		if ($argWhr != '') {

			$varWhr = $argWhr;

		}

	    $sqlNum = 'SELECT count(' . $argClmn . ') as numrows FROM ' . $argTableName . ' Where ' . $varWhr; 

		$varResult = mysqli_query ( $sqlNum ) or $this->notify ( mysqli_error ($this->db_connection), true, true );

		$resutlNum = mysqli_fetch_assoc ( $varResult );

		return $resutlNum [numrows];

	

	}

	

	function numQueries() {

		return count ( self::$queries );

	}

	function lastQuery() {

		

		return self::$queries [count ( self::$queries ) - 1];

	

	}

	function queries() {

		

		return implode ( "\n", self::$queries );

	}

	function isValid() {

		return isset ( $this->result ) && (mysql_num_rows ( $this->result ) > 0);

	}

	

	function notify($errMsg, $redirect = true) {

		if ($redirect == true) {

			 echo $errMsg = $errMsg . "<br/><br/>" . $this->lastQuery ();

			//$_SESSION ["notifyMsg"] = $errMsg;

			//$this->errorPage;

			//header ( "Location: $this->errorPage" );

		

		} else {

			$msg = $_SERVER ['PHP_SELF'] . " @ " . date ( "Y-m-d H:ia" ) . "\n";

			$msg .= $errMsg . "\n\n";

			$msg .= self::$queries () . "\n\n";

			@mail ( $this->errorMailTo, $_SERVER ['PHP_SELF'], $msg, "From: {$this->errorFrom}" );

			header ( "Location: $_SERVER[HTTP_REFERER]" );

			exit ();

		

		}

	}

	

	function selectTag($tableName, $arrColumns = '', $where = '1', $orderBy = '', $limit = '') {

		//echo "limit :".$limit;

		if ((is_array ( $arrColumns ))) {

			$arrColumns = implode ( ',', $arrColumns );

		} else {

			$this->notify ( 'function :  select() <br> Error: Passed argument should be an array!', true );

		}

		

		if ($orderBy != '') {

			

			$orderBy = ' ORDER BY ' . $orderBy;

		}

		if ($limit != '') {

			$limit = ' LIMIT ' . $limit;

		}

		$query = 'SELECT   distinct('.$arrColumns.')   FROM ' . $tableName . ' WHERE ' . $where . $orderBy . $limit;

		//echo $query; 

		//print_r($this->getArrayResult ( $query ));

		return $this->getArrayResult ( $query );

	}

	

	function totalRowNum($sql)

	{

		$res = $this->query ( $sql );

		$rowCount = $this->mysql_num_rows( $res ); 

		return $rowCount;

	

	}

        

        



}



?>

