<?php
include 'aksi/ctrl/posts.php';
$sesi = $users->sesi(1);
$role = $users->me($sesi, "role");

$images = ["art.png","attraction.png","business.png","conference.png","entertainment.png","exhibitions.png","family.png","fashion.png","festivals.png","fb.png","meetups.png","music.png","seminar.png","show.png","social.png","sport.png"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Category</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		.cat {
			width: 20%;
			float: left;
			text-align: center;
		}
		.cat img {
			width: 100px;
			height: 100px;
		}
		.cat:hover {
			background-color: rgba(13,196,175,0.1);
		}
		.cat h4 { margin-top: 5px; }
		#bagNew img {
			width: 20%;
		}
		input[type=radio] { display: none; }
		.cawang {
			display: inline-block;
			width: 30px;
			line-height: 30px;
			background-color: #2ecc71;
			color: #fff;
			text-align: center;
			border-radius: 40px;
			font-size: 10px;
			display: none;
			position: relative;
			left: 0px;top: -10px;
			margin-left: -35px;
		}
		input[type=radio]:checked ~ .cawang { display: inline-block; }
		.tblDelete {
			color: #e74c3c;
		}
		.tblDelete:hover {
			background-color: #e74c3c20;
		}
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
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-tags"></i></div> <span>Category</span></li></a>
		<a href="./page"><li><div class="icon"><i class="fas fa-file"></i></div> <span>Pages</span></li></a>
		<a href="./user"><li><div class="icon"><i class="fas fa-users"></i></div> <span>Users</span></li></a>
		<a href="./settings"><li><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
		<?php } ?>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Category</h1>
</div>

<div class="container">
	<div class="bag bag-10">
		<div class="wrap">
			<div class="bag bag-6">
				<div class="rata-kanan">
					<button id="tblNew" class="tbl ya"><i class="fas fa-plus"></i>&nbsp; New</button>
				</div>
			</div>
			<div class="bag bag-10">
				<div id="loadCat"></div>
			</div>
		</div>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="bagNew">
	<div class="popup">
		<div class="wrap">
			<h3>New Category
				<div class="ke-kanan" id="xNewCat"><i class="fas fa-times"></i></div>
			</h3>
			<form id="newCat">
				<div class="isi">Name :</div>
				<input type="text" class="box" id="tag">
				<div class="isi">Icon :</div>
				<?php
				foreach ($images as $key => $value) {
					echo "<label for='icon".$key."'><img src='aset/img/icon/".$value."'>".
						 "<input type='radio' onclick='choose(this.value)' id='icon".$key."' name='icon' value='".$value."'><div class='cawang'><i class='fas fa-check'></i></div></label>";
				}
				?>
				<br />
				<button class="ya">Create</button>
			</form>
		</div>
	</div>
</div>
<div class="popupWrapper" id="bagDel">
	<div class="popup">
		<div class="wrap">
			<h3>Delete Category
				<div class="ke-kanan" id="xDel"><i class="fas fa-times"></i></div>
			</h3>
			<form id="delCat">
				<input type="hidden" id="toDel">
				<p>Sure want to delete <b><span id="showCat"></span></b> ?</p>
				<button class="ya">Delete</button>
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
	let icon
	function choose(that) {
		icon = that
	}

	function load() {
		pos('./posts/allCat', 'a=1', (res) => {
			$("#loadCat").tulis(res)
		})
	}
	load()
	function hapus(val) {
		$("#toDel").isi(val)
		$("#showCat").tulis(val)
		munculPopup("#bagDel", $("#bagDel").pengaya("top: 125px"))
	}

	submit('#newCat', () => {
		let tag = encodeURIComponent($("#tag").isi())
		pos('./posts/createHashtag', 'tag='+tag+'&type=1&icon='+icon, (res) => {
			hilangPopup("#bagNew")
			$("#tag").isi('')
			load()
		})
		return false
	})
	submit('#delCat', () => {
		let tag = $("#toDel").isi()
		pos('./posts/deleteHashtag', 'tag='+tag+'&type=1', (res) => {
			hilangPopup("#bagDel")
			load()
		})
		return false
	})

	$("#tblNew").klik(() => {
		munculPopup("#bagNew", $("#bagNew").pengaya("top: 5px"))
	})
	// munculPopup("#bagNew", $("#bagNew").pengaya("top: 5px"))

	tekan('Escape', () => {
		hilangPopup("#bagNew")
		hilangPopup("#bagDel")
	})
	$("#xNewCat").klik(() => {
		hilangPopup("#bagNew")
	})
	$("#xDel").klik(() => {
		hilangPopup("#bagDel")
	})
</script>

</body>
</html>