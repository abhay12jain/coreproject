<?php
class upload {

	var $directoryName;
	var $maxFileSize;
	var $error;
	var $userTmpName;
	var $userFileName;
	var $userFileSize;
	var $userFileType;
	var $userFullName;
	var $thumbName;

	function setDirectory($dirName = '.') {

		if (!is_dir($dirName))
			mkdir($dirName, 0777);
		$this->directoryName = $dirName;
	}

	function setMaxSize($maxFile = 10485760) {
		$this->maxFileSize = $maxFile;
	}

	function error() {
		return $this->error;
	}

	function isError() {
		if (isset ($this->error)) {
			return false;
		} else {

			return true;
		}
	}
	function setTmpName($tempName) {
		$this->userTmpName = $tempName;
	}
	function setFileSize($fileSize) {

		$this->userFileSize = $fileSize;
	}

	function setFileType($fileType) {
		$this->userFileType = $fileType;
	}

	function setFileName($file) {
		$this->userFileName = $file;
		$this->userFullName = $this->directoryName . '/' . $this->userFileName;
	}

	function resize($maxWidth = 0, $maxHeight = 0) {
		if (@ eregi('\.png$', $this->userFullName)) {
			$img = ImageCreateFromPNG($this->userFullName);
		}

		if (@ eregi('\.(jpg|jpeg)$', $this->userFullName)) {

			$img = ImageCreateFromJPEG($this->userFullName);
		}

		if (@ eregi('\.gif$', $this->userFullName)) {
			$img = ImageCreateFromGif($this->userFullName);
		}

		$FullImageWidth = imagesx($img);
		$FullImageHeight = imagesy($img);
		if (isset ($maxWidth) && isset ($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
			$newWidth = $maxWidth;
			$newHeight = $maxHeight;
		} else
			if (isset ($maxWidth) && $maxWidth != 0) {
				$newWidth = $maxWidth;
				$newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);

			} else
				if (isset ($maxHeight) && $maxHeight != 0) {
					$newHeight = $maxHeight;
					$newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
				} else {
					$newHeight = $FullImageHeight;
					$newWidth = $FullImageWidth;
				}

		$fullId = ImageCreateTrueColor($newWidth, $newHeight);
		ImageCopyResampled($fullId, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);
		if (@ eregi('\.(jpg|jpeg)$', $this->userFullName)) {
			$full = ImageJPEG($fullId, $this->userFullName, 100);
		}

		if (@ eregi('\.png$', $this->userFullName)) {
			$full = ImagePNG($fullId, $this->userFullName);
		}
		if (@ eregi('\.gif$', $this->userFullName)) {

			$full = ImageGIF($fullId, $this->userFullName);

		}

		ImageDestroy($fullId);

		unset ($maxWidth);

		unset ($maxHeight);

	}

	function startCopy() {
		if (!isset ($this->userFileName))
			$this->error = 'You must define filename!';

		if ($this->userFileSize <= 0)
			$this->error = 'Uploaded file size is less than zero KB.';

		if ($this->userFileSize > $this->maxFileSize)
			$this->error = 'Uploaded file size is greater than the set limit.';

		if (!isset ($this->error)) {
			$filename = basename($this->userFileName);
			if (!empty ($this->directoryName)) {
				$destination = $this->userFullName;
			} else {

				$destination = $filename;
			}
			if (!is_uploaded_file($this->userTmpName))
				$this->error = 'File ' . $this->userTmpName . ' is not uploaded correctly.';

			if (!@ move_uploaded_file($this->userTmpName, $destination))
				$this->error = 'Impossible to copy ' . $this->userFileName . ' from ' . $destination . ' to destination directory.';

		}

	}

	function setThumbnailName($thumbname) {
		$thumbname = preg_replace('/\.([a-zA-Z]{3,4})$/', $thumbname, $this->userFileName);
		if (@ eregi('\.png$', $this->userFullName))
			$this->thumbName = $this->directoryName . '/' . $thumbname . '.png';

		if (@ eregi('\.(jpg|jpeg)$', $this->userFullName))
			$this->thumbName = $this->directoryName . '/' . $thumbname . '.jpg';
		if (@ eregi('\.gif$', $this->userFullName))
			$this->thumbName = $this->directoryName . '/' . $thumbname . '.gif';
		//echo $this->thumbName;die;
	}

	function IsImageValid($argFiletype) {
		$fileType = $argFiletype;
		$image_type_identifiers = array (
			'image/gif' => 'gif',
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'image/pjpeg' => 'jpg',
			'image/x-png' => 'png'
		);
		if (array_key_exists($fileType, $image_type_identifiers)) {
			return true;
		} else {
			return false;
		}
	}

	function createThumbnail() {
		//echo $this->thumbName;
		if (!copy($this->userFullName, $this->thumbName)) {
			$this->error = '<br>' . $this->userFullName . ', ' . $this->thumbName . '<br>failed to copy file...<br />\n';
		}
	}

