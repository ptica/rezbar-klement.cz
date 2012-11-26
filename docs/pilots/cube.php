<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  
  <!-- disable zooming -->
  <meta name="viewport" content="initial-scale=1.0, user-scalable=0" />
  
  <title>Perspective 3 &middot; Intro to CSS 3D transforms &rsaquo; Examples</title>
  
  <link rel="stylesheet" href="../css/style.css" media="screen" />


    <style media="screen">
	figure { margin:0; }
    .container {
      width: 200px;
      height: 200px;
      position: relative;
      margin: 0 auto 40px;
      border: 1px solid #CCC;
      -webkit-perspective: 1200px;
         -moz-perspective: 1200px;
           -o-perspective: 1200px;
              perspective: 1200px;
    }

    #cube {
      width: 100%;
      height: 100%;
      position: absolute;
      -webkit-transform-style: preserve-3d;
         -moz-transform-style: preserve-3d;
           -o-transform-style: preserve-3d;
              transform-style: preserve-3d;
      -webkit-transform: translateZ( -100px );
         -moz-transform: translateZ( -100px );
           -o-transform: translateZ( -100px );
              transform: translateZ( -100px );
    }

    #cube.spinning {
      -webkit-animation: spinCubeWebkit 8s infinite ease-in-out;
         -moz-animation: spinCubeMoz    8s infinite ease-in-out;
           -o-animation: spinCubeO      8s infinite ease-in-out;
              animation: spinCube       8s infinite ease-in-out;
    }

    @-webkit-keyframes spinCubeWebkit {
        0% { -webkit-transform: translateZ( -100px ) rotateX(   0deg ) rotateY(   0deg ); }
      100% { -webkit-transform: translateZ( -100px ) rotateX( 360deg ) rotateY( 360deg ); }
    }

    @-moz-keyframes spinCubeMoz {
        0% { -moz-transform: translateZ( -100px ) rotateX(   0deg ) rotateY(   0deg ); }
      100% { -moz-transform: translateZ( -100px ) rotateX( 360deg ) rotateY( 360deg ); }
    }

    #cube figure {
      display: block;
      position: absolute;
      width: 200px;
      height: 200px;
      border: 0px solid black;
      line-height: 200px;
      font-size: 120px;
      font-weight: bold;
      color: white;
      text-align: center;
      background: url(wood-saturated-by-yc.jpg) no-repeat;
    }

    #cube.panels-backface-invisible figure {
      -webkit-backface-visibility: hidden;
         -moz-backface-visibility: hidden;
           -o-backface-visibility: hidden;
              backface-visibility: hidden;
    }

    #cube .front  { background: hsla(   0, 100%, 50%, 0.1 ); }
    #cube .back   { Xbackground: hsla(  60, 100%, 50%, 0.7 ); }
    #cube .right  { Xbackground: hsla( 120, 100%, 50%, 0.7 ); }
    #cube .left   { Xbackground: hsla( 180, 100%, 50%, 0.7 ); }
    #cube .top    { Xbackground: hsla( 240, 100%, 50%, 0.7 ); }
    #cube .bottom { Xbackground: hsla( 300, 100%, 50%, 0.7 ); }

    #cube .front  {
      -webkit-transform: translateZ( 100px );
         -moz-transform: translateZ( 100px );
           -o-transform: translateZ( 100px );
              transform: translateZ( 100px );
    }
    #cube .back {
      -webkit-transform: rotateX( -180deg ) translateZ( 100px );
         -moz-transform: rotateX( -180deg ) translateZ( 100px );
           -o-transform: rotateX( -180deg ) translateZ( 100px );
              transform: rotateX( -180deg ) translateZ( 100px );
    }
    #cube .right {
      -webkit-transform: rotateY(   90deg ) translateZ( 100px );
         -moz-transform: rotateY(   90deg ) translateZ( 100px );
           -o-transform: rotateY(   90deg ) translateZ( 100px );
              transform: rotateY(   90deg ) translateZ( 100px );
    }
    #cube .left {
      -webkit-transform: rotateY(  -90deg ) translateZ( 100px );
         -moz-transform: rotateY(  -90deg ) translateZ( 100px );
           -o-transform: rotateY(  -90deg ) translateZ( 100px );
              transform: rotateY(  -90deg ) translateZ( 100px );
    }
    #cube .top {
      -webkit-transform: rotateX(   90deg ) translateZ( 100px );
         -moz-transform: rotateX(   90deg ) translateZ( 100px );
           -o-transform: rotateX(   90deg ) translateZ( 100px );
              transform: rotateX(   90deg ) translateZ( 100px );
    }
    #cube .bottom {
      -webkit-transform: rotateX(  -90deg ) translateZ( 100px );
         -moz-transform: rotateX(  -90deg ) translateZ( 100px );
           -o-transform: rotateX(  -90deg ) translateZ( 100px );
              transform: rotateX(  -90deg ) translateZ( 100px );
    }

  </style>

