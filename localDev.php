<?php 

define(MAX_UPLOAD_FILE_SIZE, 10000);
define(MAX_WIDTH,1000);
define(MAX_HEIGHT,1000);
define(UPLOAD_FOLDER,'../uploads/images/');

function checkWritable($input){
	if(is_dir($checkWritable)){
		//try to create a file in this folder.
		try{
			$fileName = random();
			$res = @fopen($fileName, 'a');
			if($res){
				return true;
			}else{
				return false;
			}
		}catch(\Exception $exp){
			echo $exp->getMessage();
			exit;
		}
	}else{
		return is_writeable($input);
	}
}


$validMIMETypes = array(
	'image/jpg',
	'image/jpeg',
	'image/png'
);
$validTypes = ['png','jpeg','jpg'];

function checkUploadFile($validTypes,$validMIMETypes){
	$fileType = $_FILES['file']['type'];
	if(in_array($fileType,$validTypes)){
		$size = $_FILES['file']['size'];
		if($size > MAX_UPLOAD_FILE_SIZE){
			return false;
		}else{
			if(@getimagesize($_FILES['file']['tmp_name'])){
				
				list($width, $height,$type,$attr) = @getimagesize($_FILES['file']['tmp_name']);
				if($width > MAX_WIDTH || $height > MAX_HEIGHT){
					return false;
				}else{
					if(in_array($type,$falidTypes)){
						return true;
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}
	}else{
		return false;
	}
}

function getUploadImagesName($prefix){
	$valid = checkUploadFile();
	if($valid){
		return NULL;
	}else{
		list($width, $height,$type,$attr) = @getimagesize($_FILES['file']['tmp_name']);
		$name = UPLOAD_FOLDER. microtime(true) . '.' . $type;
		return $name;
	}
}
/**
* 
*/
function fun_curl_post($url,$params,$cookies = []){
	$oCurl = curl_init();
	curl_setopt($oCurl, CURLOPT_POST, 1);
	curl_setopt($oCurl, CURLOPT_URL, $url);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, array_encode($params));
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER,0);
	if(!empty($cookies)){
		$cookieVal = '';
		foreach($cookies as $key=>$value){
			$cookieVal = urlencode($key).'='.urlencode($value).';';
		}
		curl_setopt($oCurl, CURLOPT_COOKIE, substr($cookieVal,0,-1));
	}
	$curlRes = curl_exec($oCurl);
	if($result == false){
		$result = array('code'=> 1, 'message'=>curl_error($oCurl),'result'=>NULL);
	}else{
		$httpCode  = curl_getinfo($oCurl,CURLINFO_HTTP_CODE);
		if($httpCode != 200){
			$result = array('code'=> 2, 'message'=>curl_error($iCurl),'result'=>NULL);
		}else{
			$result = array('code'=> 0, 'message'=> '', 'result'=>$curlRes);
		}
	}
	return json_encode($result);
}

function fun_sock_post($url,$params,$cookies=[]){
	$urlPieces = parse_url($url);
	$host = $urlPieces['host'];
	$port = !isset($urlPieces['port']) ? '80' : $urlPieces['port'];
	$path = !isset($urlPieces['path'] ) ? '/' : $urlPieces['path'];
	$sBreakLine = '\r\n';
	$sRequest  = 'POST '.$url. ' HTTP/1.1 '.$sBreakLine;
	$sRequest .= 'User-Agent: Mozilla/5.0'.$sBreakLine;
	$sRequest .= 'Host: '.$host.$sBreakLine;
	$sRequest .= 'Accept: text/html'.$sBreakLine;
	$sRequest .= 'Accept-lanaguage: zh-CN,zh;q=0.8,en;'.$sBreakLine;
	$sRequest .= 'Accept-Encoding: gzip, deflate, sdch, br'.$sBreakLine;
	$sParams = '';
	$cookieVal = '';
	if(!empty($cookies)){
		foreach($cookies as $key=>$value){
			$cookieVal = urlencode($key).'='.urlencode($value).'; ';
		}
		$cookieVal = substr($cookieVal,0,-2);
		$sRequest .= 'Cookie:'.$cookieVal;
	}
	foreach($params as $key=>$param){
		$sParams .= urlencode($key).'='.urlencode($param).'&';
	}
	if(!empty($sParams) && strlen($sParams) > 1){
		//remove the last &
		$sParams = substr($sParams,0, -1);
		$sRequest .= 'Content-type: application/www-x-form-urlencoded'.$sBreakLine;
		$sRequest .= 'Content-length:'.strlen($sParams).$sBreakLine;
		$sRequest .= $sParams.$sBreakLine;
	}
	$oSock = @fsockopen($host,$port,$errno,$errStr,$timeout);
	if($oSock == false){
		echo $errStr;
		return null;
	}else{
		fputs($oSock,$sRequest);
		$ret = '';
		while(!@feof($oSock)){
			$ret .= fgets($oSock,4096);
		}
		fclose($oScok);
	}
	
}

function fun_sock_get($url,$params,$cookies=[]){
	$urlPieces = parse_url($url);
	$host = $urlPieces['host'];
	$port = !isset($urlPieces['port']) ? '80' : $urlPieces['port'];
	$path = !isset($urlPieces['path'] ) ? $url.'/' : $urlPieces['path'];
	$sBreakLine = '\r\n';
	$sRequest  = 'GET '.$url.' HTTP/1.1'.$sBreakLine;
	$sRequest .= 'User-Agent: Mozilla/5.0'.$sBreakLine;
	$sRequest .= 'Host: '.$host.$sBreakLine;
	$sRequest .= 'Accept: text/html'.$sBreakLine;
	$sRequest .= 'Accept-lanaguage: zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4'.$sBreakLine;
	$sRequest .= 'Accept-Encoding: gzip, deflate, sdch'.$sBreakLine;
	$sRequest .= 'Connection: close'.$sBreakLine.$sBreakLine;
	$sParams = '';
	$cookieVal = '';
	if(!empty($cookies)){
		foreach($cookies as $key=>$value){
			$cookieVal = urlencode($key).'='.urlencode($value).'; ';
		}
		$cookieVal = substr($cookieVal,0,-2);
		$sRequest .= 'Cookie:'.$cookieVal;
	}

	$oSock = @fsockopen($host,$port,$errno,$errStr,2);
	if($oSock == false){
		echo $errno, $errStr;
		return null;
	}else{
		fputs($oSock,$sRequest);
		$ret = '';
		while(!@feof($oSock)){
			$ret .= fgets($oSock,4096);
		}
		fclose($oSock);
	}
	
}


$abc = fun_sock_get('http://192.168.83.35',['username'=>'15921526038','password'=>'123456a']);


class testClass implements Iterator{

	private $position;
	private $params = [];
	private $property_names = [];
	public function __construct($variables){

		$this->params = $variables;
		$this->property_names = array_keys($variables);
		$this->position = 0;
	}

	public function current (){
		$property_name = $this->property_names[$this->position];
		return $this->params[$property_name];
	}
	public function key (){
	    $property_name = $this->property_names[$this->position];
		return $property_name;
	}
	public function next (){
		++$this->position;
		if($this->position >= count($this->property_names)){
			return null;
		}else{
			$property_name = $this->property_names[$this->position];
			return $this->params[$property_name];
		}
	}
	public function rewind (){
		$this->position = 0;
	}
	public function valid (){
		return ($this->position < count($this->property_names));
	}
}

// $abc = new testClass(['a'=>10,'b'=>20,'c'=>30]);
// foreach($abc as $key=>$value){
// 	echo $key,$value;
// }


function testAbc($testStr){
	$fileName = 'abc.txt';
	$oFile = @fopen($fileName, 'r');
	$previousLine = '';
	$result = [];
	$lineNum = 1;
	while(!feof($oFile)){
		$line = fgets($oFile,4096);
		echo $line;
		$matchLine = $previousLine.$line;
		$tempRes = [];
		$tempHashKeys = [];
		for($i = 0; $i < strlen($line); $i++){
			$tempPos = stripos($line,$testStr,$i);
			if($tempPos > -1){
				if(!isset($tempHashKeys[$tempPos])){
					$tempHashKeys[$tempPos] = 1;
					array_push($tempRes,$tempPos);
				}
			}
		}
		if(count($tempRes) > 0){
			$result[$lineNum] = $tempRes;
		}
		$lineNum++;
	}
	fclose($oFile);
	return $result;
}

$oTest = testAbc('abc');
