<?php
$kuki = $_COOKIE['kukiLogin'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>Login | Agendakota</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='aset/css/style.auth.css' rel='stylesheet'>
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		a { color: #485273; }
	</style>
	<script src='aset/js/embo.js'></script>
</head>
<body>

<div class="container">
	<div class="wrap">
		<div class="rata-tengah">
			<img src="aset/img/AKO.png">
		</div>
		<form id="formLogin">
			<div class="bagForm">
				<input type="text" class="box" id="email" required>
				<label class="isi">Email :</label>
			</div>
			<div class="bagForm">
				<input type="password" class="box" id="pwd" required>
				<label class="isi">Password :</label>
			</div>
			<div class="bag-tombol">
				<button>LOGIN</button>
			</div>
			<div class="rata-tengah" style="margin-top: 25px;">
				<a href="./forgot-password">Lupa kata sandi?</a>
			</div>
		</form>
	</div>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="notif">
	<div class="popup">
		<div class="wrap">
			<p><?php echo $kuki; ?></p>
			<div class="bag-tombol">
				<button id="xNotif">CLOSE</button>
			</div>
		</div>
	</div>
</div>

<?php
if($kuki != "") {
	echo '<script>
munculPopup("#notif", $("#notif").pengaya("top: 180px"))
</script>';
}
?>

<script src='aset/js/script.auth.js'></script>

</body>
</html>