<?php
include 'aksi/ctrl/users.php';
$sesi = $users->sesi(1);

$iduser = $users->me($sesi, 'iduser');
$name = $users->me($sesi, 'name');
$email = $users->me($sesi, 'email');
$photo = $users->me($sesi, 'photo');
$totArtikel = $users->totArtikel($iduser);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Account Settings | Agendakota</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
	<style>
		#profile {
			background-color: #485273;
			color: #fff;
			border-radius: 0px;
			border: none;
			text-align: center;
			width: 35%;
		}
		#profile img {
			width: 100px;
			height: 100px;
			border-radius: 165px;
			margin-top: -70px;
		}
		#profile .cover {
			height: 150px;
		}
		h3 {
			font-family: ProBold;
			font-size: 30px;
		}
		#profile p {
			font-size: 20px;
			font-family: ProReg;
			margin-top: -10px;
		}
		#profile .ket {
			background-color: #fff;
			padding: 1px;
			color: #444;
			border: 1px solid #ddd;
			border-top: none;
		}
		#editProfile {
			background-color: rgba(13,196,175,1);
			color: #fff;
			border: none;
			width: 60%;
			height: 50px;
			border-radius: 90px;
			margin: 20px 0px 25px 0px;
			cursor: pointer;
			font-size: 16px;
			font-family: ProBold;
			transition: 0.4s;
		}
		#editProfile:hover { background-color: #0ba895; }
		#myTopArticle {
			margin-left: 5%;
		}
		#myTopArticle li {
			list-style: none;
			line-height: 50px;
			border-bottom: 1px solid #ddd;
		}
		#myTopArticle li a { color: #444;text-decoration: none; }
		#myTopArticle li a:hover { text-decoration: underline; }
		#bagEdit { display: none; }
		#bagEdit .box {
			width: 100%;
			border-radius: 0px;
			border: none;
			padding: 0px;
			border-bottom: 2px solid #ddd;
			font-size: 17px;
		}
		#bagEdit .box:focus { border-bottom: 2px solid rgba(13,196,175,1); }
		#save { background-color: rgba(13,196,175,1);color: #fff; }
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
		<a href="./comment"><li><div class="icon"><i class="fas fa-comment"></i></div> <span>Comment</span></li></a>
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-user"></i></div> <span>Account Settings</span></li></a>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Account</h1>
</div>

<div class="container">
	<div class="bag bag-10" id="bagEdit">
		<div class="wrap">
			<form id="formEdit">
				<h3>Edit Profile</h3>
				<div>Name :</div>
				<input type="text" class="box" id="nameEdit" value="<?php echo $name; ?>" required>
				<div>E-Mail :</div>
				<input type="text" class="box" id="emailEdit" value="<?php echo $email; ?>" required>
				<h3>Change Photo</h3>
				<div>Photo :</div>
				<input type="hidden" id="photoInput">
				<input type="file" id="photo" class="box">
				<button class="tbl" id="save">Save</button> &nbsp;
				<button type="button" class="tbl merah" onclick="cancelEdit()">Cancel</button>
			</form>
		</div>
	</div>
	<div class="bag" id="profile"></div>
	<div class="bag bag-6" id="myTopArticle">
		<div class="wrap">
			<h3>My Top Article</h3>
			<div id="loadArticle"></div>
		</div>
	</div>
</div>

<div id="createPost" onclick="mengarahkan('./create')"><i class="fas fa-pencil-alt"></i></div>

<div class="bg"></div>
<div class="popupWrapper" id="bagHapus">
	<div class="popup">
		<div class="wrap">
			<p>
				Yakin ingin menghapus artikel ini?
			</p>
			<form id="formHapus">
				<input type="hidden" id="idpost">
				<button class="ya">Ya</button>
				<button class="tidak" id="xHapus" type="button">Tidak</button>
			</form>
		</div>
	</div>
</div>

<script src="aset/js/embo.js"></script>
<script src="aset/js/chart.min.js"></script>
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
	function load() {
		ambil("./users/myTopArticle", (res) => {
			$("#loadArticle").tulis(res)
		})
	}
	function loadProfile() {
		ambil("./users/loadProfile", (res) => {
			$("#profile").tulis(res)
		})
	}
	load()
	loadProfile()
	function editProfile() {
		$("#profile").hilang()
		$("#myTopArticle").hilang()
		$("#bagEdit").muncul()
	}
	function cancelEdit() {
		$("#profile").pengaya("display: inline-block;")
		$("#myTopArticle").pengaya("display: inline-block;")
		$("#bagEdit").hilang()
	}
	submit('#formEdit', () => {
		let name = $("#nameEdit").isi()
		let email = $("#emailEdit").isi()
		let photo = $("#photoInput").isi()
		let edit = "name="+name+"&email="+email+"&photo="+photo
		pos("./users/edit", edit, () => {
			cancelEdit()
			loadProfile()
		})
		return false
	})
</script>

</body>
</html>