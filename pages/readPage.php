<?php
include 'aksi/ctrl/pages.php';

$title = $fungsi;
$titles = $pages->read($title, "title");
$content = $pages->read($title, "content");

if($titles == "" and $content == "") {
	die('404');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<meta name="description" content="<?php echo $configs->get('description'); ?>">
	<meta name="keyword" content="<?php echo $configs->get('keyword'); ?>">
	<meta name="robots" content="index follow">
	<meta property="og:url"                content="<?php echo $configs->getUrl(); ?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?php echo $titles; ?>" />
	<meta property="og:description"        content="<?php echo $pages->limit($content, 50); ?>" />
	<meta property="og:image"              content="<?php echo $configs->baseUrl(); ?>/aset/img/AK.png" />
	<title><?php echo $titles; ?></title>
	<link href="../aset/fw/build/fw.css" rel="stylesheet">
	<link href="../aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="../aset/css/read.css" rel="stylesheet">
	<link href="../aset/img/favicon.ico" rel="icon">
	<style>
		.container {
			color: #454545;
			left: 20%;right: 20%;
			top: 125px;
		}
		.container .content {
			font-size: 22px;
			font-family: ProReg;
			line-height: 35px;
		}
		.container h1 { font-family: ProBold; }
	</style>
</head>
<body>

<div class="atas">
	<h1 class="title"><a href='../'><img src="../aset/img/AK.png"></a></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENT NEWS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="../cari&tentang=Arts%26Culture"><li>Arts &amp; Culture</li></a>
				<a href="../cari&tentang=Music"><li>Music</li></a>
				<a href="../cari&tentang=Festival"><li>Festival</li></a>
				<a href="../cari&tentang=Technology"><li>Technology</li></a>
				<a href="../cari&tentang=Education"><li>Education</li></a>
				<a href="../cari&tentang=Sport"><li>Sport</li></a>
				<a href="../cari&tentang=Travel"><li>Travel</li></a>
			</ul>
		</li></a>
		<a href="#"><li>MICE</li></a>
		<a href="#"><li>TIPS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="../cari&tentang=Event Planning"><li>Event Planning &amp; Promotion</li></a>
				<a href="../cari&tentang=Business Professional"><li>Business &amp; Professional</li></a>
				<a href="../cari&tentang=Marketing Communication"><li>Marketing &amp; Communication</li></a>
			</ul>
		</li></a>
		<a href="#"><li>MORE INFO &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<?php $pages->show(); ?>
			</ul>
		</li></a>
		<a href="https://agendakota.id" target="_blank"><button id="cta">GO TO AGENDAKOTA.ID</button></a>
	</nav>
	<nav class="nav">
		<div id="tblSearch" onclick="tblSearch()"><i class="fas fa-search"></i></div>
	</nav>
	<nav class="sosmed">
		<a href="<?php echo $configs->get('facebook'); ?>"><li class="fb"><i class="fab fa-facebook"></i></li></a>
		<a href="<?php echo $configs->get('twitter'); ?>"><li class="twitter"><i class="fab fa-twitter"></i></li></a>
		<a href="<?php echo $configs->get('youtube'); ?>"><li class="yt"><i class="fab fa-youtube"></i></li></a>
	</nav>
</div>

<div class="container">
	<div class="wrap">
		<h1><?php echo $titles; ?></h1>
		<div class="content"><?php echo $content; ?></div>
	</div>
</div>

</body>
</html>