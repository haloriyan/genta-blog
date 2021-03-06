<?php

/*
	* Embo automate Routing
	* Created by Riyan Satria - (c) 2018
*/

error_reporting(1); // Comment this if you are in development mode and please dont edit this
$role = $_GET['role'];
$bag = $_GET['bag'];
include './vendor/autoload.php';

if($role == "" and $bag == "") {
	include 'index.php';
}else if($role == "") {
	$lokasi = 'pages/'.$bag.'.php';
	if(file_exists($lokasi)) {
		include $lokasi;
	}else {
		// header("location: ./error/404");
		include 'pages/read.php';
	}
}else if($bag == "") {
	$lokasi = 'pages/'.$role.'/dasbor.php';
	if(file_exists($lokasi)) {
		include $lokasi;
	}else {
		$lokasi = 'pages/'.$role.'/index.php';
		if(file_exists($lokasi)) {
			include $lokasi;
		}else {
			header("location: ../error/404");
		}
	}
}else {
	$control = $role;
	$controller = "aksi/ctrl/".$control;
	$fungsi = $bag;
	$lokasi = 'pages/'.$role.'/'.$bag.'.php';
	if(file_exists($lokasi)) {
		include $lokasi;
	}else {
		if($role == "pages") {
			include 'pages/readPage.php';
		}else if($role == "profile"){
			include 'pages/profile.php';
		}else if($role == "cari") {
			$tentang = $bag;
			include 'pages/cari.php';
		}else {
			if(file_exists($controller.".php")) {
				include $controller.".php";
				if(method_exists($$control, $fungsi)) {
					$$control->$fungsi();
				}else {
					die('Function not found');
				}
			}else {
				die('Controller not found');
			}
		}
	}
}
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107986295-2"></script>
<script>
window.dataLayer = window.dataLayer || []
function gtag() { 
	dataLayer.push(arguments)
}

gtag('js', new Date())
gtag('config', 'UA-107986295-2')
console.log('google anal tracked')
</script>
