var Upload = function(file, url = 0) {
	this.file = file
	this.url = url // url to upload
	if(this.url == 0) {
		this.url = "./aksi/unggah.php"
	}
}

Upload.prototype.getType = function() {
	return this.file.type
}
Upload.prototype.getSize = function() {
	return this.file.size
}
Upload.prototype.getName = function() {
	return this.file.name
}
Upload.prototype.supportFile = function() {
	var fi = document.createElement('INPUT')
	fi.type = 'file'
	return 'files' in fi
}
Upload.prototype.doUpload = function(form) {
	let formData = new FormData()
	// errore nang append
	formData.append("file", this.file, this.file.name)
	formData.append("upload_file", true)
	pos(this.url, formData, () => {
		sukses()
	}, 'isFile')
}