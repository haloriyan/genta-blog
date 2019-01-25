<?php
include 'aksi/ctrl/laman.php';

$stats->visit();

$kw = $_COOKIE['kw'];
if($kw != $tentang) {
	setcookie('kw', $tentang, time() + 3655, '/');
	header("location: ../cari/".$tentang);
}
setcookie('position', 0, time() + 1, '/');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<meta name="description" content="<?php echo $configs->get('description'); ?>">
	<meta name="keyword" content="<?php echo $configs->get('keyword'); ?>">
	<meta name="robots" content="index follow">
	<meta property="og:url"                content="<?php echo $configs->getUrl(); ?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?php echo $kw; ?>" />
	<meta property="og:description"        content="Mencari <?php echo $kw; ?> di Blog Agendakota" />
	<meta property="og:image"              content="<?php echo $configs->baseUrl(); ?>/aset/img/AK.png" />
	<title>Mencari <?php echo $kw; ?> | Agendakota Blog</title>
	<link href='../aset/fw/build/fw.css' rel='stylesheet'>
	<link href='../aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='../aset/css/style.min.css' rel='stylesheet'>
	<link href='../aset/css/style.cari.min.css' rel='stylesheet'>
	<link href="../aset/img/favicon.ico" rel="icon">
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="../aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENTS NEWS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<?php
				$posts->allCat(1);
				?>
			</ul>
		</li></a>
		<a href="../cari/MICE"><li>MICE</li></a>
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
		<a href="#"><li class="fb"><i class="fab fa-facebook"></i></li></a>
		<a href="#"><li class="twitter"><i class="fab fa-twitter"></i></li></a>
		<a href="#"><li class="yt"><i class="fab fa-youtube"></i></li></a>
	</nav>
</div>

<form id="formCari">
	<input type="text" class="box" oninput="search(this.value)" value="<?php echo $kw; ?>">
	<button id="cari"><i class="fas fa-search"></i></button>
</form>

<div class="container">
	<div class="wrap">
		<h2>Mencari <span id="kw"><?php echo $kw; ?></span>...</h2>
		<div id="result" class="recentPost"></div>
	</div>
</div>

<script src='../aset/js/embo.js'></script>
<script src='../aset/js/riload.js'></script>
<script>
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
	$('.title').klik(() => {
		mengarahkan('../')
	})
	
	function setCookie(name, value) {
		let set = "namakuki="+name+"&value="+value+"&durasi=3666"
		pos('../aksi/setCookie.php', set, (res) => {
			console.log(res)
		})
	}
	function load() {
		ambil('../posts/golek', (res) => {
			$("#result").tulis(res)
		})
	}
	load()
	// let loads = new Riload({
	// 	el: '#result',
	// 	url: './posts/golek',
	// 	sukses: () => {
	// 		//
	// 	}
	// })
	function search(val) {
		let set = 'namakuki=kw&value='+val+'&durasi=3655'
		pos('../aksi/setCookie.php', set, () => {
			load()
			$("#kw").tulis(val)
			history.replaceState("s", "pageExplore", "../cari/"+encodeURIComponent(val))
		})
	}
	function blinkSearchBox() {
		$('#formCari').pengaya('border: 1px solid rgba(13,196,175,1);box-shadow: 1px 1px 5px 1px rgba(13,196,175,1);')
		setTimeout(() => {
			$('#formCari').pengaya('border: none;box-shadow: 1px 1px 5px 1px #ddd')
		}, 1500)
	}
	function tblSearch() {
		blinkSearchBox()
		scrollKe('#formCari')
	}
</script>

</body>
</html>