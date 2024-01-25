<?php
class General extends Database {
	public $objUpload;
	private $objCore;
	function __construct() {
		parent :: __construct();
		$this->objUpload = Factory :: getNewInstanceOf('upload');
		$this->objCore = Factory :: getNewInstanceOf('Core');

	}
	function imageUpload($argFILES, $argVarDirLocation, $varThumbnailWidth = '', $varThumbnailHeight = '', $varMediumWidth = '', $varMediumHeight = '') {

		$this->objUpload->setMaxSize();

		$this->objUpload->setDirectory($argVarDirLocation);
		$varIsImage = $this->objUpload->IsImageValid($argFILES['type']);
		if (!$varIsImage) {
			$this->objCore->setErrorMsg(IMAGE_TYPE_ERROR);
			return false;
		}

		$this->objUpload->setTmpName($argFILES['tmp_name']);

		if ($this->objUpload->userTmpName) {
			$this->objUpload->setFileSize($argFILES['size']);
			$this->objUpload->setFileType($argFILES['type']);
			$varRandomNumber = strtolower($this->generateRandomKey());
			$fName = $argFILES['name'];
			$info = pathinfo($fName);
			$fileExt = $info['extension'];
			$file_name = strtolower(basename($fName, '.' . $fileExt));
			$fileName = $varRandomNumber . '_' . $file_name . "." . $fileExt;
			$fileName = str_replace(' ', '_', $fileName);
			$var = $this->objUpload->setFileName($fileName);
			$this->objUpload->startCopy();

			if ($this->objUpload->isError()) //return true if there is no error
				{
				$thumbnailName1 = '_thumb';

				$this->objUpload->setThumbnailName($thumbnailName1);

				$thumbFileName = $varRandomNumber . '_' . $file_name . "_thumb." . $fileExt;
				$thumbFileName = str_replace(' ', '_', $thumbFileName);

				$this->objUpload->createThumbnail();
				if ($varThumbnailWidth == '' && $varThumbnailHeight == '') {
					$this->objUpload->setThumbnailSize();
				} else {
					$this->objUpload->setThumbnailSize($varThumbnailWidth, $varThumbnailHeight);
				}

				$varFileName = $this->objUpload->userFileName;
				return $varFileName;

				//return $thumbFileName;

			} else {
				$this->objCore->setErrorMsg($this->objUpload->error);
				return false;
			}

		}
	}

	function getRecord($argTable, $argArrColums, $argVarWhr = '', $argVarOrderBy = '', $argVarLimit = '') {
		$arrResult = $this->select($argTable, $argArrColums, $argVarWhr, $argVarOrderBy, $argVarLimit);
		if ($arrResult) {
			return $arrResult;
		} else {
			return false;
		}
	}

	function updateRecord($argVarTable, $argArrColumns, $argVarWhere) {
		$status = $this->update($argVarTable, $argArrColumns, $argVarWhere);
		if ($status) {
			return $status;
		} else {
			return false;
		}
	}

	function printValue($argValue = '') {
		if ($argValue == '') {
			return 'N/A';
		} else {
			return $argValue;
		}
	}

	function deleteImage($argVarImageName, $varPath) {
		//set main banner directory
		$varDirectory = $varPath;

		//set image thumb here
		$arrImageName = explode('.', $argVarImageName);
		$arrImageName['0'] = $arrImageName['0'] . '_thumb';
		$varImageThumb = implode('.', $arrImageName);
		//set image medium here
		$arrImageMedium = explode('.', $argVarImageName);
		$arrImageMedium['0'] = $arrImageMedium['0'] . '_mid';
		$varImageMedium = implode('.', $arrImageMedium);
		//find the main file and if found then delete it
		if (file_exists($varDirectory . $argVarImageName)) {
			unlink($varDirectory . $argVarImageName);
		}
		//find the thumb file and if found then delete it
		if (file_exists($varDirectory . $varImageThumb)) {
			unlink($varDirectory . $varImageThumb);
		}
		//find the medium file and if found then delete it
		if (file_exists($varDirectory . $varImageMedium)) {
			unlink($varDirectory . $varImageMedium);
		}
		return true;
	}

