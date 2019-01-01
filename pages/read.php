<?php
include 'aksi/ctrl/posts.php';

$title = $bag;
$idpost = $posts->read($title, "idpost");
$titles = $posts->read($title, "title");
$content = $posts->read($title, "content");
$category = $posts->read($title, "category");
$cover = $posts->read($title, "cover");

$linkNow = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

setcookie('idpost', $idpost, time() + 4300, '/');

if($titles == "") {
	die('404 not found');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Title</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/read.css" rel="stylesheet">
</head>
<body>

<div class="atas">
	<h1 class="title">Agendakota</h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>Events News &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="#"><li>Arts &amp; Culture</li></a>
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

<div class="container">
	<div class="top">
		<img src="aset/img/<?php echo $cover; ?>">
		<div class="ket">
			<div class="info">
				<?php
				foreach (explode(",", $category) as $key => $value) {
					echo "<div class='cat'>".$value."</div>";
				}
				?>
				<div class="time">3 MONTSH AGO</div>
			</div>
			<h2 class="postTitle"><?php echo $titles; ?></h2>
			<div class="profile">
				<img src="aset/img/riyan.jpg">
				<h4>Riyan Satria</h4>
			</div>
		</div>
	</div>
	<div class="article">
		<div id="read">
			<p>
				<?php echo $content; ?>
			</p>
			Tags : <div class="tag">business</div><div class="tag">ecommerce</div><div class="tag">lifestyle</div>
		</div>
		<div>
			<h2>You Might Like</h2>
			<hr size="2" color="#ddd">
			<div id="recentPost">
				<div class="pos">
					<img src="aset/img/idea.jpg">
					<h3>Keeping Your Ideas Organized</h3>
				</div>
				<div class="pos">
					<img src="aset/img/idea.jpg">
					<h3>Keeping Your Ideas Organized</h3>
				</div>
				<div class="pos">
					<img src="aset/img/idea.jpg">
					<h3>Keeping Your Ideas Organized</h3>
				</div>
			</div>
			<div id="bagKomen">
				<h2>Comments</h2>
				<hr size="2" color="#ddd">
				<!-- <div id="loadComment"></div> -->
				<div id="disqus_thread"></div>
			</div>
			<div class="navPost">
				<div class="pos">
					<div class="bag bag-4">
						<img src="aset/img/idea.jpg">
					</div>
					<div class="bag bag-6">
						<div class="wrap">
							<i class="fas fa-angle-left"></i> <span>Previous Post</span>
							<h4>Breaking One Task Down Into Bite Size</h4>
						</div>
					</div>
				</div>
				<div class="pos">
					<div class="bag bag-4">
						<img src="aset/img/idea.jpg">
					</div>
					<div class="bag bag-6">
						<div class="wrap">
							<i class="fas fa-angle-right"></i> <span>Next Post</span>
							<h4>Breaking One Task Down Into Bite Size</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="subscribe">
		<div class="img" style="background: url(aset/img/imac.jpg) center center;background-size: cover;"></div>
		<div class="ket">
			<h3>Agendakota Newsletter</h3>
			<p>Subscribe for Furosa news and receive daily updates. For those who want to keep in touch with us.</p>
			<br />
			<form id="formSubscribe">
				<input type="text" class="box" placeholder="Your email address">
				<div class="bag-tombol">
					<button>Subscribe</button>
				</div>
				<input type="checkbox" required id="agreeSubscribe">
				<label for="agreeSubscribe">I agree to storage of my email according to <a href="#">Privacy Policy</a></label>
			</form>
		</div>
	</div>
	<div class="footer">
		<div class="wrap">
			<div class="bagFoot">
				<h2>Agendakota</h2>
				<p>
					<i class="fas fa-copyright"></i> 2018 Agendakota, made with <i class="fas fa-heart"></i>
				</p>
			</div>
			<div class="bagFoot">
				<h3>NAVIGATION</h3>
				<a href="#"><li>Shop</li></a>
				<a href="#"><li>Home</li></a>
				<a href="#"><li>Home2</li></a>
				<a href="#"><li>Home3</li></a>
			</div>
			<div class="bagFoot">
				<h3>USEFUL LINKS</h3>
				<a href="#"><li>Shop</li></a>
				<a href="#"><li>Privacy Policy</li></a>
				<a href="#"><li>Advertise</li></a>
				<a href="#"><li>FAQ</li></a>
			</div>
			<div class="bagFoot">
				<h3>TAGS</h3>
				<a href="#"><div class="tag">blog</div></a>
				<a href="#"><div class="tag">sport</div></a>
				<a href="#"><div class="tag">festival</div></a>
				<a href="#"><div class="tag">concert</div></a>
				<a href="#"><div class="tag">store</div></a>
				<a href="#"><div class="tag">workshop</div></a>
				<a href="#"><div class="tag">exhibition</div></a>
				<a href="#"><div class="tag">attraction</div></a>
				<a href="#"><div class="tag">conference</div></a>
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
				<input type="text" class="box" placeholder="Type and Hit Enter">
			</form>
		</div>
	</div>
</div>

<script src="aset/js/embo.js"></script>
<script>
	function tblSearch() {
		munculPopup("#bagSearch")
	}
	// function loadComment() {
	// 	ambil('./comments/load', (res) => {
	// 		$("#loadComment").tulis(res)
	// 	})
	// }
	// loadComment()
	
	var disqus_config = function () {
	this.page.url = '<?php echo $linkNow; ?>';  // Replace PAGE_URL with your page's canonical URL variable
	this.page.identifier = '<?php echo $title; ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
	};

	(function() { // DON'T EDIT BELOW THIS LINE
	var d = document, s = d.createElement('script');
	s.src = 'https://agendakota-1.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
	})();

	tekan('Escape', () => {
		hilangPopup("#bagSearch")
	})
	$("#xSearch").klik(() => {
		hilangPopup("#bagSearch")
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
<script id="dsq-count-scr" src="//agendakota-1.disqus.com/count.js" async></script>

</body>
</html>