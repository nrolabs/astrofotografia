<?php

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

	class APIGet extends REST {

		public function processApi(){

			if  (!isset($_GET['l'])) $this->response('',401);
		 
			if  ($_GET['l'] =="") $this->response('',401);
 
			$file_name = $_GET['l'].".jpg";
 
			if(file_exists($file_name)) {

 
				

				ob_start();

				header('Pragma: public'); 	// required

				header('Expires: 0');		// no cache

				header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');

				header('Content-Type: '.$this->mime_types($file_name));

				header('Content-Length: '.filesize($file_name));	// provide file size

				header('X-Powered-By:Nrolabs');

				header('Cache-Control: must-revalidate');

				readfile($file_name);		// push it out

				ob_end_flush();

	    	} else {
	    		$this->response('',401);
	    	}
		}



		private function mime_types($file_name){
			$mime_types = array(
			      '3dm' => 'x-world/x-3dmf',
			      '3dmf' => 'x-world/x-3dmf',
			      'a' => 'application/octet-stream',
			      'aab' => 'application/x-authorware-bin',
			      'aam' => 'application/x-authorware-map',
			      'aas' => 'application/x-authorware-seg',
			      'abc' => 'text/vndabc',
			      'acgi' => 'text/html',
			      'afl' => 'video/animaflex',
			      'ai' => 'application/postscript',
			      'aif' => 'audio/aiff',
			      'aif' => 'audio/x-aiff',
			      'aifc' => 'audio/aiff',
			      'aifc' => 'audio/x-aiff',
			      'aiff' => 'audio/aiff',
			      'aiff' => 'audio/x-aiff',
			      'aim' => 'application/x-aim',
			      'aip' => 'text/x-audiosoft-intra',
			      'ani' => 'application/x-navi-animation',
			      'aos' => 'application/x-nokia-9000-communicator-add-on-software',
			      'aps' => 'application/mime',
			      'arc' => 'application/octet-stream',
			      'arj' => 'application/arj',
			      'arj' => 'application/octet-stream',
			      'art' => 'image/x-jg',
			      'asf' => 'video/x-ms-asf',
			      'asm' => 'text/x-asm',
			      'asp' => 'text/asp',
			      'asx' => 'application/x-mplayer2',
			      'asx' => 'video/x-ms-asf',
			      'asx' => 'video/x-ms-asf-plugin',
			      'au' => 'audio/basic',
			      'au' => 'audio/x-au',
			      'avi' => 'application/x-troff-msvideo',
			      'avi' => 'video/avi',
			      'avi' => 'video/msvideo',
			      'avi' => 'video/x-msvideo',
			      'avs' => 'video/avs-video',
			      'bcpio' => 'application/x-bcpio',
			      'bin' => 'application/mac-binary',
			      'bin' => 'application/macbinary',
			      'bin' => 'application/octet-stream',
			      'bin' => 'application/x-binary',
			      'bin' => 'application/x-macbinary',
			      'bm' => 'image/bmp',
			      'bmp' => 'image/bmp',
			      'bmp' => 'image/x-windows-bmp',
			      'boo' => 'application/book',
			      'book' => 'application/book',
			      'boz' => 'application/x-bzip2',
			      'bsh' => 'application/x-bsh',
			      'bz' => 'application/x-bzip',
			      'bz2' => 'application/x-bzip2',
			      'c' => 'text/plain',
			      'c++' => 'text/plain',
			      'cat' => 'application/vndms-pkiseccat',
			      'cc' => 'text/plain',
			      'cc' => 'text/x-c',
			      'ccad' => 'application/clariscad',
			      'cco' => 'application/x-cocoa',
			      'cdf' => 'application/cdf',
			      'cdf' => 'application/x-cdf',
			      'cdf' => 'application/x-netcdf',
			      'cer' => 'application/pkix-cert',
			      'cer' => 'application/x-x509-ca-cert',
			      'cha' => 'application/x-chat',
			      'chat' => 'application/x-chat',
			      'class' => 'application/java',
			      'class' => 'application/java-byte-code',
			      'class' => 'application/x-java-class',
			      'com' => 'application/octet-stream',
			      'com' => 'text/plain',
			      'conf' => 'text/plain',
			      'cpio' => 'application/x-cpio',
			      'cpp' => 'text/x-c',
			      'cpt' => 'application/mac-compactpro',
			      'cpt' => 'application/x-compactpro',
			      'cpt' => 'application/x-cpt',
			      'crl' => 'application/pkcs-crl',
			      'crl' => 'application/pkix-crl',
			      'crt' => 'application/pkix-cert',
			      'crt' => 'application/x-x509-ca-cert',
			      'crt' => 'application/x-x509-user-cert',
			      'csh' => 'application/x-csh',
			      'csh' => 'text/x-scriptcsh',
			      'css' => 'application/x-pointplus',
			      'css' => 'text/css',
			      'cxx' => 'text/plain',
			      'dcr' => 'application/x-director',
			      'deepv' => 'application/x-deepv',
			      'def' => 'text/plain',
			      'der' => 'application/x-x509-ca-cert',
			      'dif' => 'video/x-dv',
			      'dir' => 'application/x-director',
			      'dl' => 'video/dl',
			      'dl' => 'video/x-dl',
			      'doc' => 'application/msword',
			      'dot' => 'application/msword',
			      'dp' => 'application/commonground',
			      'drw' => 'application/drafting',
			      'dump' => 'application/octet-stream',
			      'dv' => 'video/x-dv',
			      'dvi' => 'application/x-dvi',
			      'dwf' => 'drawing/x-dwf (old)',
			      'dwf' => 'model/vnddwf',
			      'dwg' => 'application/acad',
			      'dwg' => 'image/vnddwg',
			      'dwg' => 'image/x-dwg',
			      'dxf' => 'application/dxf',
			      'dxf' => 'image/vnddwg',
			      'dxf' => 'image/x-dwg',
			      'dxr' => 'application/x-director',
			      'el' => 'text/x-scriptelisp',
			      'elc' => 'application/x-bytecodeelisp (compiled elisp)',
			      'elc' => 'application/x-elc',
			      'env' => 'application/x-envoy',
			      'eps' => 'application/postscript',
			      'es' => 'application/x-esrehber',
			      'etx' => 'text/x-setext',
			      'evy' => 'application/envoy',
			      'evy' => 'application/x-envoy',
			      'exe' => 'application/octet-stream',
			      'f' => 'text/plain',
			      'f' => 'text/x-fortran',
			      'f77' => 'text/x-fortran',
			      'f90' => 'text/plain',
			      'f90' => 'text/x-fortran',
			      'fdf' => 'application/vndfdf',
			      'fif' => 'application/fractals',
			      'fif' => 'image/fif',
			      'fli' => 'video/fli',
			      'fli' => 'video/x-fli',
			      'flo' => 'image/florian',
			      'flx' => 'text/vndfmiflexstor',
			      'fmf' => 'video/x-atomic3d-feature',
			      'for' => 'text/plain',
			      'for' => 'text/x-fortran',
			      'fpx' => 'image/vndfpx',
			      'fpx' => 'image/vndnet-fpx',
			      'frl' => 'application/freeloader',
			      'funk' => 'audio/make',
			      'g' => 'text/plain',
			      'g3' => 'image/g3fax',
			      'gif' => 'image/gif',
			      'gl' => 'video/gl',
			      'gl' => 'video/x-gl',
			      'gsd' => 'audio/x-gsm',
			      'gsm' => 'audio/x-gsm',
			      'gsp' => 'application/x-gsp',
			      'gss' => 'application/x-gss',
			      'gtar' => 'application/x-gtar',
			      'gz' => 'application/x-compressed',
			      'gz' => 'application/x-gzip',
			      'gzip' => 'application/x-gzip',
			      'gzip' => 'multipart/x-gzip',
			      'h' => 'text/plain',
			      'h' => 'text/x-h',
			      'hdf' => 'application/x-hdf',
			      'help' => 'application/x-helpfile',
			      'hgl' => 'application/vndhp-hpgl',
			      'hh' => 'text/plain',
			      'hh' => 'text/x-h',
			      'hlb' => 'text/x-script',
			      'hlp' => 'application/hlp',
			      'hlp' => 'application/x-helpfile',
			      'hlp' => 'application/x-winhelp',
			      'hpg' => 'application/vndhp-hpgl',
			      'hpgl' => 'application/vndhp-hpgl',
			      'hqx' => 'application/binhex',
			      'hqx' => 'application/binhex4',
			      'hqx' => 'application/mac-binhex',
			      'hqx' => 'application/mac-binhex40',
			      'hqx' => 'application/x-binhex40',
			      'hqx' => 'application/x-mac-binhex40',
			      'hta' => 'application/hta',
			      'htc' => 'text/x-component',
			      'htm' => 'text/html',
			      'html' => 'text/html',
			      'htmls' => 'text/html',
			      'htt' => 'text/webviewhtml',
			      'htx' => 'text/html',
			      'ice' => 'x-conference/x-cooltalk',
			      'ico' => 'image/x-icon',
			      'idc' => 'text/plain',
			      'ief' => 'image/ief',
			      'iefs' => 'image/ief',
			      'iges' => 'application/iges',
			      'iges' => 'model/iges',
			      'igs' => 'application/iges',
			      'igs' => 'model/iges',
			      'ima' => 'application/x-ima',
			      'imap' => 'application/x-httpd-imap',
			      'inf' => 'application/inf',
			      'ins' => 'application/x-internett-signup',
			      'ip' => 'application/x-ip2',
			      'isu' => 'video/x-isvideo',
			      'it' => 'audio/it',
			      'iv' => 'application/x-inventor',
			      'ivr' => 'i-world/i-vrml',
			      'ivy' => 'application/x-livescreen',
			      'jam' => 'audio/x-jam',
			      'jav' => 'text/plain',
			      'jav' => 'text/x-java-source',
			      'java' => 'text/plain',
			      'java' => 'text/x-java-source',
			      'jcm' => 'application/x-java-commerce',
			      'jfif' => 'image/jpeg',
			      'jfif' => 'image/pjpeg',
			      'jfif-tbnl' => 'image/jpeg',
			      'jpe' => 'image/jpeg',
			      'jpe' => 'image/pjpeg',
			      'jpeg' => 'image/jpeg',
			      'jpeg' => 'image/pjpeg',
			      'jpg' => 'image/jpeg',
			      'jpg' => 'image/pjpeg',
			      'jps' => 'image/x-jps',
			      'js' => 'application/x-javascript',
			      'jut' => 'image/jutvision',
			      'kar' => 'audio/midi',
			      'kar' => 'music/x-karaoke',
			      'ksh' => 'application/x-ksh',
			      'ksh' => 'text/x-scriptksh',
			      'la' => 'audio/nspaudio',
			      'la' => 'audio/x-nspaudio',
			      'lam' => 'audio/x-liveaudio',
			      'latex' => 'application/x-latex',
			      'lha' => 'application/lha',
			      'lha' => 'application/octet-stream',
			      'lha' => 'application/x-lha',
			      'lhx' => 'application/octet-stream',
			      'list' => 'text/plain',
			      'lma' => 'audio/nspaudio',
			      'lma' => 'audio/x-nspaudio',
			      'log' => 'text/plain',
			      'lsp' => 'application/x-lisp',
			      'lsp' => 'text/x-scriptlisp',
			      'lst' => 'text/plain',
			      'lsx' => 'text/x-la-asf',
			      'ltx' => 'application/x-latex',
			      'lzh' => 'application/octet-stream',
			      'lzh' => 'application/x-lzh',
			      'lzx' => 'application/lzx',
			      'lzx' => 'application/octet-stream',
			      'lzx' => 'application/x-lzx',
			      'm' => 'text/plain',
			      'm' => 'text/x-m',
			      'm1v' => 'video/mpeg',
			      'm2a' => 'audio/mpeg',
			      'm2v' => 'video/mpeg',
			      'm3u' => 'audio/x-mpequrl',
			      'man' => 'application/x-troff-man',
			      'map' => 'application/x-navimap',
			      'mar' => 'text/plain',
			      'mbd' => 'application/mbedlet',
			      'mc' => 'application/x-magic-cap-package-10',
			      'mcd' => 'application/mcad',
			      'mcd' => 'application/x-mathcad',
			      'mcf' => 'image/vasa',
			      'mcf' => 'text/mcf',
			      'mcp' => 'application/netmc',
			      'me' => 'application/x-troff-me',
			      'mht' => 'message/rfc822',
			      'mhtml' => 'message/rfc822',
			      'mid' => 'application/x-midi',
			      'mid' => 'audio/midi',
			      'mid' => 'audio/x-mid',
			      'mid' => 'audio/x-midi',
			      'mid' => 'music/crescendo',
			      'mid' => 'x-music/x-midi',
			      'midi' => 'application/x-midi',
			      'midi' => 'audio/midi',
			      'midi' => 'audio/x-mid',
			      'midi' => 'audio/x-midi',
			      'midi' => 'music/crescendo',
			      'midi' => 'x-music/x-midi',
			      'mif' => 'application/x-frame',
			      'mif' => 'application/x-mif',
			      'mime' => 'message/rfc822',
			      'mime' => 'www/mime',
			      'mjf' => 'audio/x-vndaudioexplosionmjuicemediafile',
			      'mjpg' => 'video/x-motion-jpeg',
			      'mm' => 'application/base64',
			      'mm' => 'application/x-meme',
			      'mme' => 'application/base64',
			      'mod' => 'audio/mod',
			      'mod' => 'audio/x-mod',
			      'moov' => 'video/quicktime',
			      'mov' => 'video/quicktime',
			      'movie' => 'video/x-sgi-movie',
			      'mp2' => 'audio/mpeg',
			      'mp2' => 'audio/x-mpeg',
			      'mp2' => 'video/mpeg',
			      'mp2' => 'video/x-mpeg',
			      'mp2' => 'video/x-mpeq2a',
			      'mp3' => 'audio/mpeg3',
			      'mp3' => 'audio/x-mpeg-3',
			      'mp3' => 'video/mpeg',
			      'mp3' => 'video/x-mpeg',
			      'mpa' => 'audio/mpeg',
			      'mpa' => 'video/mpeg',
			      'mpc' => 'application/x-project',
			      'mpe' => 'video/mpeg',
			      'mpeg' => 'video/mpeg',
			      'mpg' => 'audio/mpeg',
			      'mpg' => 'video/mpeg',
			      'mpga' => 'audio/mpeg',
			      'mpp' => 'application/vndms-project',
			      'mpt' => 'application/x-project',
			      'mpv' => 'application/x-project',
			      'mpx' => 'application/x-project',
			      'mrc' => 'application/marc',
			      'ms' => 'application/x-troff-ms',
			      'mv' => 'video/x-sgi-movie',
			      'my' => 'audio/make',
			      'mzz' => 'application/x-vndaudioexplosionmzz',
			      'nap' => 'image/naplps',
			      'naplps' => 'image/naplps',
			      'nc' => 'application/x-netcdf',
			      'ncm' => 'application/vndnokiaconfiguration-message',
			      'nif' => 'image/x-niff',
			      'niff' => 'image/x-niff',
			      'nix' => 'application/x-mix-transfer',
			      'nsc' => 'application/x-conference',
			      'nvd' => 'application/x-navidoc',
			      'o' => 'application/octet-stream',
			      'oda' => 'application/oda',
			      'omc' => 'application/x-omc',
			      'omcd' => 'application/x-omcdatamaker',
			      'omcr' => 'application/x-omcregerator',
			      'p' => 'text/x-pascal',
			      'p10' => 'application/pkcs10',
			      'p10' => 'application/x-pkcs10',
			      'p12' => 'application/pkcs-12',
			      'p12' => 'application/x-pkcs12',
			      'p7a' => 'application/x-pkcs7-signature',
			      'p7c' => 'application/pkcs7-mime',
			      'p7c' => 'application/x-pkcs7-mime',
			      'p7m' => 'application/pkcs7-mime',
			      'p7m' => 'application/x-pkcs7-mime',
			      'p7r' => 'application/x-pkcs7-certreqresp',
			      'p7s' => 'application/pkcs7-signature',
			      'part' => 'application/pro_eng',
			      'pas' => 'text/pascal',
			      'pbm' => 'image/x-portable-bitmap',
			      'pcl' => 'application/vndhp-pcl',
			      'pcl' => 'application/x-pcl',
			      'pct' => 'image/x-pict',
			      'pcx' => 'image/x-pcx',
			      'pdb' => 'chemical/x-pdb',
			      'pdf' => 'application/pdf',
			      'pfunk' => 'audio/make',
			      'pgm' => 'image/x-portable-greymap',
			      'pic' => 'image/pict',
			      'pict' => 'image/pict',
			      'pkg' => 'application/x-newton-compatible-pkg',
			      'pko' => 'application/vndms-pkipko',
			      'pl' => 'text/plain',
			      'pl' => 'text/x-scriptperl',
			      'plx' => 'application/x-pixclscript',
			      'pm' => 'image/x-xpixmap',
			      'pm' => 'text/x-scriptperl-module',
			      'pm4' => 'application/x-pagemaker',
			      'pm5' => 'application/x-pagemaker',
			      'png' => 'image/png',
			      'pnm' => 'application/x-portable-anymap',
			      'pnm' => 'image/x-portable-anymap',
			      'pot' => 'application/mspowerpoint',
			      'pot' => 'application/vndms-powerpoint',
			      'pov' => 'model/x-pov',
			      'ppa' => 'application/vndms-powerpoint',
			      'ppm' => 'image/x-portable-pixmap',
			      'pps' => 'application/mspowerpoint',
			      'pps' => 'application/vndms-powerpoint',
			      'ppt' => 'application/mspowerpoint',
			      'ppt' => 'application/powerpoint',
			      'ppt' => 'application/vndms-powerpoint',
			      'ppt' => 'application/x-mspowerpoint',
			      'ppz' => 'application/mspowerpoint',
			      'pre' => 'application/x-freelance',
			      'prt' => 'application/pro_eng',
			      'ps' => 'application/postscript',
			      'psd' => 'application/octet-stream',
			      'pvu' => 'paleovu/x-pv',
			      'pwz' => 'application/vndms-powerpoint',
			      'py' => 'text/x-scriptphyton',
			      'pyc' => 'applicaiton/x-bytecodepython',
			      'qcp' => 'audio/vndqcelp',
			      'qd3' => 'x-world/x-3dmf',
			      'qd3d' => 'x-world/x-3dmf',
			      'qif' => 'image/x-quicktime',
			      'qt' => 'video/quicktime',
			      'qtc' => 'video/x-qtc',
			      'qti' => 'image/x-quicktime',
			      'qtif' => 'image/x-quicktime',
			      'ra' => 'audio/x-pn-realaudio',
			      'ra' => 'audio/x-pn-realaudio-plugin',
			      'ra' => 'audio/x-realaudio',
			      'ram' => 'audio/x-pn-realaudio',
			      'ras' => 'application/x-cmu-raster',
			      'ras' => 'image/cmu-raster',
			      'ras' => 'image/x-cmu-raster',
			      'rast' => 'image/cmu-raster',
			      'rexx' => 'text/x-scriptrexx',
			      'rf' => 'image/vndrn-realflash',
			      'rgb' => 'image/x-rgb',
			      'rm' => 'application/vndrn-realmedia',
			      'rm' => 'audio/x-pn-realaudio',
			      'rmi' => 'audio/mid',
			      'rmm' => 'audio/x-pn-realaudio',
			      'rmp' => 'audio/x-pn-realaudio',
			      'rmp' => 'audio/x-pn-realaudio-plugin',
			      'rng' => 'application/ringing-tones',
			      'rng' => 'application/vndnokiaringing-tone',
			      'rnx' => 'application/vndrn-realplayer',
			      'roff' => 'application/x-troff',
			      'rp' => 'image/vndrn-realpix',
			      'rpm' => 'audio/x-pn-realaudio-plugin',
			      'rt' => 'text/richtext',
			      'rt' => 'text/vndrn-realtext',
			      'rtf' => 'application/rtf',
			      'rtf' => 'application/x-rtf',
			      'rtf' => 'text/richtext',
			      'rtx' => 'application/rtf',
			      'rtx' => 'text/richtext',
			      'rv' => 'video/vndrn-realvideo',
			      's' => 'text/x-asm',
			      's3m' => 'audio/s3m',
			      'saveme' => 'aapplication/octet-stream',
			      'sbk' => 'application/x-tbook',
			      'scm' => 'application/x-lotusscreencam',
			      'scm' => 'text/x-scriptguile',
			      'scm' => 'text/x-scriptscheme',
			      'scm' => 'video/x-scm',
			      'sdml' => 'text/plain',
			      'sdp' => 'application/sdp',
			      'sdp' => 'application/x-sdp',
			      'sdr' => 'application/sounder',
			      'sea' => 'application/sea',
			      'sea' => 'application/x-sea',
			      'set' => 'application/set',
			      'sgm' => 'text/sgml',
			      'sgm' => 'text/x-sgml',
			      'sgml' => 'text/sgml',
			      'sgml' => 'text/x-sgml',
			      'sh' => 'application/x-bsh',
			      'sh' => 'application/x-sh',
			      'sh' => 'application/x-shar',
			      'sh' => 'text/x-scriptsh',
			      'shar' => 'application/x-bsh',
			      'shar' => 'application/x-shar',
			      'shtml' => 'text/html',
			      'shtml' => 'text/x-server-parsed-html',
			      'sid' => 'audio/x-psid',
			      'sit' => 'application/x-sit',
			      'sit' => 'application/x-stuffit',
			      'skd' => 'application/x-koan',
			      'skm' => 'application/x-koan',
			      'skp' => 'application/x-koan',
			      'skt' => 'application/x-koan',
			      'sl' => 'application/x-seelogo',
			      'smi' => 'application/smil',
			      'smil' => 'application/smil',
			      'snd' => 'audio/basic',
			      'snd' => 'audio/x-adpcm',
			      'sol' => 'application/solids',
			      'spc' => 'application/x-pkcs7-certificates',
			      'spc' => 'text/x-speech',
			      'spl' => 'application/futuresplash',
			      'spr' => 'application/x-sprite',
			      'sprite' => 'application/x-sprite',
			      'src' => 'application/x-wais-source',
			      'ssi' => 'text/x-server-parsed-html',
			      'ssm' => 'application/streamingmedia',
			      'sst' => 'application/vndms-pkicertstore',
			      'step' => 'application/step',
			      'stl' => 'application/sla',
			      'stl' => 'application/vndms-pkistl',
			      'stl' => 'application/x-navistyle',
			      'stp' => 'application/step',
			      'sv4cpio' =>'application/x-sv4cpio',
			      'sv4crc' => 'application/x-sv4crc',
			      'svf' => 'image/vnddwg',
			      'svf' => 'image/x-dwg',
			      'svr' => 'application/x-world',
			      'svr' => 'x-world/x-svr',
			      'swf' => 'application/x-shockwave-flash',
			      't' => 'application/x-troff',
			      'talk' => 'text/x-speech',
			      'tar' => 'application/x-tar',
			      'tbk' => 'application/toolbook',
			      'tbk' => 'application/x-tbook',
			      'tcl' => 'application/x-tcl',
			      'tcl' => 'text/x-scripttcl',
			      'tcsh' => 'text/x-scripttcsh',
			      'tex' => 'application/x-tex',
			      'texi' => 'application/x-texinfo',
			      'texinfo' =>' lication/x-texinfo',
			      'text' => 'application/plain',
			      'text' => 'text/plain',
			      'tgz' => 'application/gnutar',
			      'tgz' => 'application/x-compressed',
			      'tif' => 'image/tiff',
			      'tif' => 'image/x-tiff',
			      'tiff' => 'image/tiff',
			      'tiff' => 'image/x-tiff',
			      'tr' => 'application/x-troff',
			      'tsi' => 'audio/tsp-audio',
			      'tsp' => 'application/dsptype',
			      'tsp' => 'audio/tsplayer',
			      'tsv' => 'text/tab-separated-values',
			      'turbot' => 'image/florian',
			      'txt' => 'text/plain',
			      'uil' => 'text/x-uil',
			      'uni' => 'text/uri-list',
			      'unis' => 'text/uri-list',
			      'unv' => 'application/i-deas',
			      'uri' => 'text/uri-list',
			      'uris' => 'text/uri-list',
			      'ustar' => 'application/x-ustar',
			      'ustar' => 'multipart/x-ustar',
			      'uu' => 'application/octet-stream',
			      'uu' => 'text/x-uuencode',
			      'uue' => 'text/x-uuencode',
			      'vcd' => 'application/x-cdlink',
			      'vcs' => 'text/x-vcalendar',
			      'vda' => 'application/vda',
			      'vdo' => 'video/vdo',
			      'vew' => 'application/groupwise',
			      'viv' => 'video/vivo',
			      'viv' => 'video/vndvivo',
			      'vivo' => 'video/vivo',
			      'vivo' => 'video/vndvivo',
			      'vmd' => 'application/vocaltec-media-desc',
			      'vmf' => 'application/vocaltec-media-file',
			      'voc' => 'audio/voc',
			      'voc' => 'audio/x-voc',
			      'vos' => 'video/vosaic',
			      'vox' => 'audio/voxware',
			      'vqe' => 'audio/x-twinvq-plugin',
			      'vqf' => 'audio/x-twinvq',
			      'vql' => 'audio/x-twinvq-plugin',
			      'vrml' => 'application/x-vrml',
			      'vrml' => 'model/vrml',
			      'vrml' => 'x-world/x-vrml',
			      'vrt' => 'x-world/x-vrt',
			      'vsd' => 'application/x-visio',
			      'vst' => 'application/x-visio',
			      'vsw' => 'application/x-visio',
			      'w60' => 'application/wordperfect60',
			      'w61' => 'application/wordperfect61',
			      'w6w' => 'application/msword',
			      'wav' => 'audio/wav',
			      'wav' => 'audio/x-wav',
			      'wb1' => 'application/x-qpro',
			      'wbmp' => 'image/vndwapwbmp',
			      'web' => 'application/vndxara',
			      'wiz' => 'application/msword',
			      'wk1' => 'application/x-123',
			      'wmf' => 'windows/metafile',
			      'wml' => 'text/vndwapwml',
			      'wmlc' => 'application/vndwapwmlc',
			      'wmls' => 'text/vndwapwmlscript',
			      'wmlsc' => 'application/vndwapwmlscriptc',
			      'word' => 'application/msword',
			      'wp' => 'application/wordperfect',
			      'wp5' => 'application/wordperfect',
			      'wp5' => 'application/wordperfect60',
			      'wp6' => 'application/wordperfect',
			      'wpd' => 'application/wordperfect',
			      'wpd' => 'application/x-wpwin',
			      'wq1' => 'application/x-lotus',
			      'wri' => 'application/mswrite',
			      'wri' => 'application/x-wri',
			      'wrl' => 'application/x-world',
			      'wrl' => 'model/vrml',
			      'wrl' => 'x-world/x-vrml',
			      'wrz' => 'model/vrml',
			      'wrz' => 'x-world/x-vrml',
			      'wsc' => 'text/scriplet',
			      'wsrc' => 'application/x-wais-source',
			      'wtk' => 'application/x-wintalk',
			      'xbm' => 'image/x-xbitmap',
			      'xbm' => 'image/x-xbm',
			      'xbm' => 'image/xbm',
			      'xdr' => 'video/x-amt-demorun',
			      'xgz' => 'xgl/drawing',
			      'xif' => 'image/vndxiff',
			      'xl' => 'application/excel',
			      'xla' => 'application/excel',
			      'xla' => 'application/x-excel',
			      'xla' => 'application/x-msexcel',
			      'xlb' => 'application/excel',
			      'xlb' => 'application/vndms-excel',
			      'xlb' => 'application/x-excel',
			      'xlc' => 'application/excel',
			      'xlc' => 'application/vndms-excel',
			      'xlc' => 'application/x-excel',
			      'xld' => 'application/excel',
			      'xld' => 'application/x-excel',
			      'xlk' => 'application/excel',
			      'xlk' => 'application/x-excel',
			      'xll' => 'application/excel',
			      'xll' => 'application/vndms-excel',
			      'xll' => 'application/x-excel',
			      'xlm' => 'application/excel',
			      'xlm' => 'application/vndms-excel',
			      'xlm' => 'application/x-excel',
			      'xls' => 'application/excel',
			      'xls' => 'application/vndms-excel',
			      'xls' => 'application/x-excel',
			      'xls' => 'application/x-msexcel',
			      'xlt' => 'application/excel',
			      'xlt' => 'application/x-excel',
			      'xlv' => 'application/excel',
			      'xlv' => 'application/x-excel',
			      'xlw' => 'application/excel',
			      'xlw' => 'application/vndms-excel',
			      'xlw' => 'application/x-excel',
			      'xlw' => 'application/x-msexcel',
			      'xm' => 'audio/xm',
			      'xml' => 'application/xml',
			      'xml' => 'text/xml',
			      'xmz' => 'xgl/movie',
			      'xpix' => 'application/x-vndls-xpix',
			      'xpm' => 'image/x-xpixmap',
			      'xpm' => 'image/xpm',
			      'x-png' => 'image/png',
			      'xsr' => 'video/x-amt-showrun',
			      'xwd' => 'image/x-xwd',
			      'xwd' => 'image/x-xwindowdump',
			      'xyz' => 'chemical/x-pdb',
			      'z' => 'application/x-compress',
			      'z' => 'application/x-compressed',
			      'zip' => 'application/x-compressed',
			      'zip' => 'application/x-zip-compressed',
			      'zip' => 'application/zip',
			      'zip' => 'multipart/x-zip',
			      'zoo' => 'application/octet-stream',
			      'zsh' => 'text/x-scriptzsh)'
			);
			if($mime_types[(strtolower(substr(strrchr($file_name, '.'), 1)))]){
				return $mime_types[(strtolower(substr(strrchr($file_name, '.'), 1)))];
			}else{
				$this->response('',401);
			}
		}
	}

	$api = new APIGet;
	$api->processApi();
?>
