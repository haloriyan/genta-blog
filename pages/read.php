<?php
include 'aksi/ctrl/laman.php';

$title = $bag;
$posts->hit($title);
$idpost = $posts->read($title, "idpost");
$titles = $posts->read($title, "title");
$content = $posts->read($title, "content");
$category = $posts->read($title, "category");
$cover = $posts->read($title, "cover");
$date = $posts->read($title, "date_posted");
$timeAgo = $tools->timeAgo($date);

$iduser = $posts->read($title, "iduser");
$photo = $users->me($iduser, "photo");
$name = $users->me($iduser, "name");

$prev = $posts->previous($date);
$next = $posts->next($date);
$prevTitle = (strlen($prev['title']) < 40) ? $prev['title'] : substr($prev['title'], 0,40)."...";
$nextTitle = (strlen($next['title']) < 40) ? $next['title'] : substr($next['title'], 0,40)."...";

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
	<meta name="description" content="<?php echo $configs->get('description'); ?>">
	<meta name="keyword" content="<?php echo $configs->get('keyword'); ?>">
	<meta name="robots" content="index follow">
	<meta property="og:url"                content="<?php echo $configs->getUrl(); ?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?php echo $titles; ?>" />
	<meta property="og:description"        content="<?php echo $tools->limit($content, 50); ?>" />
	<meta property="og:image"              content="<?php echo $configs->baseUrl(); ?>/aset/img/<?php echo $cover; ?>" />
	<title><?php echo $titles; ?></title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/read.css" rel="stylesheet">
	<style>
		.cawang {
			width: 100px;
			line-height: 100px;
			display: inline-block;
			background-color: rgba(13,196,175,1);
			color: #fff;
			border-radius: 125px;
			font-size: 35px;
		}
		.popup { border-radius: 6px; }
		.popup button {
			padding: 15px 40px;
			font-size: 17px;
			background: none;
			border: none;
			font-family: OBold;
			cursor: pointer;
			transition: 0.4s;
		}
		.tblClose {
			color: rgba(13,196,175,1);
		}
		.tblClose:hover { background: rgba(13,196,175,0.2); }
	</style>
	<link href="aset/img/favicon.ico" rel="icon">
</head>
<body>

