class Ricomplete {
	constructor(props) {
		this.el = props.el
		this.url = props.url

		this.data

		$('.ricomplete input').di('ketik', function() {
			trigger()
		})
		// this.getter()
	}
	createWrapper(val) {
		let div = document.createElement('div')
		div.innerHTML = val
		$(".ricomplete").appendChild(div)
	}
	getter() {
		pos(this.url, this.data, (res) => {
			this.createWrapper(res)
		})
	}
}