<?php
include 'aksi/ctrl/users.php';
$sesi = $users->sesi(1);
$role = $users->me($sesi, "role");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Pages</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		#createPost {
			width: 65px;
			line-height: 65px;
			color: #fff;
			font-size: 20px;
			border-radius: 60px;
			background-color: #485273;
			position: fixed;
			bottom: 50px;right: 5%;
			text-align: center;
			cursor: pointer;
		}
		#createPost:hover { background-color: #252c41; }
		a { color: #444;text-decoration: none; }
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
		<a href="./category"><li><div class="icon"><i class="fas fa-tags"></i></div> <span>Category</span></li></a>
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-file"></i></div> <span>Pages</span></li></a>
		<a href="./user"><li><div class="icon"><i class="fas fa-users"></i></div> <span>Users</span></li></a>
		<a href="./settings"><li><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
		<?php } ?>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Pages</h1>
</div>

<div class="container">
	<div class="bag bag-10">
		<div class="wrap">
			<table id="tablePosts">
				<tbody id="load"></tbody>
			</table>
		</div>
	</div>
</div>

<div id="createPost" onclick="mengarahkan('./pages/create&id=0')"><i class="fas fa-pencil-alt"></i></div>

<div class="bg"></div>
<div class="popupWrapper" id="bagHapus">
	<div class="popup">
		<div class="wrap">
			<h3>Hapus Laman
				<div class="ke-kanan" id="xDel"><i class="fas fa-times"></i></div>
			</h3>
			<form id="formDelete">
				<input type="hidden" id="idpage">
				<p>Ingin menghapus Laman ini?</p>
				<button class="ya">Ya</button>
				<button class="tidak" id="tdkHapus" type="button">Tidak</button>
			</form>
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
	function load() {
		ambil('./laman/all', (res) => {
			$("#load").tulis(res)
		})
	}
	function hapus(id) {
		$("#idpage").isi(id)
		munculPopup("#bagHapus", $("#bagHapus").pengaya("top: 200px"))
	}
	load()
	submit('#formDelete', () => {
		let del = "idpage="+$("#idpage").isi()
		pos('./laman/delete', del, () => {
			hilangPopup("#bagHapus")
			load()
		})
		return false
	})

	$("#tdkHapus").klik(() => {
		hilangPopup("#bagHapus")
	})
	$("#xDel").klik(() => {
		hilangPopup("#bagHapus")
	})
	tekan('Escape', () => {
		hilangPopup("#bagHapus")
	})
</script>

</body>
</html>