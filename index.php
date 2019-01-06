<?php

setcookie('position', '0', time() + 3555, '/');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Agendakota Blog</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/style.css" rel="stylesheet">
	<style>
		body { background-color: #efefef; }
	</style>
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>Events News &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="./cari&tentang=Arts%26Culture"><li>Arts &amp; Culture</li></a>
				<a href="./cari&tentang=Music"><li>Music</li></a>
				<a href="./cari&tentang=Festival"><li>Festival</li></a>
				<a href="./cari&tentang=Technology"><li>Technology</li></a>
				<a href="./cari&tentang=Education"><li>Education</li></a>
				<a href="./cari&tentang=Sport"><li>Sport</li></a>
				<a href="./cari&tentang=Travel"><li>Travel</li></a>
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

<div class="container">
	<div class="wrap">
		<!-- <div id="primaryPosts">
			<div class="primary">
				<a href="./read.php">
					<div class="post">
						<img src="aset/img/bg.png" class="cover">
						<div class="ket">
							<div class="wrap">
								<div class="tag">LIFESTYLE</div>
								<h3>Lorem ipsum dolor sit amet consectetur adipisicing elit</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="secondary">
				<a href="./read.php">
					<div class="post">
						<img src="aset/img/bg.png" class="cover">
						<div class="ket">
							<div class="wrap">
								<div class="tag">LIFESTYLE</div>
								<h3>Lorem ipsum dolor sit amet consectetur adipisicing elit</h3>
							</div>
						</div>
					</div>
				</a>
				<a href="./read.php">
					<div class="post">
						<img src="aset/img/bg.png" class="cover">
						<div class="ket">
							<div class="wrap">
								<div class="tag">LIFESTYLE</div>
								<h3>Lorem ipsum dolor sit amet consectetur adipisicing elit</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div> -->
		<div class="featuredPost">
			<div class="list">
				<div class="kiri bag bag-5">
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="kanan bag bag-5">
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<div class="tag">TEKNOLOGI</div>
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<div class="tag">TEKNOLOGI</div>
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="kanan bag bag-5" style="margin-left: 0px;margin-right: 25px;">
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<div class="tag">TEKNOLOGI</div>
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<div class="tag">TEKNOLOGI</div>
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="kiri bag bag-5">
					<div class="pos">
						<img src="http://localhost/genta/aset/img/Menolak-Lamaran-Kerja-Karyawan-Featured.jpg">
						<div class="ket">
							<div class="wrap">
								<h3>Membangun Platform Pencari Kerja Efisien Sesuai dengan Keinginan Pengusaha</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bawah">
			<div class="kiri">
				<div class="bagian" id="recentPost">
					<div class="wrap">
						<div class="recentPost">
							<div id="loadPost"></div>
							<div id="toLoad0"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
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

<script src="aset/js/embo.js"></script>
<script>
	let toLoad = 0
	let posisi = 0
	let allowLoad = 1
	let documentHeight
	let totalScroll
	
	function tblSearch() {
		munculPopup("#bagSearch")
	}
	function getDocHeight() {
		var body = document.body,
		    html = document.documentElement;

		// documentHeight = Math.max( body.scrollHeight, body.offsetHeight, 
		//                        html.clientHeight, html.scrollHeight, html.offsetHeight );
		documentHeight = html.offsetHeight + html.scrollHeight
	}
	function loadPost() {
		ambil('./posts/index', (res) => {
			$("#loadPost").tulis(res)
		})
	}

// documentHeight = 4738
	getDocHeight()
	window.addEventListener('scroll', (scr) => {
		let scroll = this.pageYOffset
		// totalScroll = parseInt(window.innerHeight) + parseInt(window.pageYOffset)
		if(scroll >= documentHeight) {
			loadMore()
		}
	})
	function loadMore(that) {
		toLoad = parseInt(toLoad) + 1
		posisi = parseInt(posisi) + 5
		if(allowLoad == 1) {
			magicElement()
		}else {
			return false
		}
		pos('./aksi/setCookie.php', 'namakuki=position&value='+posisi+'&durasi=3666', () => {
			ambil('./posts/index', (res) => {
				if(res == 'habis') {
						$("#toLoad"+toLoad).tulis('No more article :(')
					allowLoad = 0
				}else {
					$("#toLoad"+toLoad).tulis(res)
				}
			})
		})
		// refresh variable documentHeight
		getDocHeight()
	}
	function magicElement() {
		let div = document.createElement('div')
		div.setAttribute('id', 'toLoad'+toLoad)
		$('.recentPost').appendChild(div)
	}
	loadPost()
	tekan('Escape', () => {
		hilangPopup("#bagSearch")
	})
	$("#xSearch").klik(() => {
		hilangPopup("#bagSearch")
	})
	submit('#formCari', () => {
		let kw = $("#kw").isi()
		pos("./aksi/setCookie.php", kw, () => {
			mengarahkan('./cari&tentang='+kw)
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
</script>

</body>
</html>