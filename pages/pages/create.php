<?php
include 'aksi/ctrl/laman.php';
$users->sesi(1);

$id = $_GET['id'];
$titlePage = 'Create New Page';
$actionPost = 'buat';
if($id != "" && $id != 0) {
	setcookie('idpage', $id, time() + 6555, '/');
	$titlePage = 'Edit Page';
	$title = $laman->read($id, 'title');
	$content = $laman->read($id, 'content');
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
		.box { width: 95%; }
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
					<div class="isi">Cover :</div>
					<input type="file" id="image" class="box">
					<div class="isi">Content :</div>
					<textarea id="content"><?php echo $content; ?></textarea>
				</div>
			</div>
			<button id="post"><i class="fas fa-paper-plane"></i></button>
		</form>
	</div>
</div>

<script src='../aset/ckeditor/ckeditor.js'></script>
<script src='../aset/js/embo.js'></script>
<script src='../aset/js/upload.js'></script>
<script>
class MyUploadAdapter {
	constructor(loader) {
		this.loader = loader
	}
	upload() {
		return new Promise((resolve, reject) => {
			this._initRequest()
			this._initListeners(resolve, reject)
			this._sendRequest()
		})
	}
	abort() {
		if(this.xhr) {
			this.xhr.abort()
		}
	}

	_initRequest() {
		const xhr = this.xhr = new XMLHttpRequest()
		xhr.open('POST', '../aksi/unggah.php', true)
		xhr.responseType = 'json'
	}
	_initListeners(resolve, reject) {
		const xhr = this.xhr
		const loader = this.loader
		const genericErrorText = "Cant upload file"

		xhr.addEventListener('error', () => reject(genericErrorText))
		xhr.addEventListener('abort', () => reject())
		xhr.addEventListener('load', () => {
			const response = xhr.response
			if(!response || response.error) {
				return reject(response && response.error ? response.error.message : genericErrorText)
			}
			resolve( {
                default: response.url
            } );
		})

		if(xhr.upload) {
			xhr.upload.addEventListener('progress', evt => {
				if(evt.lengthComputable) {
					loader.uploadTotal = evt.total
					loader.uploaded = evt.loaded
				}
			})
		}
	}
	_sendRequest() {
		const data = new FormData()
		data.append('file', this.loader.file)
		this.xhr.send(data)
	}
}

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}
	let allowedExtension = ['image/png','image/jpg','image/jpeg','image/gif']
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
		let cover = $("#image").files[0]
		let coverName
		if(cover !== undefined) {
			coverName = cover.name
			if(!inArray(cover.type, allowedExtension)) {
				alert('Image extension not supported')
				return false
			}
			var upload = new Upload(cover, "../aksi/unggah.php");
			upload.doUpload();
		}
		let send = "title="+title+"&content="+content+"&cover="+coverName
		pos("../laman/<?php echo $actionPost; ?>", send, () => {
			mengarahkan("../page")
		})
	}
	function sukses() {
		console.log('uploaded')
	}
</script>
<!-- <script src='../aset/js/script.create.js'></script> -->
<script>
	let editor
	ClassicEditor.create($("#content"), {
		extraPlugins: [MyCustomUploadAdapterPlugin]
	}).then(myEditor => {
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