<?php
error_reporting(1);
include 'aksi/ctrl/laman.php';

$stats->visit();

$fbLink = $configs->get('facebook');
$twitLink = $configs->get('twitter');
$igLink = $configs->get('instagram');
$ytLink = $configs->get('youtube');

setcookie('position', '0', time() + 3555, '/');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<meta name="description" content="<?php echo $configs->get('description'); ?>">
	<meta name="keyword" content="<?php echo $configs->get('keyword'); ?>">
	<meta name="robots" content="index follow">
	<title>Agendakota Blog</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/style.min.css" rel="stylesheet">
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		body { background-color: #efefef; }
		.featuredPost .kanan .pos img {
			display: none;
		}
		.featuredPost .kanan .covers {
			display: block;
		}
		.featuredPost {
			width: 100%;
			margin-left: 0px;
		}
	</style>
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENTS NEWS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<?php
				$posts->allCat(1);
				?>
			</ul>
		</li></a>
		<a href="#"><li>MICE</li></a>
		<a href="#"><li>TIPS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="./cari/Event Planning"><li>Event Planning &amp; Promotion</li></a>
				<a href="./cari/Business Professional"><li>Business &amp; Professional</li></a>
				<a href="./cari/Marketing Communication"><li>Marketing &amp; Communication</li></a>
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
		<a href="<?php echo $fbLink; ?>" target="_blank"><li class="fb"><i class="fab fa-facebook"></i></li></a>
		<a href="<?php echo $twitLink; ?>" target="_blank"><li class="twitter"><i class="fab fa-twitter"></i></li></a>
		<a href="<?php echo $ytLink; ?>" target="_blank"><li class="yt"><i class="fab fa-youtube"></i></li></a>
	</nav>
</div>

<div class="container">
	<div class="wrap">
		<div class="featuredPost">
			<div class="list">
				<div class="kiri bag bag-5">
					<div id="fiturPos0"></div>
				</div>
				<div class="kanan bag bag-5">
					<div id="fiturPos1"></div>
					<div id="fiturPos2"></div>
				</div>
				<div class="kanan bag bag-5" style="margin-left: 0px;margin-right: 25px;">
					<div id="fiturPos3"></div>
					<div id="fiturPos4"></div>
				</div>
				<div class="kiri bag bag-5">
					<div id="fiturPos5"></div>
				</div>
				<div id="loadFeatured"></div>
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
		console.log('loaded')
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
					$("#toLoad"+toLoad).pengaya("text-align: center;color: #666;")
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
			mengarahkan('./cari/'+kw)
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

	function loadFeatured(position) {
		pos('./posts/fitur', 'pos='+position, (res) => {
			$("#fiturPos"+position).tulis(res)
		})
	}
	function allFitur() {
		loadFeatured(0)
		loadFeatured(1)
		loadFeatured(2)
		loadFeatured(3)
		loadFeatured(4)
		loadFeatured(5)
	}
	allFitur()
</script>

</body>
</html>