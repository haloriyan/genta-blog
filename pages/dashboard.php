<?php
include 'aksi/ctrl/users.php';
$users->sesi(1);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Dashboard</title>
	<link href="aset/fw/build/fw.css" rel="stylesheet">
	<link href="aset/fw/build/fontawesome-all.min.css" rel="stylesheet">
	<link href="aset/css/dashboard.css" rel="stylesheet">
</head>
<body>

<div class="kiri">
	<div class="logo">
		<img src="aset/img/AK-putih.png">
	</div>
	<div class="wrap">
		<a href="#"><li aktif='ya'><div class="icon"><i class="fas fa-home"></i></div> <span>Dashboard</span></li></a>
		<!-- <a href="#"><li><div class="icon"><i class="fas fa-home"></i></div> <span>Dashboard</span>
			<ul class="sub">
				<a href="#"><li><div class="icon"><i class="fas fa-home"></i></div> <span>SUB MENU</span></li></a>
				<a href="#"><li><div class="icon"><i class="fas fa-home"></i></div> <span>SUB MENU</span></li></a>
			</ul>
		</li></a> -->
		<a href="./post"><li><div class="icon"><i class="fas fa-edit"></i></div> <span>Post</span></li></a>
		<a href="./comment"><li><div class="icon"><i class="fas fa-comment"></i></div> <span>Comment</span></li></a>
		<a href="./setting"><li><div class="icon"><i class="fas fa-cogs"></i></div> <span>Settings</span></li></a>
		<a href="./logout"><li><div class="icon"><i class="fas fa-sign-out-alt"></i></div> <span>Sign Out</span></li></a>
	</div>
</div>
<div class="atas">
	<div id="tblMenu" aksi='xMenu'><i class="fas fa-bars"></i></div>
	<h1 class="title">Dashboard</h1>
</div>

<div class="container">
	<div class="card">
		<div class="wrap">
			<div class="bag bag-3">
				<div class="icon"><i class="fas fa-eye"></i></div>
			</div>
			<div class="bag bag-7">
				<h3>155 read</h3>
				<p>This month</p>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="wrap">
			<div class="bag bag-3">
				<div class="icon"><i class="fas fa-eye"></i></div>
			</div>
			<div class="bag bag-7">
				<h3>155 read</h3>
				<p>This month</p>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="wrap">
			<div class="bag bag-3">
				<div class="icon"><i class="fas fa-eye"></i></div>
			</div>
			<div class="bag bag-7">
				<h3>155 read</h3>
				<p>This month</p>
			</div>
		</div>
	</div>
	<div class="bag bag-10">
		<div class="wrap">
			<canvas id="myChart"></canvas>
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

	let canvas = $("#myChart")
	let myChart = new Chart(canvas, {
		type: 'line',
		data: {
	        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
	        datasets: [{
	            label: '# of Votes',
	            data: [12, 19, 3, 5, 2, 3],
	            backgroundColor: [
	                '#3498db65',
	            ],
	            borderColor: [
	                '#2980b9',
	            ],
	            borderWidth: 1
	        }]
	    }
	})
</script>

</body>
</html>