	function checkImageSize($argVarFile, $argVarMaxWidth, $argVarMaxHeight) {

		$arrCurrentImageDimesions = getimagesize($argVarFile); //get the uploaded image size
		if (file_exists) {
			//check the image size for any size violations
			if ($arrCurrentImageDimesions['0'] > $argVarMaxWidth || $arrCurrentImageDimesions['1'] > $argVarMaxHeight) {
				return false; // size violation.the image must be discarded.
			} else {
				return true; // no size violation.the image is ok.
			}
		}
	}
	function generateRandomKey($argLength = '', $argCharacterSet = '') {
		// CHARACTER SET.
		if ($argCharacterSet == '') {
			$varCharacterSet = '0123456789abcdefghijklmlopqrstuvwxyz';
		} else {
			$varCharacterSet = $argCharacterSet;
		}
		// CHECK FOR LENGTH OF KEY.
		if ($argLength == '') {
			// DEFAULT KEY LENGTH.
			$varLength = 8;
		} else {
			// USER DEFIND KEY LENGTH.
			$varLength = $argLength;
		}
		$varMax = strlen($varCharacterSet) - 1;
		$varValue = '';
		for ($i = 0; $i < $varLength; $i++) {
			$varValue .= $varCharacterSet {
				mt_rand(0, $varMax)
				};
		}
		// RANDOM KEY.
		return $varValue;
	}

	function insertRecord($argTable, $argArrColums) {
		return $this->insert($argTable, $argArrColums);
	}

