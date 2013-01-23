<?php 
	$this->set('title_for_layout', 'Galerie');
?>

<div id="picasa">
<link rel="stylesheet" type="text/css" href="/js/galerie/highslide.css" />
<link rel="stylesheet" type="text/css" href="/js/galerie/gallery.css" />   <script type="text/javascript" src="/js/galerie/highslide-with-gallery.js"></script>
<script type="text/javascript">
   var sViewThis  = ["", "", ""];	
   var sGalHome   = "&nbsp;";
   var sPhotos    = [" ",""];
   var sOf        = " z ";
   var username   = "rezbar.klement@gmail.com";
   var photosize  = 800;
   var columns    = 5;
	 hs.align       = "center";
	 hs.transitions = ["expand","crossfade"];
	 hs.outlineType = "rounded-white";
	 hs.fadeInOut   = true;
	 hs.dimmingOpacity = 0.75;
	 hs.graphicsDir = "/js/galerie/highslide/graphics/";
	 hs.showCredits = false;
	 
	 hs.addSlideshow({interval:5000, repeat:false, useControls:false, fixedControls:'fit', overlayOptions: {opacity:.75, position:'bottom center', hideOnMouseOut:true}});
	</script>
	<script type="text/javascript" src="/js/galerie/pwa.js"></script>
</div>
