<head>
	<link rel="stylesheet/less" type="text/css" href="less/kiosk.less">
	<script src="less/less.js" type="text/javascript"></script>
	<script src="util.js"></script>
	<link rel="stylesheet" href="style.css" media="screen" />
	<script>
	function flip() {
		card = document.getElementById('kiosk');
		console.log(card);
		card.toggleClassName('flipped');
	}
	</script>
</head>

<body>
<section class="kiosk" id="kiosk" onclick="flip()">
	<figure class="o-back"></figure>
	<figure class="o-left"></figure>
	<figure class="o-right"></figure>
	<figure class="o-top"></figure>
	<figure class="o-bottom"></figure>
	
	<figure class="i-back"></figure>
	<figure class="i-left"></figure>
	<figure class="i-right"></figure>
	<figure class="i-top"></figure>
	<figure class="i-bottom"></figure>
	<figure class="f-left"></figure>
	<figure class="f-right"></figure>
	<figure class="f-top"></figure>
	<figure class="f-bottom"></figure>
	<div class="shelf top">
		<figure class="front"></figure>
		<figure class="top"></figure>
		<figure class="bottom"></figure>
	</div>
	<div class="shelf center">
		<figure class="front"></figure>
		<figure class="top"></figure>
		<figure class="bottom"></figure>
	</div>
	<div class="shelf bottom">
		<figure class="front"></figure>
		<figure class="top"></figure>
		<figure class="bottom"></figure>
	</div>
</section>
</body>