var Upload = function(file) {
	this.file = file
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
	pos("./aksi/unggah.php", formData, () => {
		sukses()
	}, 'isFile')
}