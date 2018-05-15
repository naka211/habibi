<?php
/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license
*/
if(!class_exists('CometChat')){
	class CometChat {
	}
}

if(!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}

class CometChatUpdate extends CometChat {
/*
	CometChatUpdate  constructor
*/
	public $filehasharray = array();
	public $directoryhasharray = array();
	public $writablepath ;
	public $latest_v;
	public $basePath;
	public $integration;
	public $livesoftware;
	public $licensekey;

	function __construct($latest_v,$integration,$licensekey){
		$this->latest_v = $latest_v;
		$this->integration = $integration;
		$this->licensekey = $licensekey;
		$this->basePath = dirname(dirname(__FILE__)).DS;
		$this->writablepath = $this->basePath.'writable'.DS;
		$this->livesoftware = (empty($_COOKIE['software-dev'])) ? 'software' : 'software-dev';
	}
/*
	Checks if cometchat.zip file is present in updates folder.
*/
	public function checkAvailableZip(){
		if(!empty($this->latest_v)){
			if(file_exists($this->writablepath.'updates'.DS.$this->latest_v.DS.'cometchat.zip')){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function getTokenKey(){
		$protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
		$callback = $protocol.'://'.$_SERVER['SERVER_NAME']."/";
		if (filter_var(BASE_URL, FILTER_VALIDATE_URL)) {
			$callback = BASE_URL.'admin/update/index.php';
		}else{
			$callback = $protocol.'://'.$_SERVER['SERVER_NAME'].BASE_URL.'admin/update/index.php';
		}
		$url = "https://my.cometchat.com/".$this->livesoftware."/getupdate/?";
		$url .= "integration=".$this->integration;
		$url .= "&license=".$this->licensekey;
		$url .= "&callback_url=".$callback;
		$response = $this->curl_call($url, array());
		if (is_array($response) && array_key_exists("error",$response) && $response['error'] == 1) {
			$response['error'] = 1;
			$response['message'] = "Unable to make request to CometChat api";
		} else {
			$response = json_decode($response,true);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

	public function downloadLatestPackage($token = ''){
		if(empty($token)){
			$response = array('error' => 1, 'message' => 'Cannot find the token, please retry.');
		} else {
			$this->createDirectory($this->writablepath."updates".DS.$this->latest_v);
			$url = 'https://my.cometchat.com/'.$this->livesoftware.'/getdownload/?';
			$url .= "token=".$token;
			$data = $this->curl_call($url,array());
			$file = $this->writablepath."updates".DS.$this->latest_v.DS."cometchat.zip";

			if (is_array($data) &&  array_key_exists("error",$data) && $data['error'] == 1) {
				$response['error'] = 1;
				$response['message'] = 'Unable to make request to download CometChat api, please download the CometChat from <a href="http://my.cometchat.com" target="_blank">my.cometchat.com</a> and manually place it in /cometchat/writable/updates/'.$this->$latest_v.'/cometchat.zip ';
			} else {
				file_put_contents($file, $data);
				if (filesize($file) > 0) {
					$response = array('error'=>0,'message'=> 'CometChat zip downloaded succssfully');
				} else {
					$response = array('error'=>1,'message'=> 'Unable to save the zip file please download the CometChat from <a href="http://my.cometchat.com" target="_blank">my.cometchat.com</a> and manually place it in /cometchat/writable/updates/'.$this->latest_v.'/cometchat.zip');
				}
			}
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

/*
	Extract zip file
*/
	public function extractZip(){
		if(!empty($this->latest_v)){
			$path = $this->writablepath.'updates'.DS.$this->latest_v.DS.'cometchat.zip';
			$to = $this->writablepath.'updates'.DS.$this->latest_v.DS;
			if(file_exists($path)){
				if(class_exists('ZipArchive')){
					$zip = new ZipArchive();
					$x = $zip->open($path);
					if ($x === true) {
						$zip->extractTo($to);
						$zip->close();
						unlink($path);
						$response = array('error' => 0, 'message' => 'Zip file extracted successfully');
					}else{
						$response = array('error' => 1, 'message' => 'Fail to extract the zip file. <b>Please Check permission of file: </b>'.$path);
					}
				}else{
					include_once(dirname(dirname(__FILE__)).DS.'functions'.DS.'archive'.DS.'pclzip.lib.php');
					$archive = new PclZip($path);
					if ($archive->extract(PCLZIP_OPT_PATH, $to) == 0) {
						$response = array('error' => 1, 'message' => 'Fail to extract the zip file');
					}else{
						$response = array('error' => 0, 'message' => 'Zip file extracted successfully');
					}
				}
			}
		} else {
			$response = array('error' => 1, 'message' => 'Please download the Latest CometChat package.');
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

/*
	Get the hash of given version stored in session
*/
	public function createHash() {
		global $currentversion;
		@session_start();
		$_SESSION['cometchat']['hashes'][$currentversion] = array();
		if (file_exists($this->writablepath."hashes".DS.$currentversion.".php")) {
			include_once($this->writablepath."hashes".DS.$currentversion.".php");
		}

		if (!empty($calhash)) {
			$files = scandir($this->basePath);
			sort($files);
			$filehash = array();
			foreach($files as $key => $value) {
				$path = realpath($this->basePath.DS.$value);
				if(!is_dir($path) ) {
					if($value != 'integration.php' && $value != 'license.php' && $value !='cloud' && $value !='cometchat_update.php' && $value != 'environment.default.php' && $value != 'environment.php' && $value != 'localhost.default.php' && $value != 'localhost.php' && $value !='api/api.php'){
						$hash = md5_file($path);
						$filehash[] = $hash;
					}
				} else if($value != "." && $value != ".." && $value != 'writable') {
					if(in_array($value, array('extensions','modules','plugins','transports'))){
						$extensions_dir = $this->basePath.DS.$value;
						$handle = scandir($extensions_dir);
						sort($handle);
						foreach($handle as $key_temp => $value_temp) {
							$path_temp = realpath($extensions_dir.DS.$value_temp);
							if(is_dir($path_temp) && $value_temp != "." && $value_temp != ".."){
								$dirhash = $this->directoryHash($path_temp);
								$this->filehasharray['directoryhash'][$value.'/'.$value_temp] = $dirhash;
							}
						}
					}else{
						$dirhash = $this->directoryHash($path);
						$this->filehasharray['directoryhash'][$value] = $dirhash;
					}
				}
			}
			if (empty($filehash)) {
				$response = array('error' => 1,'message' => 'Error occured while generating hash.');
			} else {
				$response = array('error' => 0,'message' => 'Hash generated succssfully.');
				$this->filehasharray['fileshash'] = md5(implode('', $filehash));
				unset($_SESSION['cometchat']['hashes']);
				$_SESSION['cometchat']['hashes'][$currentversion] = $this->filehasharray;
			}
		} else {
			$response = array('error' => 1,'message' => 'Hash file not present for installed CometChat package.');
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}
/*
	generate hash of cometchat with all files
*/
	public function generateHash() {
		global $currentversion;
		$files = scandir($this->basePath);
		sort($files);
		$filehash = array();
		foreach($files as $key => $value){
			$path = realpath($this->basePath.$value);
			if(!is_dir($path) ) {
				if($value != 'integration.php' && $value != 'license.php' && $value !='cloud' && $value !='cometchat_update.php' && $value != 'environment.default.php' && $value != 'environment.php' && $value != 'localhost.default.php' && $value != 'localhost.php' && $value !='api/api.php'){
					$hash = md5_file($path);
					$filehash[] = $hash;
					$this->filehasharray['files'][] = $value;
				}
			} else if($value != "." && $value != ".." && $value != 'writable') {
				if(in_array($value, array('extensions','modules','plugins','transports'))){
					$extensions_dir = $this->basePath.$value;
					$handle = scandir($extensions_dir);
					sort($handle);
					foreach($handle as $key_temp => $value_temp){
						$path_temp = realpath($extensions_dir.DS.$value_temp);
						if(is_dir($path_temp) && $value_temp != "." && $value_temp != ".."){
							$dirhash = $this->directoryHash($path_temp);
							$this->filehasharray['directory'][$value.'/'.$value_temp] = $dirhash;
						}
					}
				}else{
					$dirhash = $this->directoryHash($path);
					$this->filehasharray['directory'][$value] = $dirhash;
				}
			}
		}
		$this->filehasharray['fileshash'] = md5(implode('', $filehash));
		ksort($this->filehasharray);
		$exported = var_export($this->filehasharray, TRUE);
		file_put_contents($this->writablepath."hashes".DS.$currentversion.".php", '<?php $calhash = ' . $exported . '; ?>');
	}
/*
	Compare hash with present hash files and computed hash files
*/
	public function compareHashes(){
		global $currentversion;
		$response = array();
		$modify = 0;
		if(file_exists($this->writablepath."hashes".DS.$currentversion.".php")){
			include_once($this->writablepath."hashes".DS.$currentversion.".php");
			$this->filehasharray = $_SESSION['cometchat']['hashes'][$currentversion];
			if($calhash['fileshash'] != $this->filehasharray['fileshash']){
				$response = array('error' => 1, 'modify' => 1, 'message' => "It seems that some of the core files of CometChat are modified on your server.
					Updating CometChat will overwrite these files.
					Do you still want to continue?");
			}else{
				foreach ($this->filehasharray['directoryhash'] as $key => $value) {
					if($value != $calhash['directory'][$key]){
						$modify = 1;
						break;
					}
				}
				$response = ($modify == 0) ? array('error' => 0, 'modify' => 0, 'message' => '') : array('modify' => 1, 'message' => 'It seems that some of the core files of CometChat are modified on your server.
					Updating CometChat will overwrite these files.<br>Do you still want to continue?');
			}
		}else{
			$response = array('error' => 1, 'modify' => 1,'message' => 'CometChat current version hash not present.');
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}


/*
	Ask client to continue or skip update process
*/
	public function backupFiles(){
		global $currentversion;
		ini_set('max_execution_time', 3000);
		$response = array();
		$this->createDirectory($this->writablepath.'updates'.DS.$currentversion.DS.'cometchat_backup');
		$dest = $this->writablepath.'updates'.DS.$currentversion.DS.'cometchat_backup';
		$this->copyFiles($this->basePath, $dest,array('writable'));
		$response = array('error' => 0,'message' => 'Backup of core files done succssfully');
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

	public function applyChanges() {
		global $currentversion;
		ini_set('max_execution_time', 3000);
		$_SESSION['cometchat']['old_version'] = $currentversion;
		if(!empty($this->latest_v)){
			if(is_dir($this->writablepath.'updates'.DS.$this->latest_v.DS.'cometchat')) {
				if(is_writable($this->basePath)) {
					$exclude = array('writable','update.m.php','CometChatUpdate.php','integration.php','extra.js','extra.css','admin');
					$this->deleteFiles(
						$this->basePath,
						$exclude,
						$this->basePath
					);
					$this->deleteFiles(
						$this->basePath.DS."admin",
						array('update.m.php','CometChatUpdate.php'),
						$this->basePath.DS."admin"
					);
					$this->copyFiles(
						$this->writablepath.'updates'.DS.$this->latest_v.DS.'cometchat',
						$this->basePath,
						array('writable','integration.php','extra.js','extra.css')
					);
					$this->copyFiles(
						$this->writablepath.'updates'.DS.$this->latest_v.DS.'cometchat'.DS.'writable'.DS.'hashes',
						$this->basePath.DS.'writable'.DS.'hashes',
						$exclude
					);
					$this->deleteFiles(
						$this->writablepath.'cache',
						array('index.html'),
						$this->writablepath.'cache'
					);
					$this->DBChanges();
					$response = array('error' => 0,'message' => 'Apply changes succssfully.');
				} else {
					$response = array('error' => 1,'message' => 'Permission denied. Please make directory: '.$this->basePath." writable");
				}
			} else {
				$response = array('error' => 1,'message' => 'New extracted core package files are not found.');
			}
		}else{
			$response = array('error' => 1,'message' => 'Backup of core files done succssfully');
		}
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}


	public function directoryHash($directory){
		if (! is_dir($directory)){
			return false;
		}
		$forcefiles = array('.','..','integration.php','writable');
		$files = array();
		$dir = dir($directory);
		while (false !== ($file = $dir->read())){
			if (!in_array($file, $forcefiles)){
				if (is_dir($directory . DS . $file)){
					$files[] = $this->directoryHash($directory . DS . $file);
				}else{
					$file_ext =  strtolower(pathinfo($file,PATHINFO_EXTENSION));
					$allowed_ext = array('php','xml','js','json','css','htaccess','svg','txt','sql');
					if(in_array($file_ext, $allowed_ext)){
						$files[] = md5_file($directory . DS . $file);
					}
				}
			}
		}
		$dir->close();
		sort($files);
		return md5(implode('', $files));
	}

	public function DBChanges(){
		$files = array();
		$oldversion = !empty($_SESSION['cometchat']['old_version']) ? $_SESSION['cometchat']['old_version'] : '' ;
		$dir = opendir($this->basePath.DS.'updates');
		if(is_dir($this->basePath.DS.'updates')){
			while(false !== ( $file = readdir($dir)) ) {
				if($file != '.' && $file != '..'){
					$files[] = $file;
				}
			}
		}
		$versions = array();
		foreach ($files as $key => $value) {
			if($value >= $oldversion){
				include_once($this->basePath.DS.'updates'.DS.$value);
			}
		}

	}
	public function curl_call($url, $postdata) {
		if(!empty($url)) {
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			if(!empty($postdata)){
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			} else {
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			}

			$result = curl_exec($ch);
			if(curl_errno($ch)){
				$result = array('error'=>1,'message'=> curl_error($ch));
			}
			curl_close($ch);
		}
	    return $result;
	}
	private function createDirectory($directory){
	    if (!is_dir($directory)){
	        mkdir($directory,0777,true) ;
	    }
	}
	function deleteFiles($dir,$exclude,$nodelete) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != ".." && !in_array($object, $exclude) ) {
					if (is_dir($dir.DS.$object)){
						$this->deleteFiles($dir.DS.$object,$exclude,$nodelete);
					}else{
						@unlink($dir.DS.$object);
					}
				}
			}
			if($dir != $nodelete ){
				@rmdir($dir);
			}
		}
	}

	function copyFiles($src, $dst,$exclude) {
		$dir = opendir($src);
		$this->createDirectory($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' ) && !in_array($file, $exclude)) {
				if ( is_dir($src . DS . $file) ) {
					$this->copyFiles($src . DS . $file,$dst . DS . $file,$exclude);
				}
				else {
					@copy($src . DS . $file,$dst . DS . $file);
				}
			}
		}
		closedir($dir);
	}
}
global $update, $licensekey, $latest_vesion;
$update = new CometChatUpdate($latest_vesion,$cms,$licensekey);
