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
			background-color: #485273;
		}
		.cat .category {
			position: absolute;
			width: 17px;
			height: 17px;
			margin: -1px 0px 0px -30px;
			opacity: 0;
		}
		.cat .checkmark {
			transition: 1.4s;
			width: 15px;
			height: 15px;
			margin-right: 10px;
			margin-top: 3px;
			background-color: #aaa;
			float: left;
		}
		.category:checked ~ .checkmark {
			background-color: #fff;
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
						<input type="hidden" id="category">
						<?php
						$cat = ["Arts & Culture","Music","Festival","Technology","Education","Sport","Travel"];
						foreach ($cat as $key => $value) {
							if(in_array($value, $catPost)) {
								$check = "checked";
							}else {
								$check = "";
							}
							echo "<label for='cat".$key."'><div class='cat primer'>".
									"<input type='checkbox' class='category' onclick='checkCat()' name='category[]' ".$check." value='".$value."' id='cat".$key."'><div class='checkmark'></div>".$value.
								 "</div></label>";
						}
						?>
					</div>
					<div class="bagian">
						<h4>Premium Post?</h4>
						<select class="box" id="premium">
							<!-- <option value="1">Yes</option>
							<option value="0" selected>No</option> -->
							<?php
							$optPremium = ["1" => "Yes", "0" => "No"];
							foreach ($optPremium as $key => $value) {
								echo "<option value='".$key."'>".$value."</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</form>
		<div id="post"><i class="fas fa-paper-plane"></i></div>
	</div>
</div>

<script src='aset/ckeditor/ckeditor.js'></script>
<script src='aset/js/embo.js'></script>
<script src='aset/js/upload.js'></script>
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
		let cover = $("#cover").isi()
		let category = encodeURIComponent($("#category").isi())
		let premium = $("#premium").isi()
		let send = "title="+title+"&content="+content+"&cover="+cover+"&category="+category+"&premium="+premium
		pos("./posts/<?php echo $actionPost; ?>", send, () => {
			mengarahkan("./post")
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
<script src='aset/js/script.create.js'></script>

</body>
</html>