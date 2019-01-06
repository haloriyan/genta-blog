<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1">
	<title>Lazyload</title>
</head>
<body>

<div id="lazy" style="margin-top: 10px"></div>

<script src="http://localhost/genta/aset/js/embo.js"></script>
<script>
	let app = new lazyLoad({
		el: '#lazy',
		url: 'http://localhost/genta/users/mamama'
	})
</script>

</body>
</html>