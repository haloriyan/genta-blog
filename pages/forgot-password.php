<?php
$kuki = $_COOKIE['kukiLogin'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title>Reset Password | Agendakota</title>
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='aset/css/style.auth.css' rel='stylesheet'>
	<link href="aset/img/favicon.ico" rel="icon">
	<script src='aset/js/embo.js'></script>
</head>
<body>

<div class="container" style="color: #454545;top: 150px;">
	<div class="wrap">
		<form id="formForgot">
			<H3>Reset Password</H3>
			<div class="bagForm">
				<input type="text" class="box" id="email" required>
				<label class="isi">Email :</label>
			</div>
			<div class="bag-tombol">
				<button>RESET</button>
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

<script>
	function setNotif(notif) {
		munculPopup("#notif", $("#notif").pengaya("top: 180px"))
		$("#notif p").tulis(notif)
	}
	submit('#formForgot', () => {
		let email = $("#email").isi()
		let forgot = "email="+email
		pos("./users/forgotPassword", forgot, () => {
			setNotif("Your password has been sent via email")
		})
		return false
	})
	$("#xNotif").klik(() => {
		hilangPopup("#notif")
	})
	tekan('Escape', () => {
		hilangPopup("#notif")
	})
</script>

</body>
</html>