<?php
include 'aksi/ctrl/pages.php';

$id = $_GET['bag'];
$name = $users->me($id, 'name');
$photo = $users->me($id, 'photo');
$bio = $users->me($id, 'bio');

$fbLink = $configs->get('facebook');
$twitLink = $configs->get('twitter');
$ytLink = $configs->get('youtube');

setcookie('myPos', '', time() + 1, '/');
setcookie('seeUser', $id, time() + 3655, '/');

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
	<meta property="og:title"              content="<?php echo $name; ?> | Agendakota Blog" />
	<meta property="og:description"        content="<?php echo $tools->limit($content, 50); ?>" />
	<meta property="og:image"             content="<?php echo $configs->baseUrl(); ?>/aset/img/<?php echo $cover; ?>" />
	<title><?php echo $name; ?> | Agendakota Blog</title>
	<link href="../aset/fw/build/fw.css" rel="stylesheet">
	<link href="../aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="../aset/css/style.css" rel="stylesheet">
	<link href="../aset/css/style.profile.css" rel="stylesheet">
	<link href="../aset/img/favicon.ico" rel="icon">
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="../aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENTS NEWS &nbsp; <i class="fas fa-angle-down"></i>
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
		<a href="<?php echo $fbLink; ?>" target="_blank"><li class="fb"><i class="fab fa-facebook"></i></li></a>
		<a href="<?php echo $twitLink; ?>" target="_blank"><li class="twitter"><i class="fab fa-twitter"></i></li></a>
		<a href="<?php echo $ytLink; ?>" target="_blank"><li class="yt"><i class="fab fa-youtube"></i></li></a>
	</nav>
</div>

<div class="container">
	<div class="profile">
		<img src="../aset/img/<?php echo $photo; ?>">
		<h2><?php echo $name; ?></h2>
		<div id="kontri"><?php echo $users->totArtikel($id); ?> kontribusi</div>
		<p id="bio"><?php echo $bio; ?></p>
		<div class="social">
			<div id="twitter"><a href="#"><i class="fab fa-twitter"></i></a></div>
			<div id="linkedin"><a href="#"><i class="fab fa-linkedin"></i></a></div>
		</div>
	</div>
	<div class="recentPost">
		<input type="hidden" id="myPos" value="0">
		<div id="loadMyArticle"></div>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="bagSearch">
	<div class="popup">
		<div class="wrap">
			<h2 class="rata-kanan" id="xSearch"><i class="fas fa-times"></i></h2>
			<form id="formCari">
				<p>Search</p>
				<input type="text" class="box" placeholder="Type and Hit Enter" id="kw">
			</form>
		</div>
	</div>
</div>

<script src="../aset/js/embo.js"></script>
<script src="../aset/js/riload.js"></script>
<script>
	function setCookie(name, value) {
		let set = "namakuki="+name+"&value="+value+"&durasi=3666"
		pos('../aksi/setCookie.php', set, () => {
			console.log('setted')
		})
	}
	function tblSearch() {
		munculPopup("#bagSearch")
	}
	tekan('Escape', () => {
		hilangPopup("#bagSearch")
	})
	$("#xSearch").klik(() => {
		hilangPopup("#bagSearch")
	})
	submit('#formCari', () => {
		let kw = $("#kw").isi()
		pos("./aksi/setCookie.php", kw, () => {
			mengarahkan('../cari&tentang='+kw)
		})
		return false;
	})
	$("#tblMenu").klik(function() {
		let aksi = this.atribut('aksi')
		if(aksi == "bkMenu") {
			$(".atas .sosmed").muncul()
			$(".nav").muncul()
			$(".menu").muncul()
			this.atribut('aksi', 'xMenu')
		}else {
			$(".atas .sosmed").hilang()
			$(".nav").hilang()
			$(".menu").hilang()
			this.atribut('aksi', 'bkMenu')
		}
	})

	let load = new Riload({
		el: '#loadMyArticle',
		url: '../users/myArticle',
		data: 'yeye='+myPos,
		sukses: () => {
			myPos = myPos + 1
			// setCookie('myPos', myPos)
		}
	})
</script>

</body>
</html>