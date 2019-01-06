<?php
$kw = $_COOKIE['kw'];
if($kw != $_GET['tentang']) {
	setcookie('kw', $_GET['tentang'], time() + 3655, '/');
	header("location: ./cari&tentang=".$_GET['tentang']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>Mencari <?php echo $kw; ?> | Agendakota Blog</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='aset/css/style.css' rel='stylesheet'>
	<link href='aset/css/style.cari.css' rel='stylesheet'>
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>Events News &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="./cari&tentang=Arts%26Culture"><li>Arts &amp; Culture</li></a>
				<a href="#"><li>Music</li></a>
				<a href="#"><li>Festival</li></a>
				<a href="#"><li>Technology</li></a>
				<a href="#"><li>Education</li></a>
				<a href="#"><li>Sport</li></a>
				<a href="#"><li>Travel</li></a>
			</ul>
		</li></a>
		<a href="#"><li>MICE &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="#"><li>Meeting</li></a>
				<a href="#"><li>Incentive</li></a>
				<a href="#"><li>Conference</li></a>
				<a href="#"><li>Exhibition</li></a>
			</ul>
		</li></a>
		<a href="#"><li>Tips &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="#"><li>Event Planning &amp; Promotion</li></a>
				<a href="#"><li>Business &amp; Professional</li></a>
				<a href="#"><li>Marketing &amp; Communication</li></a>
			</ul>
		</li></a>
		<a href="#"><li>More Info &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="#"><li>About Us</li></a>
				<a href="#"><li>Business Partnership</li></a>
				<a href="#"><li>Hubungi Kami</li></a>
			</ul>
		</li></a>
		<a href="https://agendakota.id" target="_blank"><button id="cta">Go to Agendakota.id</button></a>
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

<script src='aset/js/embo.js'></script>
<script>
	$('.title').klik(() => {
		mengarahkan('./')
	})
	function load() {
		ambil('./posts/cari', (res) => {
			$("#result").tulis(res)
		})
	}
	load()
	function search(val) {
		let set = 'namakuki=kw&value='+val+'&durasi=3655'
		pos('./aksi/setCookie.php', set, () => {
			load()
			$("#kw").tulis(val)
			history.replaceState("s", "pageExplore", "./cari&tentang="+encodeURIComponent(val))
		})
	}
	function blinkSearchBox() {
		$('#formCari').pengaya('border: 1px solid rgba(13,196,175,1);box-shadow: 1px 1px 5px 1px rgba(13,196,175,1);')
		setTimeout(() => {
			$('#formCari').pengaya('border: none;box-shadow: 1px 1px 5px 1px #ddd')
		}, 1000)
	}
	function tblSearch() {
		blinkSearchBox()
		scrollKe('#formCari')
	}
</script>

</body>
</html>