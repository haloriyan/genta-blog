<?php
include 'aksi/ctrl/pages.php';
$users->sesi(1);

$id = $_GET['id'];
$titlePage = 'Create New Page';
$actionPost = 'buat';
if($id != "") {
	setcookie('idpage', $id, time() + 6555, '/');
	$titlePage = 'Edit Page';
	$title = $pages->read($id, 'title');
	$content = $pages->read($id, 'content');
	$category = $pages->read($id, 'category');
	$catPost = explode(',', $category);
	$actionPost = 'edit';
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale = 1'>
	<title><?php echo $titlePage; ?> | Agendakota</title>
	<link href='../aset/fw/build/fw.css' rel='stylesheet'>
	<link href='../aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='../aset/css/style.create.css' rel='stylesheet'>
	<link href="../aset/img/favicon.ico" rel="icon">
	<style>
		#post {
			width: 65px;
			height: 65px;
			border: none;
			color: #fff;
			font-size: 20px;
			border-radius: 60px;
			background-color: rgba(13,196,175,1);;
			position: fixed !important;
			bottom: 50px;right: 5%;
			text-align: center;
			cursor: pointer;
		}
		#post:hover { background-color: #252c41; }
		.cat {
			padding: 10px 20px;
			margin: 5px;
			border-radius: 35px;
			display: inline-block;
			color: #fff;
			position: relative;
			background-color: #485273;
		}
		.cat .category {
			position: absolute;
			width: 17px;
			height: 17px;
			position: absolute;
			z-index: 2;
			left: 0px;
			opacity: 0;
		}
		.cat .checkmark {
			transition: 0.4s;
			width: 15px;
			height: 15px;
			margin-right: 10px;
			margin-top: 3px;
			background-color: #485273;
			position: absolute;
			top: -4px;left: 0px;
			width: 100%;
			height: 43px;
			border-radius: 90px;
			float: left;
		}
		.cat .valueCheck {
			position: relative;
		}
		.category:checked ~ .checkmark {
			background-color: rgba(13,196,175,1);;
			border-radius: 90px;
		}
		#kanan {
			position: absolute;
			top: 33px;right: 5%;
			width: 35%;
		}
	</style>
</head>
<body>

<div class="atas">
	<div id="tblBack" style="cursor: pointer;" onclick="history.back(-1)" class="ke-kiri"><i class="fas fa-angle-left"></i></div>
	<h1 class="title"><?php echo $titlePage; ?></h1>
</div>

<div class="container">
	<div class="wrap">
		<form id="formPost">
			<div class="bag bag-10">
				<div class="wrap">
					<div class="isi">Title :</div>
					<input type="text" class="box" id="title" value="<?php echo $title; ?>">
					<div class="isi">Content :</div>
					<textarea id="content"><?php echo $content; ?></textarea>
				</div>
			</div>
			<button id="post"><i class="fas fa-paper-plane"></i></button>
		</form>
	</div>
</div>

<script src='../aset/ckeditor/ckeditor.js'></script>
<script src='../aset/ckfinder/ckfinder.js'></script>
<script src='../aset/js/embo.js'></script>
<script src='../aset/js/upload.js'></script>
<script>
	function base64encode(str) {
	    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
	        function toSolidBytes(match, p1) {
	            return String.fromCharCode('0x' + p1);
	    }));
	}
	function base64decode(str) {
	    // Going backwards: from bytestream, to percent-encoding, to original string.
	    return decodeURIComponent(atob(str).split('').map(function(c) {
	        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
	    }).join(''));
	}
	function post() {
		let title = $("#title").isi()
		let content = encodeURIComponent(base64encode(editor.getData()))
		let send = "title="+title+"&content="+content
		pos("./<?php echo $actionPost; ?>", send, () => {
			mengarahkan("../page")
		})
	}

	window.addEventListener('scroll', (scr) => {
		let scroll = this.scrollY
		if(scroll > 100) {
			$('#kanan').pengaya('position: fixed;top: 50px;')
		}else {
			$('#kanan').pengaya('position: absolute;top: 33px;')
		}
	})
</script>
<!-- <script src='../aset/js/script.create.js'></script> -->
<script>
	let editor
	ClassicEditor.create($("#content")).then(myEditor => {
		// console.log(editor)
		editor = myEditor
		// extraPlugins: [customUpload]
		// ckfinder: {
		// 	uploadUrl: '../../aksi/unggah.php'
		// }
	}).catch(error => {
		// console.log(error)
	})
	submit('#formPost', () => {
		post()
		return false
	})
</script>

</body>
</html>