<?php 

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
define(MAX_UPLOAD_FILE_SIZE, 10000);
define(MAX_WIDTH,1000);
define(MAX_HEIGHT,1000);
define(UPLOAD_FOLDER,'../uploads/images/');

	// $validMIMETypes = array(
	// 	'image/jpg',
	// 	'image/jpeg',
	// 	'image/png'
	// );
	// $validTypes = ['png','jpeg','jpg'];
	// $fileType = $_FILES['file']['type'];
function checkUploadFile($validTypes,$validMIMETypes){
	if(in_array($fileType,$validTypes){
		$size = $_FILES['file']['size'];
		if($size > MAX_UPLOAD_FILE_SIZE){
			return false;
		}else{
			if(@getimagesize($_FILES['file']['tmp_name'])){
				
				$list($width, $height,$type,$attr) = @getimagesize($_FILES['file']['tmp_name']);
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
		$list($width, $height,$type,$attr) = @getimagesize($_FILES['file']['tmp_name']);
		$name = UPLOAD_FOLDER. microtime(true) . '.' . $type;
		return $name;
	}
}