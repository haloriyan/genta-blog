// function customUpload(editor) {
// 	editor.plugins.get('FileRepository').createUploadAdapter =  (loader) => {
// 		return new myUploadAdapter(loader, '../img/')
// 	}
// }

// class myUploadAdapter {
// 	constructor(loader, url) {
// 		this.loader = loader
// 		this.url = url
// 	}
// 	upload() {
// 		return new Promise((resolve, reject) => {
// 			this._initRequest()
// 			this._initListeners(resolve, reject)
// 			this._sendRequest()
// 		})
// 	}
// 	abort() {
// 		if(this.xhr) {
// 			this.xhr.abort()
// 		}
// 	}
// 	_initRequest() {
// 		const xhr = this.xhr = new XMLHttpRequest()
// 		xhr.open('POST', this.url, true)
// 	}
// 	_initListeners(resolve, reject) {
// 		const xhr = this.xhr
// 		const loader = this.loader
// 		const errorText = "Cant upload";

// 		xhr.addEventListener('error', () => reject(errorText))
// 		xhr.addEventListener('abort', () => reject())
// 		xhr.addEventListener('load', () => {
// 			const res = xhr.response
// 			if(!res || res.error) {
// 				return reject(res.error)
// 			}
// 			resolve({
// 				default: res.url
// 			})
// 		})
// 		if(xhr.upload) {
// 			xhr.upload.addEventListener('progress', evt => {
// 				if(evt.lengthComputable) {
// 					loader.uploadTotal = evt.total
// 					loader.uploaded = evt.loaded
// 				}
// 			})
// 		}
// 	}
// 	_sendRequest() {
// 		const data = new FormData()
// 		data.append('upload', this.loader.file)
// 		this.xhr.send(data)
// 	}
// }

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

function getExt(val) {
	let re =/(?:\.([^.]+))?$/
	let ext = re.exec(val)[1]
	return ext
}
$("#inputCover").di('ganti', function(the) {
	let allowed = ["jpg","jpeg","png","bmp"]
	var file = the.srcElement.files[0]
	var cover = $("#inputCover").isi();
	var c = cover.split("fakepath");
	var cov = c[1].substr(1, 2599);
	$("#cover").isi(cov);
	let coverExt = getExt(cov)
	if(!inArray(coverExt, allowed)) {
		$("#cover").isi('')
		document.querySelector("#inputCover").value = ""
		alert("Image format not allowed")
		return false
	}
	var upload = new Upload(file);
	upload.doUpload();
})
function sukses() {
	console.log('uploaded')
}

function checkCat() {
	let checkedValue = []
	let checked = document.getElementsByName('category[]')
	for(var i = 0; i < checked.length; i++) {
		if(checked[i].checked) {
			checkedValue.push(checked[i].value)
		}
	}
	$("#category").isi(checkedValue.toString())
}

submit('#formPost', () => {
	post()
	return false
})
$("#post").klik(() => {
	post()
})