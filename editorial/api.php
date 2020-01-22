<?php

	error_reporting(0);

	class REST {
			
		public $_allow = array();
		public $_content_type = "application/json";
		public $_request = array();
		public $_header = array();
		
		private $_method = "";		
		private $_code = 200;
		
		public function __construct(){
			$this->inputs();
		}
		
		public function get_referer(){
			return $_SERVER['HTTP_REFERER'];
		}
		
		public function response($data,$status){
			$this->_code = ($status)?$status:200;
			$this->set_headers();
			echo $data;
			exit;
		}
		// For a list of http codes checkout http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
		private function get_status_message(){
			$status = array(
						200 => 'OK',
						201 => 'Created',  
						204 => 'No Content',  
						404 => 'Not Found',  
						406 => 'Not Acceptable',
						401 => 'Unauthorized');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}
		
		public function get_request_method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		private function inputs(){
			$this->_header = $this->get_request_header();
			switch($this->get_request_method()){
				case "POST":
					$this->_request = $this->cleanInputs($_POST);
					break;
				case "GET":
				case "DELETE":
					$this->_request = $this->cleanInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"),$this->_request);
					$this->_request = $this->cleanInputs($this->_request);
					break;
				default:
					$this->response('',406);
					break;
			}
		}		
		
		private function cleanInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		
		private function get_request_header(){
			$headers = array();
			foreach ($_SERVER as $key => $value) {
				if (strpos($key, 'HTTP_') === 0) {
					$headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
				}
			}
			return $headers;
		}

	    // clean from SQL injection
	    public function clean($string) {
	        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	        $string = preg_replace('/[^A-Za-z0-9\-\_]/', '', $string); // Removes special chars.
	        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	    }
		
		private function set_headers(){
	        ob_start();
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			header("Content-Type:".$this->_content_type);
	        ob_end_flush();
		}
	}	

	class APIEditorial extends REST {
	  /*	  

		const DB_SERVER = "localhost";
		const DB_USER = "ogerai81_user";
		const DB_PASSWORD = "97hC%02Mbkq";
		const DB = "ogerai81_astrofotografia";



	*/

		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "bqm";

	 
	    private $db = NULL;
	    private $mysqli = NULL;

	    public function __construct(){
	        parent::__construct();
	        $this->dbConnect();
	    }

	    /* Connect to Database */
	    private function dbConnect(){
	        $this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
	        $this->mysqli->query('SET CHARACTER SET utf8');
	    }

	 	public function doLogin($eemail, $esenha){
			if(!empty($eemail) and !empty($esenha)){ // empty checker
				$query="SELECT  eid, eemail, enome, esenha FROM editorial WHERE esenha = '".$esenha."' AND eemail = '$eemail' LIMIT 1";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
 						return $result;
				} else {
					$a['status'] = 'error';
					return  $a;
				}
			}
		}


	 	public function all_from_captura_where_cpontos($cpontos){

			$query="SELECT * FROM captura WHERE cpontos = $cpontos";

			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}

	 	public function cid_from_sys_where_cid($cid){

			$query="SELECT cid FROM sys WHERE cid = $cid";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}
	 	public function sid_from_sys_where_cid($cid) {

			$query="SELECT sid FROM sys WHERE cid = $cid";

			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}

	 	public function all_from_sys_where_cid($cid) {

			$query="SELECT * FROM sys WHERE cid = $cid";

			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}

	 	public function all_from_sys_where_sstatus($sstatus) {

			$query="SELECT * FROM sys WHERE sstatus = $sstatus";

			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}


	 	public function all_from_captura_where_cpontos_bigger($cpontos){

	 		//SELECT * FROM `captura` WHERE `cpontos` >= 6 ORDER BY `cpontos` DESC
			$query="SELECT * FROM captura WHERE cpontos >= $cpontos ORDER BY cpontos DESC";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}

	 	public function update_captura_sstatus_2_cpontos_where_cid($cid,$points){

			$query="UPDATE captura SET cstatus=2, cpontos=$points,  cdata='".date("Y-m-d H:i:s")."' WHERE cid = $cid";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['empty'] = '';
				return  $a;
			}
		}

	 	public function update_sys_sstatus_2_where_cid($cid){

			$query="UPDATE sys SET sstatus=2 WHERE cid = $cid";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}



	 	public function update_sys_sstatus_3_where_cid($cid){

			$query="UPDATE sys SET sstatus=3 WHERE cid = $cid";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}

	 	public function update_captura_cstatus_3_where_cid($cid){



			$query="UPDATE captura SET cstatus=3,  cdata='".date("Y-m-d H:i:s")."'   WHERE cid = $cid";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}


	 	public function all_from_avaliador() {

			$query="SELECT * FROM avaliador";

			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			} 
		}




/*
		public function count_cid_from_sys_where_cid_and_sstatus($cid, $sstatus) {
			$query="SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = $sstatus";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 

		}

*/








	 	public function getSys($aid){

			$query="SELECT  sid, aid, cid, cpontos, sstatus FROM sys WHERE aid = '".$aid."' AND sstatus = 0";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'error';
				return  $a;
			} 
		}


	 	public function getCapturaPontos0(){

			$query="SELECT * FROM captura WHERE cpontos = 0";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}

	 	public function getCapturaPontosMaiorQueZero(){

			$query="SELECT * FROM captura WHERE cpontos >= 1";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}





 

	 	public function getCapturaPontosSysCid($cid){

			$query="SELECT cid FROM sys WHERE cid = $cid";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}

	 	public function getSysSid($cid){

			$query="SELECT sid, cid, sstatus FROM sys WHERE cid = $cid";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}

	 	public function checkCid($cid){

//SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = 1
//SELECT COUNT(`cid`) FROM `sys` WHERE `cid`= 2 AND`sstatus` = 1

			$query="SELECT COUNT(cid) FROM sys WHERE cid = $cid AND sstatus = 1";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}


	 	public function getCapturaPontosSysCidStatus1($cid){

			$query="SELECT cid FROM sys WHERE cid = $cid AND sstatus = 1";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $result;
			} else {
				$a['status'] = 'empty';
				return  $a;
			} 
		}


	 	public function getCaptura($cid){

			$query="SELECT  cid, cpontos, cautor, ctitulo, ccategoria, cdescricao, csrcfull, csrcsmall, cstatus FROM captura WHERE cid = '".$cid."'";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
				 return $result;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}
 



	 	public function upCaptura($aid, $cid, $points){

			$query="UPDATE sys SET cpontos=$points, sstatus=1 WHERE aid = $aid AND cid = $cid";

			if ($this->mysqli->query($query)) {
				$a['status'] = 'success';
				return  $a;
			} else {
				$a['status'] = 'error';
				return  $a;
			}
		}

	 	public function insertAidCid($aid, $cid){

	 		if ($aid == 0) {
				 
				$a['status'] = 'error';
				return  $a;

	 		} else {
	 			 
				$query="INSERT INTO sys (sid, aid, cid, cpontos, sstatus) VALUES (null, $aid, $cid, 0, 0)";

				if ($this->mysqli->query($query)) {
					$a['status'] = 'success';
					return  $a;
				} else {
					$a['status'] = 'error';
					return  $a;
				}

	 		} 

		}

	}
?>

 