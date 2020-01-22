<?php

	//error_reporting(0);

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

	class APIUpload extends REST {
	  

		const DB_SERVER = "localhost";
		const DB_USER = "ogerai81_user";
		const DB_PASSWORD = "97hC%02Mbkq";
		const DB = "ogerai81_astrofotografia";
	  /*


		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "bqm";
	*/
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

	 	public function doLogin($uemail, $usenha){
			if(!empty($uemail) and !empty($usenha)){ // empty checker
				$query="SELECT uid, uemail, unome, usenha, ustatus, udata FROM upload WHERE usenha = '".$usenha."' AND uemail = '$uemail' LIMIT 1";
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


	 	public function insert_captura($query){
			if ($this->mysqli->query($query)) {

				$a['success'] = '';
				return  $a;

			} else {
				
				$a['error'] = '';
				return  $a;

			}
		}

	 	public function insert_upload($query){
			if ($this->mysqli->query($query)) {

				$a['success'] = '';
				return  $a;

			} else {
				
				$a['error'] = '';
				return  $a;

			}
		}

		public function count_uemail_from_upload_where_uemail($uemail) {
			$query="SELECT COUNT(uemail) FROM upload WHERE uemail = '$uemail'";
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



	 	public function all_from_sys_where_cid($cid){

			$query="SELECT * FROM sys WHERE cid = $cid";
			 
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
				return $result;
			} else {
				$a['empty'] = '';
				return  $a;
			}
		}




	 	public function all_from_captura_where_cautor($cautor){

			$query="SELECT * FROM captura WHERE cautor = $cautor";

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



		
	}
?>

 