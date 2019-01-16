/*
	* Riload Plugin
	* (c) 2019 - Created by Riyan satria
*/

class Riload {
	constructor(obj) {
		this.el = obj.el,
		this.data = obj.data,
		this.toLoad = 0,
		this.allowLoad = 1,
		this.documentHeight,
		this.url = obj.url,
		this.totalScroll,
		this.dom = obj.dom
		if(!this.dom) {
			this.dom = "div"
		}

		this.getDocHeight()
		this.init()

		this.totalScroll = parseInt(this.documentHeight) + parseInt(window.pageYOffset)
		if(this.totalScroll < this.documentHeight) {
			this.loadMore()
		}

		window.addEventListener('scroll', (scr) => {
			let scroll = window.pageYOffset
			if(scroll + 650 >= this.documentHeight) {
				this.loadMore()
				obj.sukses()
			}
		})
	}
	init() {
		let div = document.createElement(this.dom)
		div.setAttribute('id', 'toLoad0')
		pos(this.url, this.data+"&position="+this.toLoad, (res) => {
			div.innerHTML = res
		})
		// ambil(this.url, (res) => {
		// 	div.innerHTML = res
		// })
		$(this.el).appendChild(div)
	}
	getDocHeight() {
		var body = document.body,
		html = document.documentElement

		this.documentHeight = Math.max( body.scrollHeight, body.offsetHeight, 
		                       html.clientHeight, html.scrollHeight, html.offsetHeight )
	}
	loadMore() {
		this.toLoad = parseInt(this.toLoad) + 1
		if(this.allowLoad !== 1) {
			return false
		}
		this.generateElement()
		pos(this.url, this.data+"&position="+this.toLoad, (res) => {
			$('#toLoad'+this.toLoad).tulis(res)
		})
		// ambil(this.url, (res) => {
		// 	$('#toLoad'+this.toLoad).tulis(res)
		// })
		this.getDocHeight()
	}
	generateElement() {
		let div = document.createElement(this.dom)
		div.setAttribute('id', 'toLoad'+this.toLoad)
		$(this.el).appendChild(div)
	}
}