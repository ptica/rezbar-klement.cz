<div id="mapa" style="width:706px; height:400px; margin:45px 45px;"></div>

<address>
	<h2>Milan Klement</h2>
	Křivsoudov 24,<br>
	pošta Čechtice<br>
	10 min od exitu 66 dálnice D1
	<a href="mailto:milan@rezbar-klement.cz">milan@rezbar-klement.cz</a>
	<a href="tel:+420317853413">317 853 413</a>
</address>

<?php
	$this->Html->script('http://api4.mapy.cz/loader.js', array('inline'=>false));
	$this->Html->scriptBlock('Loader.load()', array('inline'=>false));
	$this->Html->scriptStart(array('inline'=>false));
?>
	$(function() {
		var stred = SMap.Coords.fromWGS84(15.0863031, 49.633289);
		var mapa = new SMap(JAK.gel("mapa"), stred, 14);
		//mapa.addDefaultLayer(SMap.DEF_BASE).enable();
		//mapa.addDefaultLayer(SMap.DEF_HISTORIC).enable();
		mapa.addDefaultLayer(SMap.DEF_OPHOTO).enable();
		mapa.addDefaultControls();
		
		var layer = new SMap.Layer.Marker();
		mapa.addLayer(layer);
		layer.enable();
		
		var options = {};
		var marker = new SMap.Marker(stred, "řezbář Milan Klement", options);
		layer.addMarker(marker);
	});
<?php
	$this->Html->scriptEnd();
?>