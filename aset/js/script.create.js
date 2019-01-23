function base64encode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
	        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}
function base64decode(str) {
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
	    }).join(''));
}
function refresh(str) {
	let p = str.split(',')
	let tot = p.length
	let y = p.splice(0, tot - 1)
	return y
}
function getTyped(str) {
	let p = str.split(',')
	let tot = p.length
	return p[tot - 1]
}
function cekHashtag(tags) {
	let tag = tags
	if(tags.split(',').length > 0) {
		tag = getTyped(tags)
	}
	tag = encodeURIComponent(tag)
	if(tag == "") {
		$("#suggestion").hilang()
		return false
	}
	pos('./posts/cekHashtag', 'tag='+tag+'&type=0', (res) => {
		$("#suggestion").muncul()
		$("#suggestion").tulis(res)
	})
}
function cekCat(cats) {
	let cat = cats
	if(cats.split(',').length > 0) {
		cat = getTyped(cats)
	}
	cat = encodeURIComponent(cat)
	if(cat == "") {
		$("#suggestCat").hilang()
		return false
	}
	pos('./posts/cekHashtag', 'tag='+cat+'&type=1', (res) => {
		$("#suggestCat").muncul()
		$("#suggestCat").tulis(res)
	})
}
function createHashtag(tags) {
	let tag = getTyped(tags)
	tag = encodeURIComponent(tag)
	pos('./posts/createHashtag', 'tag='+tag, (res) => {
		tag = decodeURIComponent(tag)
		chooseTag(tag)
	})
}
function createCat(cats) {
	// let cat = getTyped(cats)
	// cat = encodeURIComponent(cat)
	// pos('./posts/createHashtag', 'tag='+cat+'&type=1', (res) => {
	// 	cat = decodeURIComponent(cat)
	// 	chooseCat(cat)
	// })
}
function chooseTag(tag) {
	let newIsi
	let isi = $("#hashtag").isi()
	if(isi.split(',').length > 1) {
		newIsi = refresh(isi) + "," + tag + ","
	}else {
			newIsi = tag+','
	}
	$("#hashtag").isi(newIsi)
	$("#hashtag").focus()
	$("#suggestion").hilang()
}
function chooseCat(cat) {
	let newIsi
	let isi = $("#category").isi()
	if(isi.split(',').length > 1) {
		newIsi = refresh(isi) + "," + cat + ","
	}else {
		newIsi = cat+","
	}
	$("#category").isi(newIsi)
	$("#category").focus()
	$("#suggestCat").hilang()
}
function delCat(cat) {
	cat = encodeURIComponent(cat)
	pos('./posts/deleteHashtag', 'tag='+cat+'&type=1', (res) => {
		cekCat($("#category").isi())
	})
}
function delTag(tag) {
	tag = encodeURIComponent(tag)
	pos('./posts/deleteHashtag', 'tag='+tag+'&type=0', (res) => {
		cekHashtag($("#hashtag").isi())
	})
}
window.addEventListener('scroll', (scr) => {
	let scroll = this.scrollY
	if(scroll > 80) {
		// $('#kanan').pengaya('position: fixed;top: 30px;')
	}else {
		// $('#kanan').pengaya('position: absolute;top: 33px;')
	}
})
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

// function checkCat() {
// 	let checkedValue = []
// 	let checked = document.getElementsByName('category[]')
// 	for(var i = 0; i < checked.length; i++) {
// 		if(checked[i].checked) {
// 			checkedValue.push(checked[i].value)
// 		}
// 	}
// 	$("#category").isi(checkedValue.toString())
// }

submit('#formPost', () => {
	post()
	return false
})
$("#post").klik(() => {
	post()
	return false
})