	function setThumbnailSize($maxWidth = 0, $maxHeight = 0) {
		if (@ eregi('\.png$', $this->thumbName)) {

			$img = ImageCreateFromPNG($this->thumbName);
		}

		if (@ eregi('\.(jpg|jpeg)$', $this->thumbName)) {

			$img = ImageCreateFromJPEG($this->thumbName);
		}
		if (@ eregi('\.gif$', $this->thumbName)) {

			$img = ImageCreateFromGif($this->thumbName);

		}

		$FullImageWidth = imagesx($img);
		$FullImageHeight = imagesy($img);
		$newWidth = $FullImageWidth;
		$newHeight = $FullImageHeight;
		if (isset ($maxWidth) && isset ($maxHeight) && $maxWidth != 0 && $maxHeight != 0) {
			$newWidth = $maxWidth;
			$newHeight = $maxHeight;
		} else
			if (isset ($maxWidth) && $maxWidth != 0) {
				$newWidth = $maxWidth;
				$newHeight = ((int) ($newWidth * $FullImageHeight) / $FullImageWidth);
			} else
				if (isset ($maxHeight) && $maxHeight != 0) {
					$newHeight = $maxHeight;
					$newWidth = ((int) ($newHeight * $FullImageWidth) / $FullImageHeight);
				} else {
					$newHeight = $FullImageHeight;
					$newWidth = $FullImageWidth;
				}

		$newImage = ImageCreateTrueColor($newWidth, $newHeight);
		$this->setTransparency($newImage, $img);
		ImageCopyResampled($newImage, $img, 0, 0, 0, 0, $newWidth, $newHeight, $FullImageWidth, $FullImageHeight);
		if (@ eregi('\.(jpg|jpeg)$', $this->thumbName)) {
			$full = imagejpeg($newImage, $this->thumbName, 100);
		}

		if (@ eregi('\.png$', $this->thumbName)) {
			$full = imagepng($newImage, $this->thumbName);

		}

		if (@ eregi('\.gif$', $this->thumbName)) {
			$full = imagegif($newImage, $this->thumbName);
		}

		ImageDestroy($newImage);
		unset ($maxWidth);
		unset ($maxHeight);

	}
	function setTransparency($new_image, $image_source) {

		$transparencyIndex = imagecolortransparent($image_source);
		$transparencyColor = array (
			'red' => 238,
			'green' => 238,
			'blue' => 238
		);

		if ($transparencyIndex >= 0) {
			$transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);
		}

		$transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
		imagefill($new_image, 0, 0, $transparencyIndex);
		imagecolortransparent($new_image, $transparencyIndex);

	}

	function createColorImage($argColorCode, $argPath, $argWidth, $argHeight, $argExt) {
		$varDestination = $argPath . $argColorCode . '.' . $argExt;
		if (!file_exists($varDestination)) {
			$varImage = @ imageCreate($argWidth, $argHeight);
			$varColor = hexdec($argColorCode);
			$arrColor = array (
				'red' => 0xFF & ($varColor >> 0x10),
				'green' => 0xFF & ($varColor >> 0x8),
				'blue' => 0xFF & $varColor
			);

			$varColorBackgrnd = imagecolorallocate($varImage, $arrColor['red'], $arrColor['green'], $arrColor['blue']);
			imageFilledRectangle($varImage, 0, 0, $argWidth -1, $argHeight -1, $varColorBackgrnd);
			if ($argExt == "jpg") {
				imagejpeg($varImage, $varDestination);
			}
			elseif ($argExt == "gif") {
				imagegif($varImage, $varDestination);
			}
			elseif ($argExt == "png") {
				imagepng($varImage, $varDestination);
			}
		}
	}

	function getFileExtensionFromType($fileType) {
		$image_type_identifiers = array (
			'image/gif' => 'gif',
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'application/x-shockwave-flash' => 'swf',
			'image/bmp' => 'bmp',
			'image/tiff' => 'tiff',
			'image/psd' => 'psd',
			'application/octet-stream' => 'jpc',
			'image/jp2' => 'jp2',
			'application/octet-stream' => 'jpf'
		);
		if (array_key_exists($fileType, $image_type_identifiers)) {
			return $image_type_identifiers[$fileType];
		}
	}

	function IsFileValid($argFiletype) {

		$fileType = $argFiletype;
		$image_type_identifiers = array (
			'application/msword' => 'doc',
			'application/pdf' => 'pdf'
		);
		if (array_key_exists($fileType, $image_type_identifiers)) {
			return true;
		} else {
			return false;
		}
	}
	function getThumbImageName($argImageName) {
		//Get file extention	
		if ($argImageName != '') {
			$varExt = substr(strrchr($argImageName, "."), 1);
			$varImageFileName = substr($argImageName, 0, - (strlen($varExt) + 1));
			if ($varExt == 'jpeg') {
				$varExt = 'jpg';
			}
			$varImageNameThumb = $varImageFileName . '_thumb.' . $varExt;
		}
		return $varImageNameThumb;
	}

	function getFileExtension($fileType) {

		$image_type_identifiers = array (
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'doc',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'ppt',
			'application/x-zip-compressed' => 'zip',
			'application/pdf' => 'pdf',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'excel'
		);
		if (array_key_exists($fileType, $image_type_identifiers)) {
			return $image_type_identifiers[$fileType];
		}

	}
}
?>