<?php

	class Decrypt  {

		function __construct() {
			$GLOBALS['sha1'] = 1000;
		}

 		public function sha1($sha1) {

			for ($i=0; $i < intval($GLOBALS['sha1']); $i++) { 
				if(sha1($i) == $sha1){
					return $i;
					break;
				}
			}

			return ('empty');
 		}
	}
?>