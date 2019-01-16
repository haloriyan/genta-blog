<?php
include 'aksi/ctrl/users.php';
$sesi = $users->sesi(1);
$role = $users->me($sesi, "role");

$allCat = ["Arts & Culture","Music","Festival","Technology","Education","Sport","Travel"];

// clear cookie
setcookie('catAdmin', '', time() + 2, '/');
setcookie('titleAdmin', '', time() + 2, '/');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Posts | Agendakota</title>
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
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-edit"></i></div> <span>Post</span></li></a>
		<a href="./account"><li><div class="icon"><i class="fas fa-user"></i></div> <span>Account</span></li></a>
		<?php if($role == 1) { ?>
		<a href="./page"><li><div class="icon"><i class="fas fa-file"></i></div> <span>Pages</span></li></a>
		<a href="./user"><li><div class="icon"><i class="fas fa-users"></i></div> <span>Users</span></li></a>
		<a href="./settings"><li><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
	<?php } ?>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Posts</h1>
</div>

<div class="container">
	<div class="bag bag-10">
		<div class="bag bag-5">
			<div class="wrap">
				Sort by category :
				<select class="box" id="cat" onchange="chooseCat(this.value)">
					<option value="">All categories</option>
					<?php
					foreach ($allCat as $key => $value) {
						echo "<option>".$value."</option>";
					}
					?>
				</select>
			</div>
		</div>
		<div class="bag bag-5">
			<div class="wrap">
				Search title :
				<input type="text" class="box" id="searcPost" oninput="searchInput(this.value)">
			</div>
		</div>
	</div>
	<div class="bag bag-10">
		<div class="wrap">
			<table id="tablePosts" class="load">
				<!-- <span id="load"></span> -->
			</table>
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
<script src="aset/js/riload.js"></script>
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

	function setCookie(name, value, callback) {
		let set = "namakuki="+name+"&value="+value+"&durasi=3665"
		pos("./aksi/setCookie.php", set, () => {
			callback()
		})
	}
	// function load() {
	// 	ambil("./posts/all", (res) => {
	// 		$("#load").tulis(res)
	// 	})
	// }
	// load()

	let load = new Riload({
		el: '.load',
		dom: 'tbody',
		url: './posts/all',
		data: 'myPos=0',
		sukses: () => {
			//
		}
	})
	function chooseCat(cat) {
		setCookie('catAdmin', cat, () => {
			load()
		})
	}
	function searchInput(val) {
		setCookie('titleAdmin', val, () => {
			load()
		})
	}

	function hapus(val) {
		$("#idpost").isi(val)
		munculPopup("#bagHapus", $("#bagHapus").pengaya("top: 165px"))
	}
	submit('#formHapus', () => {
		let id = $("#idpost").isi()
		let del = "idpost="+id
		pos("./posts/delete", del, () => {
			hilangPopup("#bagHapus")
			load()
		})
		return false
	})

	tekan('Escape', () => {
		hilangPopup("#bagHapus")
	})
	$("#xHapus").klik(() => {
		hilangPopup("#bagHapus")
	})
</script>

</body>
</html>