<?php

$berkas = $_FILES['file']['name'];
$tmp = $_FILES['file']['tmp_name'];
setcookie('berkas', $berkas, time() + 20, '/');

$dir = "../aset/img/";

function kompres($source, $destination, $quality) {
	$info = getimagesize($source);

	if($info['mime'] == "image/jpeg") {
		$image = imagecreatefromjpeg($source);
	}else if($info['mime'] == "image/gif") {
		$image = imagecreatefromgif($source);
	}else if($info['mime'] == "image/png") {
		$image = imagecreatefrompng($source);
	}
	imagejpeg($image, $destination, $quality);
	return $destination;
}

if(move_uploaded_file($tmp, $dir.$berkas)) {
	if(kompres($dir.$berkas, $dir.$berkas, 50)) {
		// chmod($dir.$berkas, 777);
	}
}
kompres($dir.$berkas, $dir.$berkas, 50);