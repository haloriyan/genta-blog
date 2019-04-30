<?php
include 'aksi/ctrl/laman.php';

$stats->visit();

$title = $fungsi;
$titles = $laman->read($title, "title");
$cover = $laman->read($title, "image");
$content = $laman->read($title, "content");

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
	<meta property="og:description"        content="<?php echo $laman->limit($content, 50); ?>" />
	<meta property="og:image"              content="<?php echo $configs->baseUrl(); ?>/aset/img/AK.png" />
	<title><?php echo $titles; ?></title>
	<link href="../aset/fw/build/fw.css" rel="stylesheet">
	<link href="../aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="../aset/css/read.min.css" rel="stylesheet">
	<link href="../aset/img/favicon.ico" rel="icon">
	<style>
		.container {
			color: #454545;
			left: 20%;right: 20%;
			top: 125px;
			margin-bottom: 70px;
		}
		.container .content {
			font-size: 22px;
			font-family: ProReg;
			line-height: 35px;
		}
		.container h1 { font-family: ProBold; }
		.container img { width: 100%; }
		@media (max-width: 480px) {
			.container {
				left: 5%;right: 5%;
			}
			.container .wrap { margin: 5%; }
		}
	</style>
</head>
<body>

<div class="atas">
	<h1 class="title"><a href='../'><img src="../aset/img/AK.png"></a></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENT NEWS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<?php
				$posts->allCat(1);
				?>
			</ul>
		</li></a>
		<a href="#"><li>MICE</li></a>
		<a href="#"><li>TIPS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="../cari/Event Planning"><li>Event Planning &amp; Promotion</li></a>
				<a href="../cari/Business Professional"><li>Business &amp; Professional</li></a>
				<a href="../cari/Marketing Communication"><li>Marketing &amp; Communication</li></a>
			</ul>
		</li></a>
		<a href="#"><li>MORE INFO &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<?php $laman->show(); ?>
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
		<img src='../aset/img/<?php echo $cover; ?>' />
		<div class="content"><?php echo $content; ?></div>
	</div>
</div>

</body>
</html>