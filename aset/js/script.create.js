let editor
ClassicEditor.create($("#content")).then(myEditor => {
	// console.log(editor)
	editor = myEditor
}).catch(error => {
	// console.log(error)
})

function post() {
	let title = $("#title").isi()
	let content = editor.getData()
	alert(content)
	let cover = $("#cover").isi()
	let category = encodeURIComponent($("#category").isi())
	let premium = $("#premium").isi()
	let send = "title="+title+"&content="+content+"&cover="+cover+"&category="+category+"&premium="+premium
	pos("./posts/create", send, () => {
		mengarahkan("./post")
	})
}
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