<?php
include 'aksi/ctrl/users.php';
$sesi = $users->sesi(1);
$role = $users->me($sesi, "role");

$description = $configs->get('description');
$keyword = $configs->get('keyword');
$facebook = $configs->get('facebook');
$twitter = $configs->get('twitter');
$instagram = $configs->get('instagram');
$youtube = $configs->get('youtube');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Settings</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		textarea.box {
			width: 94%;
		}
		.box { font-size: 16px; }
	</style>
</head>
<body>

<div class="kiri">
	<div class="logo">
		<img src="aset/img/AK-putih.png">
	</div>
	<div class="wrap">
		<a href="./dashboard"><li><div class="icon"><i class="fas fa-home"></i></div> <span>Dashboard</span></li></a>
		<a href="./post"><li><div class="icon"><i class="fas fa-edit"></i></div> <span>Post</span></li></a>
		<a href="./account"><li><div class="icon"><i class="fas fa-user"></i></div> <span>Account</span></li></a>
		<?php if($role == 1) { ?>
		<a href="./page"><li><div class="icon"><i class="fas fa-file"></i></div> <span>Pages</span></li></a>
		<a href="./user"><li><div class="icon"><i class="fas fa-users"></i></div> <span>Users</span></li></a>
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
		<?php } ?>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Settings</h1>
</div>

<div class="container">
	<div class="bag bag-10">
		<div class="wrap">
			<h2>SEO Setting</h2>
			<form id="formSeo">
				<div class="isi">Description :</div>
				<textarea class="box" id="desc"><?php echo $description; ?></textarea>
				<div class="isi">Keyword :</div>
				<textarea class="box" id="kw"><?php echo $keyword; ?></textarea>
				<button class="ya">Save</button>
			</form>
		</div>
	</div>
	<div class="bag bag-6">
		<div class="wrap">
			<h3>Social Account</h3>
			<form id="formSocial">
				<div class="isi">Facebook :</div>
				<input type="text" class="box" id="fbUrl" value="<?php echo $facebook; ?>">
				<div class="isi">Twitter :</div>
				<input type="text" class="box" id="twitterUrl" value="<?php echo $twitter; ?>">
				<div class="isi">Instagram :</div>
				<input type="text" class="box" id="igUrl" value="<?php echo $instagram; ?>">
				<div class="isi">Youtube :</div>
				<input type="text" class="box" id="ytUrl" value="<?php echo $youtube; ?>">
				<button class="ya">Save</button>
			</form>
		</div>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="notif">
	<div class="popup">
		<div class="wrap">
			<h3>Alert!
				<div class="ke-kanan" id="xNotif"><i class="fas fa-times"></i></div>
			</h3>
			<p id="isiNotif">Hello world</p>
		</div>
	</div>
</div>

<script src="aset/js/embo.js"></script>
<script>
	$("#tblMenu").klik(function() {
		let aksi = this.atribut('aksi')
		if(aksi == 'xMenu') {
			$(".kiri").pengaya("left: -100%")
			$(".atas").pengaya("left: 0%")
			$(".container").pengaya("left: 5%")
			this.atribut('aksi', 'bkMenu')
		}else {
			$(".kiri").pengaya("left: 0%")
			$(".atas").pengaya("left: 20%")
			$(".container").pengaya("left: 24%")
			this.atribut('aksi', 'xMenu')
		}
	})
	function setNotif(notif) {
		munculPopup("#notif", $("#notif").pengaya("top: 200px"))
		$("#isiNotif").tulis(notif)
		setTimeout(() => {
			hilangPopup("#notif")
		}, 1500)
	}
	submit('#formSeo', () => {
		let desc = $("#desc").isi()
		let kw = $("#kw").isi()
		let seo = "desc="+desc+"&kw="+kw
		pos('./configs/seo', seo, () => {
			setNotif('Saved')
		})
		return false
	})
	submit('#formSocial', () => {
		let fb = $("#fbUrl").isi()
		let twitter = $("#twitterUrl").isi()
		let ig = $("#igUrl").isi()
		let yt = $("#ytUrl").isi()
		let social = "fb="+fb+"&twitter="+twitter+"&ig="+ig+"&yt="+yt
		pos('./configs/social', social, () => {
			setNotif('Saved')
		})
		return false
	})
	tekan('Escape', () => {
		hilangPopup("#notif")
	})
	$("#xNotif").klik(() => {
		hilangPopup("#notif")
	})
</script>

</body>
</html>