<div class="atas">
	<h1 class="title"><img src="aset/img/AK.png"></h1>
	<div id="tblMenu" aksi="bkMenu"><i class="fas fa-bars"></i></div>
	<nav class="menu">
		<a href="#"><li>EVENT NEWS &nbsp; <i class="fas fa-angle-down"></i>
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
		<a href="#"><li>MICE</li></a>
		<a href="#"><li>TIPS &nbsp; <i class="fas fa-angle-down"></i>
			<ul class="sub">
				<a href="./cari&tentang=Event Planning"><li>Event Planning &amp; Promotion</li></a>
				<a href="./cari&tentang=Business Professional"><li>Business &amp; Professional</li></a>
				<a href="./cari&tentang=Marketing Communication"><li>Marketing &amp; Communication</li></a>
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
	<!-- <div class="top">
		<div class="cover" style="background: url(aset/img/<?php echo $cover; ?>);background-size: cover;"></div>
		<div class="ket">
			<div class="info">
				<?php
				foreach (explode(",", $category) as $key => $value) {
					echo "<div class='cat'><a href='./cari&tentang=".$value."'>".$value."</a></div>";
				}
				?>
				<div class="time"><?php echo $timeAgo; ?></div>
			</div>
			<h2 class="postTitle"><?php echo $titles; ?></h2>
			<div class="profile">
				<img src="aset/img/<?php echo $photo; ?>">
				<h4><?php echo $name; ?></h4>
			</div>
		</div>
	</div> -->
	<div class="articleTitle">
		<h1><?php echo $titles; ?></h1>
		<div class="kategori">
			<?php
			foreach (explode(",", $category) as $key => $value) {
				echo "<div class='cat'><a href='./cari&tentang=".$value."'>".$value."</a></div>";
			}
			?>
		</div>
		<div class="profile">
			<img src="aset/img/<?php echo $photo; ?>">
			<h4>
				<div><a href='./profile/<?php echo $iduser; ?>'><?php echo $name; ?></a></div>
				<?php echo $timeAgo; ?>
			</h4>
		</div>
		<img src="aset/img/<?php echo $cover; ?>">
	</div>
	<div class="article">
		<div id="read">
			<p>
				<?php echo $content; ?>
			</p>
			Tags :
			<?php
			$queryForRecent = "SELECT * FROM post WHERE ";
			$i = 0;
			foreach (explode(",", $category) as $key => $value) {
				if($i++ == count(explode(",", $category)) - 1) {
					$queryForRecent .= "category LIKE '%".$value."%' ";
				}else {
					$queryForRecent .= "category LIKE '%".$value."%' OR ";
				}
				echo "<div class='tag'><a href='./cari&tentang=".$value."'>".$value."</a></div>";
			}
			$queryForRecent .= " AND title != '$titles' LIMIT 3";
			?>
		</div>
		<div>
			<h2>You Might Like</h2>
			<hr size="2" color="#ddd">
			<div id="recentPost">
				<?php
				$recentPost = $embo->query($queryForRecent);
				while ($row = $embo->ambil($recentPost)) {
					echo "<a href='./".$tools->convertTitle($row['title'])."'>".
							"<div class='pos'>".
								"<img src='aset/img/".$row['cover']."'>".
								"<h3>".$row['title']."</h3>".
						 	"</div>".
						 "</a>";
				}
				?>
			</div>
			<div id="bagKomen">
				<h2>Comments</h2>
				<hr size="2" color="#ddd">
				<!-- <div id="loadComment"></div> -->
				<div id="disqus_thread"></div>
			</div>
			<div class="navPost">
				<a href='<?php echo $tools->convertTitle($prev['title']); ?>'>
					<div class="pos">
						<div class="bag bag-4">
							<img src="aset/img/<?php echo $prev['cover']; ?>">
						</div>
						<div class="bag bag-6">
							<div class="wrap">
								<i class="fas fa-angle-left"></i> <span>Previous Post</span>
								<h4><?php echo $prevTitle; ?></h4>
							</div>
						</div>
					</div>
				</a>
				<?php if($next['title'] != "") { ?>
				<div style="cursor: pointer;" class="pos" onclick="mengarahkan('<?php echo $tools->convertTitle($next['title']); ?>')">
					<div class="bag bag-4">
						<img src="aset/img/<?php echo $next['cover']; ?>">
					</div>
					<div class="bag bag-6">
						<div class="wrap">
						<i class="fas fa-angle-right"></i> <span>Next Post</span>
							<h4><?php echo $nextTitle; ?></h4>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="subscribe">
		<div class="img" style="background: url(aset/img/imac.jpg) center center;background-size: cover;"></div>
		<div class="ket">
			<h3>Agendakota Newsletter</h3>
			<p>Subscribe for Agendakota news and receive daily updates. For those who want to keep in touch with us.</p>
			<br />
			<form id="formSubscribe">
				<input type="text" class="box" placeholder="Your name" id="nameSubs">
				<input type="text" class="box" placeholder="Your email address" id="emailSubs">
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
				<h3>EVENT NEWS</h3>
				<a href="./cari&tentang=Arts%26Culture"><li>Arts &amp; Culture</li></a>
				<a href="./cari&tentang=Music"><li>Music</li></a>
				<a href="./cari&tentang=Festival"><li>Festival</li></a>
				<a href="./cari&tentang=Technology"><li>Technology</li></a>
				<a href="./cari&tentang=Education"><li>Education</li></a>
				<a href="./cari&tentang=Sport"><li>Sport</li></a>
				<a href="./cari&tentang=Travel"><li>Travel</li></a>
			</div>
			<div class="bagFoot">
				<h3>TIPS</h3>
				<a href="./cari&tentang=Event Planning"><li>Event Planning &amp; Promotion</li></a>
				<a href="./cari&tentang=Business Professional"><li>Business &amp; Professional</li></a>
				<a href="./cari&tentang=Marketing Communication"><li>Marketing &amp; Communication</li></a>
			</div>
			<div class="bagFoot">
				<h3>PAGES</h3>
				<?php $laman->show(); ?>
			</div>
			<div class="bagFoot">
				<h3>TAGS</h3>
				<a href="./cari&tentang=Arts%26Culture"><div class="tag">Arts &amp; Culture</div></a>
				<a href="./cari&tentang=Music"><div class="tag">Music</div></a>
				<a href="./cari&tentang=Festival"><div class="tag">Festival</div></a>
				<a href="./cari&tentang=Technology"><div class="tag">Technology</div></a>
				<a href="./cari&tentang=Education"><div class="tag">Education</div></a>
				<a href="./cari&tentang=Sport"><div class="tag">Sport</div></a>
				<a href="./cari&tentang=Travel"><div class="tag">Travel</div></a>
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
				<input type="text" class="box" placeholder="Type and Hit Enter" id="q">
			</form>
		</div>
	</div>
</div>

<div class="popupWrapper" id="bagSubs">
	<div class="popup">
		<div class="wrap" style="margin: 10%;">
			<div class="rata-tengah">
				<div class="cawang">
					<i class="fas fa-check"></i>
				</div>
				<h2>Thank's for subscribe, <span id="name">Riyan</span>!</h2>
				<p>
					Nice to meet you!
				</p>
				<button id="closeSubs" class="tblClose">CLOSE</button>
			</div>
		</div>
	</div>
</div>

<script src="aset/js/embo.js"></script>
<script>
	$(".title").klik(() => {
		mengarahkan('./')
	})
	function tblSearch() {
		munculPopup("#bagSearch")
	}
	
	// var disqus_config = function () {
	// this.page.url = '<?php echo $linkNow; ?>';  // Replace PAGE_URL with your page's canonical URL variable
	// this.page.identifier = '<?php echo $title; ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
	// };

	// (function() { // DON'T EDIT BELOW THIS LINE
	// var d = document, s = d.createElement('script');
	// s.src = 'https://agendakota-1.disqus.com/embed.js';
	// s.setAttribute('data-timestamp', +new Date());
	// (d.head || d.body).appendChild(s);
	// })();

	tekan('Escape', () => {
		hilangPopup("#bagSearch")
		hilangPopup("#bagSubs")
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
	submit('#formCari', () => {
		let q = $("#q").isi()
		mengarahkan('./cari&tentang='+q)
		return false
	})
	submit('#formSubscribe', () => {
		let name = $("#nameSubs").isi()
		let email = $("#emailSubs").isi()
		let subs = "name="+name+"&email="+email
		pos('./subscribe/register', subs, () => {
			munculPopup("#bagSubs", $("#bagSubs").pengaya("top: 140px"))
		})
		return false
	})
	$("#closeSubs").klik(() => {
		hilangPopup("#bagSubs")
	})
</script>
<script id="dsq-count-scr" src="//agendakota-1.disqus.com/count.js" async></script>

</body>
</html>