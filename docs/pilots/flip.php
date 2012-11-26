<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  
  <!-- disable zooming -->
  <meta name="viewport" content="initial-scale=1.0, user-scalable=0" />
  
  <title>Perspective 3 &middot; Intro to CSS 3D transforms &rsaquo; Examples</title>
  
	<style media="screen">
		.container { 
			  width: 200px;
			  height: 260px;
			  position: relative;
			  perspective: 800px;
			  -webkit-perspective: 800px;
			  border: 1px solid gray;
			}
		#card {
			  width: 100%;
			  height: 100%;
			  position: absolute;
			  -webkit-transform-style: preserve-3d;
			  -webkit-transform-origin: right center;
			  -webkit-transition: -webkit-transform 1s;
			  border: 0px solid gray;
			}
		#card figure {
			  display: block;
			  position: absolute;
			  width: 100%;
			  height: 100%;
			  line-height: 260px;
			  text-align: center;
			  color: white;
			  font-weight: bold;
			  font-size: 140px;
			  -webkit-backface-visibility: hidden;
			  margin: 0;
			}
		#card .front {
		  background: red;
		}
		#card .back {
		  background: blue;
		  -webkit-transform: rotateY(180deg);
		}
		#card.flipped {
  			-webkit-transform: translateX(-100%) rotateY(-180deg);
		}
	
	</style>
	<script src="util.js"></script>
	<script type="text/javascript">
		function flip() {
			card = document.getElementById('card');
			card.toggleClassName('flipped');
		}
	</script>
</head>
<body>
<section class="container">
  <div id="card">
    <figure class="front" onclick="flip()">1</figure>
    <figure class="back"  onclick="flip()">2</figure>
  </div>
</section>
</body>
