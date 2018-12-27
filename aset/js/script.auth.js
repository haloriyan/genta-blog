submit('#formLogin', () => {
	let email = $("#email").isi()
	let pwd = $("#pwd").isi()
	let login = "email="+email+"&pwd="+pwd
	pos("./users/login", login, () => {
		mengarahkan('./dashboard')
	})
	return false
})

tekan('Escape', () => {
	hilangPopup('#notif')
})
$("#xNotif").klik(() => {
	hilangPopup('#notif')
})