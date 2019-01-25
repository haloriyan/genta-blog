<?php
include 'aksi/ctrl/users.php';
$sesi = $users->sesi(1);
$role = $users->me($sesi, 'role');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Users Settings</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		.popup .box {
			border-radius: 0px;
			border: none;
			border-bottom: 2px solid #ddd;
			font-size: 16px;
			color: #555;
			padding: 0px;
			width: 100%;
		}
		.popup form { margin-top: 15px; }
		form .section {
			position: relative;
			margin-bottom: 10px;
		}
		form .isi {
			color: #555;
			position: absolute;
			top: 17px;left: 0px;
			transition: 0.4s;
			font-size: 17px;
		}
		.popup .wrap { margin: 5%; }
		.box:focus ~ .isi,.box:valid ~ .isi {
			top: -10px;
			font-size: 15px;
		}
		.box:focus { border-bottom: 2px solid rgba(13,196,175,1); }
		form #notif {
			background: #e74c3c90;
			color: #fff;
			line-height: 50px;
			height: 50px;
			display: none;
		}
		form #notif .ke-kiri { margin-left: 5%; }
		form #notif .ke-kanan { margin-right: 5%; }
		#newUser {
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
		#newUser:hover { background-color: #252c41; }
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
		<a href="./page"><li><div class="icon"><i class="fas fa-file"></i></div> <span>Pages</span></li></a>
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-users"></i></div> <span>Users</span></li></a>
		<a href="./settings"><li><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
		<?php } ?>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Users Settings</h1>
</div>

<div class="container">
	<div class="bag bag-10">
		<div class="wrap">
			<table id="tablePosts">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th style="width: 20%">Role</th>
					</tr>
				</thead>
				<tbody id="loadUser"></tbody>
			</table>
		</div>
	</div>
</div>

<div id="newUser" onclick="newUser()"><i class="fas fa-plus"></i></div>

<div class="bg"></div>
<div class="popupWrapper" id="bagTambah">
	<div class="popup">
		<div class="wrap">
			<h3>Add New User
				<div class="ke-kanan" id="xTambah"><i class="fas fa-times"></i></div>
			</h3>
			<form id="formTambah">
				<div class="section">
					<input type="text" class="box" required id="nameAdd">
					<label class="isi">Name</label>
				</div>
				<div class="section">
					<input type="text" class="box" required id="emailAdd">
					<label class="isi">Email</label>
				</div>
				<div class="section">
					<input type="password" class="box" required id="pwdAdd">
					<label class="isi">Password</label>
				</div>
				<div class="section">
					<select class="box" id="roleAdd">
						<option value="">Select Role...</option>
						<option value="1">Admin</option>
						<option value="0">User</option>
					</select>
					<label class="isi">Role</label>
				</div>
				<div id="notif">
					<div id="isiNotif" class="ke-kiri">Select role</div>
					<div class="ke-kanan" id="xNotif"><i class="fas fa-times"></i></div>
				</div>
				<div class="bag-tombol">
					<button class="ya">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="popupWrapper" id="bagHapus">
	<div class="popup">
		<div class="wrap">
			<h3>Delete User
				<div class="ke-kanan" id="xDel"><i class="fas fa-times"></i></div>
			</h3>
			<form id="formHapus">
				<input type="hidden" id="iduser">
				<p>Sure delete this user?</p>
				<button class="ya">Yes</button>
				<button class="tidak" type="button" id="noDel">No</button>
			</form>
		</div>
	</div>
</div>
<div class="popupWrapper" id="bagEdit">
	<div class="popup">
		<div class="wrap">
			<h3>Set Permission
				<div class="ke-kanan" id="xEdit"><i class="fas fa-times"></i></div>
			</h3>
			<form id="formEdit">
				<select class="box" id="perm">
					<option value="">Select role...</option>
					<option value="1">Admin</option>
					<option value="0">User</option>
				</select>
				<button class="ya">Yes</button>
				<button class="tidak" type="button" id="noSet">No</button>
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
		ambil('./users/all', (res) => {
			$("#loadUser").tulis(res)
		})
	}
	load()

	function hapus(id) {
		$('#iduser').isi(id)
		munculPopup('#bagHapus', $('#bagHapus').pengaya('top: 200px'))
	}
	function newUser() {
		munculPopup('#bagTambah', $('#bagTambah').pengaya('top: 100px'))
	}
	function edit(id) {
		$('#iduser').isi(id)
		munculPopup('#bagEdit', $('#bagEdit').pengaya('top: 180px'))
	}

	submit('#formTambah', () => {
		let name = $('#nameAdd').isi()
		let email = $('#emailAdd').isi()
		let pwd = $('#pwdAdd').isi()
		let role = $('#roleAdd').isi()
		if(role == '') {
			$('#notif').muncul()
			$('#isiNotif').tulis('You must select role for this user')
			return false
		}
		let add = "name="+name+"&email="+email+"&pwd="+pwd+"&role="+role
		pos('./users/add', add, () => {
			hilangPopup('#bagTambah')
			load()
		})
		return false
	})
	submit('#formHapus', () => {
		let id = $('#iduser').isi()
		let del = 'iduser='+id
		pos('./users/delete', del, () => {
			hilangPopup('#bagHapus')
			load()
		})
		return false
	})
	submit('#formEdit', () => {
		let role = $('#perm').isi()
		let id = 'iduser='+$('#iduser').isi()+'&role='+role
		pos('./users/setPermission', id, () => {
			hilangPopup('#bagEdit')
			load()
		})
		return false
	})
	$('#xNotif').klik(() => {
		$('#notif').hilang()
	})
	$('#xTambah').klik(() => {
		hilangPopup('#bagTambah')
	})
	$('#noDel').klik(() => {
		hilangPopup('#bagHapus')
	})
	$('#xDel').klik(() => {
		hilangPopup('#bagHapus')
	})
	$('#noSet').klik(() => {
		hilangPopup('#bagEdit')
	})
	$('#xEdit').klik(() => {
		hilangPopup('#bagEdit')
	})
	tekan('Escape', () => {
		hilangPopup('#bagHapus')
		hilangPopup('#bagTambah')
		hilangPopup('#bagEdit')
	})
</script>

</body>
</html>