	function getValidRandomKey($argVarTableName, $argArrColumns, $argVarWhereColumn, $argVarLength = '', $argVarCharacterSet = '', $argVarOption = '') {
		if ($argVarCharacterSet == '') 
		{
			$argVarCharacterSet = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		//if there is requirement to md5 or encrypt the key
		if ($argVarOption == 'md5') {
			//get a random key generated and its md5 calculated
			$varRandomKey = md5($this->generateRandomKey($argVarLength, $argVarCharacterSet));
		}
		if ($argVarOption == 'combine') {
			$varRandomKeyPartOne = $this->generateRandomKey('8', '1234567890');
			$varRandomKeyPartTwo = $this->generateRandomKey('10', '23456789abcdefghijkmnpqrstuvwxyz');
			$varRandomKey = $varRandomKeyPartOne . '.' . $varRandomKeyPartTwo;
		} else {
			//get a random key generated
			$varRandomKey = $this->generateRandomKey($argVarLength, $argVarCharacterSet);
		}
		//check for existence of key in the database
		//you can also send multiple columns here. For ex - send string like "Status = Active AND pkID". It will be generated like "Status = 'Active' AND pkID = '4ghg5tre4ty3fy5rt'"
		$varWhereCondition = $argVarWhereColumn . ' = \'' . $varRandomKey . '\'';
		if ($this->select($argVarTableName, $argArrColumns, $varWhereCondition)) {
			//call this function recursively if the key generated is not unique
			$this->getValidRandomKey($argVarTableName, $argArrColumns, $argVarWhereColumn, $argVarLength = '', $argVarCharacterSet = '', $argVarOption = '');
		} else {
			return $varRandomKey; //key is ok. return the key
		}
	}

	function fileUpload($argFILES, $argVarDirLocation) {

		$this->objUpload->setMaxSize();
		$this->objUpload->setDirectory($argVarDirLocation);
		$this->objUpload->setTmpName($argFILES['tmp_name']);

		if ($this->objUpload->userTmpName) { // Set file size
			$this->objUpload->setFileSize($argFILES['size']);
			$this->objUpload->setFileType($argFILES['type']); // Set File Type
			//$varRandomNumber = $this->generateRandomKey(); // Set File Name
			//print_r($argFILES['name']); die;
			$fileName = strtolower($argFILES['name']);//////////////////////////
		//print_r($fileName); die;
            $fileName = str_replace(' ', '_', $fileName); //replace space with an underscore
			$this->objUpload->setFileName($fileName); // Start Copy Process
			$this->objUpload->startCopy(); // If there is error write the error message		
			if ($this->objUpload->isError()) //return true if there is no error
				{
				$varFileName = $this->objUpload->userFileName;
				//Get file extention	
				return $varFileName;
			} else {
				$this->objCore->setErrorMsg(ERR_ON_UPLOAD);
				return false;
			}
		}
	}

	function deleteFile($argVarFileName, $varPath) {
		//set main banner directory
		$varDirectory = $varPath;
		//find the main file and if found then delete it
		if (file_exists($varDirectory . $varFileThumb)) {
			unlink($varDirectory . $argVarFileName);
		}
		return true;
	}

	/*-added new function by pksing-*/

	function uploadImage($fileName, $maxSize, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB, $maxH = null) {
		$folder = $relPath;
		$maxlimit = $maxSize;
		$allowed_ext = "jpg,jpeg,gif,png,bmp";
		$match = "";
		$filesize = $_FILES[$fileName]['size'];
		if ($filesize > 0) {
			$filename = strtolower($_FILES[$fileName]['name']);
			$filename = preg_replace('/\s/', '_', $filename);
			if ($filesize < 1) {
				$errorList[] = "File size is empty.";
			}
			if ($filesize > $maxlimit) {
				$errorList[] = "File size is too big.";
			}
			if (count($errorList) < 1) {
				$file_ext = preg_split("/\./", $filename);
				$allowed_ext = preg_split("/\,/", $allowed_ext);
				foreach ($allowed_ext as $ext) {
					if ($ext == end($file_ext)) {
						$match = "1"; // File is allowed
						$NUM = time();
						$front_name = substr($file_ext[0], 0, 15);
						$newfilename = $front_name . "_" . $NUM . "." . end($file_ext);
						$filetype = end($file_ext);
						$save = $folder . $newfilename;
						if (!file_exists($save)) {
							list ($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
							if ($maxH == null) {
								if ($width_orig < $maxW) {
									$fwidth = $width_orig;
								} else {
									$fwidth = $maxW;
								}
								$ratio_orig = $width_orig / $height_orig;
								$fheight = $fwidth / $ratio_orig;

								$blank_height = $fheight;
								$top_offset = 0;

							} else {
								if ($width_orig <= $maxW && $height_orig <= $maxH) {
									$fheight = $height_orig;
									$fwidth = $width_orig;
								} else {
									if ($width_orig > $maxW) {
										$ratio = ($width_orig / $maxW);
										$fwidth = $maxW;
										$fheight = ($height_orig / $ratio);
										if ($fheight > $maxH) {
											$ratio = ($fheight / $maxH);
											$fheight = $maxH;
											$fwidth = ($fwidth / $ratio);
										}
									}
									if ($height_orig > $maxH) {
										$ratio = ($height_orig / $maxH);
										$fheight = $maxH;
										$fwidth = ($width_orig / $ratio);
										if ($fwidth > $maxW) {
											$ratio = ($fwidth / $maxW);
											$fwidth = $maxW;
											$fheight = ($fheight / $ratio);
										}
									}
								}
								if ($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0) {
									die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
								}
								if ($fheight < 45) {
									$blank_height = 45;
									$top_offset = round(($blank_height - $fheight) / 2);
								} else {
									$blank_height = $fheight;
								}
							}
							$image_p = imagecreatetruecolor($fwidth, $blank_height);
							$white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
							imagefill($image_p, 0, 0, $white);
							switch ($filetype) {
								case "gif" :
									$image = @ imagecreatefromgif($_FILES[$fileName]['tmp_name']);
									break;
								case "jpg" :
									$image = @ imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
									break;
								case "jpeg" :
									$image = @ imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
									break;
								case "png" :
									$image = @ imagecreatefrompng($_FILES[$fileName]['tmp_name']);
									break;
							}
							@ imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
							switch ($filetype) {
								case "gif" :
									if (!@ imagegif($image_p, $save)) {
										$errorList[] = "PERMISSION DENIED [GIF]";
									}
									break;
								case "jpg" :
									if (!@ imagejpeg($image_p, $save, 100)) {
										$errorList[] = "PERMISSION DENIED [JPG]";
									}
									break;
								case "jpeg" :
									if (!@ imagejpeg($image_p, $save, 100)) {
										$errorList[] = "PERMISSION DENIED [JPEG]";
									}
									break;
								case "png" :
									if (!@ imagepng($image_p, $save, 0)) {
										$errorList[] = "PERMISSION DENIED [PNG]";
									}
									break;
							}
							@ imagedestroy($filename);
						} else {
							$errorList[] = "CANNOT MAKE IMAGE IT ALREADY EXISTS";
						}
					}
				}
			}
		} else {
			$errorList[] = "NO FILE SELECTED";
		}
		if (!$match) {
			$errorList[] = "File type isn't allowed: $filename";
		}
		if (sizeof($errorList) == 0) {
			return $fullPath . $newfilename;
		} else {
			$eMessage = array ();
			for ($x = 0; $x < sizeof($errorList); $x++) {
				$eMessage[] = $errorList[$x];
			}
			return $eMessage;
		}
	}

	/*-[end]added new function by pksing-*/
}
?>