</head>
<body>

  <h1>Perspective 3</h1>

  <section class="container">
    <div id="cube" class="spinning">
      <figure class="front"></figure>
      <figure class="back">2</figure>
      <figure class="right">3</figure>
      <figure class="left">4</figure>
      <figure class="top">5</figure>
      <figure class="bottom">6</figure>
    </div>
  </section>


  <section id="options">

    <p class="perspective">
      <label>perspective</label>
      <input type="range" min="1" max="2000" value="1200" data-units="px" />
    </p>

    <p class="perspective-origin-x">
      <label>perspective-origin x</label>
      <input type="range" min="0" max="100" value="50" data-units="%" />
    </p>

    <p class="perspective-origin-y">
      <label>perspective-origin y</label>
      <input type="range" min="0" max="100" value="50" data-units="%" />
    </p>

    <p class="spinning">
      <button>Toggle Spinning</button>
    </p>

    <p class="backface-visibility">
      <button>Toggle Backface Visibility</button>
    </p>

  </section>

  <script src="../js/utils.js"></script>
  <script>
    var init = function() {
      var boxContainer = document.querySelector('.container'),
          cube = document.getElementById('cube'),
          optionsContainer = document.getElementById('options'),
          perspectiveOrigin = { x: 50, y: 50 },
          // get -vendor- prefix css property
          perspectiveProp = Modernizr.prefixed('perspective'),
          perspectiveOriginProp = Modernizr.prefixed('perspectiveOrigin'),

          updatePerspectiveOrigin = function() {
            boxContainer.style[ perspectiveOriginProp ] =
              perspectiveOrigin.x + '% ' + perspectiveOrigin.y + '%';
          };

      optionsContainer.querySelector('.perspective input').addEventListener( 'change', function( event ){
        boxContainer.style[ perspectiveProp ] = event.target.value + 'px';
      }, false);

      optionsContainer.querySelector('.perspective-origin-x input').addEventListener( 'change', function( event ){
        perspectiveOrigin.x = event.target.value;
        updatePerspectiveOrigin();
      }, false);

      optionsContainer.querySelector('.perspective-origin-y input').addEventListener( 'change', function( event ){
        perspectiveOrigin.y = event.target.value;
        updatePerspectiveOrigin();
      }, false);

      optionsContainer.querySelector('.spinning button').addEventListener( 'click', function(){
        cube.toggleClassName('spinning');
      }, false);

      optionsContainer.querySelector('.backface-visibility button').addEventListener( 'click', function(){
        cube.toggleClassName('panels-backface-invisible');
      }, false);

    };

    window.addEventListener( 'DOMContentLoaded', init, false);
  </script>

  
  <footer>
    <p id="disclaimer">Sorry, your browser does not support CSS 3D transforms. Try viewing this page in <a href="http://www.apple.com/safari/">Safari</a>, <a href="http://www.google.com/chrome">Chrome</a>, <a href="http://www.mozilla.org/en-US/firefox/channel/">Firefox Aurora</a>, or on an iOS device.</p>
    <p>Example for <a href="../">Intro to CSS 3D transforms</a> by David DeSandro</p>
  </footer>

</body>
</html>
