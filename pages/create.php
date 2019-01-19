<?php
include 'aksi/ctrl/posts.php';
$users->sesi(1);

$id = $_GET['id'];
$titlePage = 'Create New Post';
$actionPost = 'create';
if($id != "") {
	setcookie('idpost', $id, time() + 4555, '/');
	$titlePage = 'Edit Post';
	$title = $posts->read($id, 'title');
	$content = $posts->read($id, 'content');
	$category = $posts->read($id, 'category');
	$hashtag = $posts->read($id, 'hashtag');
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
	<link href='aset/fw/build/fw.css' rel='stylesheet'>
	<link href='aset/fw/build/fontawesome-all.min.css' rel='stylesheet'>
	<link href='aset/css/style.create.css' rel='stylesheet'>
	<link href="aset/img/favicon.ico" rel="icon">
	<style>
		#post {
			width: 65px;
			line-height: 65px;
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
		#suggestion,#suggestCat {
			box-shadow: 1px 1px 5px 1px #ddd;
			color: #555;
			display: none;
			border-radius: 6px;
		}
		#suggestion button,#suggestCat button {
			background: none;
			border: none;
			font-size: 16px;
			width: 95%;
			height: 40px;
			transition: 0.35s;
		}
		#suggestion li:hover,#suggestCat li:hover, 
		#suggestion li:hover button ,#suggestCat li:hover button { background-color: #485273;color: #fff; }
		#suggestion li,#suggestCat li {
			list-style: none;
			line-height: 40px;
			transition: 0.4s;
		}
		span.del:hover { color: #e74c3c;transition: 0.4s;cursor: pointer; }
		#suggestion li:nth-child(1) button,
		#suggestCat li:nth-child(1) button { border-top-left-radius: 6px;border-top-right-radius: 6px; }
		#suggestion li:nth-last-child(1) button,
		#suggestCat li:nth-last-child(1) button { border-bottom-left-radius: 6px;border-bottom-right-radius: 6px; }
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
			<div class="bag bag-6">
				<div class="wrap">
					<div class="isi">Title :</div>
					<input type="text" class="box" id="title" value="<?php echo $title; ?>">
					<div class="isi">Content :</div>
					<textarea id="content"><?php echo $content; ?></textarea>
				</div>
			</div>
			<div class="bag bag-4" id="kanan">
				<div class="wrap">
					<div class="bagian">
						<h3>Cover</h3>
						<input type="hidden" id="cover">
						<input type="file" id="inputCover" class="box">
					</div>
					<div class="bagian">
						<h4>Category</h4>
						<input type="text" id="category" class="box" oninput="cekCat(this.value)" autocomplete="off" value="<?php echo $category; ?>">
						<div id="suggestCat"></div>
						<?php
						// $cat = ["Featured","Arts & Culture","Music","Festival","Technology","Education","Sport","Travel","MICE","Event Planning","Business","Marketing"];
						// foreach ($cat as $key => $value) {
						// 	if(in_array($value, $catPost)) {
						// 		$check = "checked";
						// 	}else {
						// 		$check = "";
						// 	}
						// 	echo "<label for='cat".$key."'><div class='cat primer'>".
						// 			"<input type='checkbox' class='category' onclick='checkCat()' name='category[]' ".$check." value='".$value."' id='cat".$key."'><div class='checkmark'></div><div class='valueCheck'>".$value."</div>".
						// 		 "</div></label>";
						// }
						?>
					</div>
					<div class="bagian">
						<h4>Hashtag</h4>
						<input type="text" class="box" id="hashtag" oninput="cekHashtag(this.value)" autocomplete="off" value="<?php echo $hashtag; ?>">
						<div id="suggestion"></div>
					</div>
				</div>
			</div>
		</form>
		<div id="post"><i class="fas fa-paper-plane"></i></div>
	</div>
</div>

<script src='aset/ckeditor/ckeditor.js'></script>
<script src='aset/ckfinder/ckfinder.js'></script>
<script src='aset/js/embo.js'></script>
<script src='aset/js/upload.js'></script>
<script src='aset/js/script.create.js'></script>

</body>
</html>