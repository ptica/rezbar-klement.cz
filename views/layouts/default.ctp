<?php
	// version string 
	$ver = (Configure::read('site.mode') == 'live' ? '1' : time());
?>
<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6 ie" lang="cs"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 ie" lang="cs"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 ie" lang="cs"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="cs"> <!--<![endif]-->
<head>
	<?php echo $this->Html->charset() . "\n"; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php echo $title_for_layout; ?></title>
	<meta name="description" content="Řezbář ">
	<meta name="author" content="Jan Ptáček jan.ptacek@gmail.com">
	<meta http-equiv="Content-language" content="cs">
	<meta name="keywords" content="řezba Klement">
	<meta name="robots" content="all, follow">
	
	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->	
	<?php echo $this->Html->meta('icon') ?>
	
	<?php 
		if (Configure::read('site.mode') == 'live') {
			echo $this->Html->css(
				array(
					"lib/bootstrap.css?$ver",
					'live.css'
				)
			);
			echo $this->Html->script(
				array(
					'libs/modernizr-1.7.min.js',
				),
				array('once'=>true)
			);
		} else {
			// devel
			echo $this->Html->less(array("lib/bootstrap.less?$ver"));
			echo $this->Html->script(
				array(
					'libs/modernizr-1.7.min.js',
					'libs/less-1.1.3.min.js',
					'libs/less-no-cache.js',
				),
				array('once'=>true)
			);
		}
	?>
	<?php echo $html->css('print.css', 'stylesheet', array('media'=>'print'))."\n" ?>
	<!--link href='http://fonts.googleapis.com/css?family=Miss+Fajardose|Great+Vibes|Ruthie&subset=latin,latin-ext' rel='stylesheet' type='text/css'-->
	
	<!--[if IE 5]>
		<style type="text/css" media="screen, projection">
		.expanding {width:expression(document.body.clientWidth < 1204 ? "1204px" : "auto" )}
		#wrapper {height:0}
		</style>
	<![endif]-->
	<!--[if IE 6]>
		<style type="text/css" media="screen, projection">
		.expanding {width:expression(documentElement.clientWidth < 1204 ? "1204px" : "auto" )}
		</style>
	<![endif]-->
</head>

<?php
	echo $this->Html->tag('body', null, array(
		'data-controller'	=> $this->params['controller'],
		'data-action'		=> $this->params['action'],
		'data-arg'			=> @$this->params['pass'][0],
		'data-branch-id'	=> @$branch_id . '-' . @$lang
	))
?>

<?php
	// DOWN FOR MAINTENANCE
	if (Configure::read('site.mode') == 'down') {
		echo $this->Html->div('pat-carbon', '', array('style'=>'position:absolute; z-index:200; top:0; left:0; right:0; bottom:0; height:1308px'));
		echo $this->Html->div('', 'Právě probíhá údržba. Dejte nám prosím 5 minut.', array('style'=>'font-size:24pt; position:absolute; z-index:100; top:61px; left:200px; width:650px; background-color:gray;padding:1.5em 1.5em'));
	}
?>
<div class="container">
	<?php echo $this->Session->flash() ?>
	
	<header id="header" class="noprint">
		<nav class="menu">
			<ul>
				<li><a href="/">HOME</a></li>
				<li class=""><a href="odkazy">ODKAZY</a></li>
				<li class=""><a href="ohlasy">OHLASY</a></li>
				<li class=""><a href="nastroje">NÁSTROJE</a></li>
				<li class=""><a href="galerie">GALERIE</a></li>
				<li class=""><a href="kontakt">KONTAKT</a></li>
			</ul>
		</nav>
		<!--form id="header-search" action="/search" method="get">
				<span>Hledat:</span>
				<input type="text" name="q" />
		</form-->
	</header>
	
	<h1 id="klement" href="<?php echo Router::url('/')?>">Řezbář Klement</h1>
	
	<footer class="intro">
		<!--img src="/css/img/gregor-dum.jpg" width="745px" height="130%" style="overflow:hidden"-->
	</footer>
	
	<div style="margin-left:32px; float: left; width:350px; margin-bottom:52px;">
	Hola hola hola hej
	</div>
	<div style="margin-left:32px; float: left; width:350px">
	Hola hola hola hej
	</div>
	
	<?php echo $this->Html->image('../css/img/andelicci.png', array('class'=>'andelicci')) ?>
	
	
	
	<div class="content">
		<?php echo $content_for_layout."\n" ?>
	</div>
	
	<footer class="subfooter noprint">
		<span class="divider-h"></span>
		<nav>
			<ul>
				<li><a class="current" href="/">Vítejte</a></li>
				<li><a href="novinky">Novinky</a></li>
				<li><a href="kurzy">Kurzy</a></li>
				<li><a href="galerie">Galerie</a></li>
				<li><a href="historie">Historie</a></li>
				<li><a href="odkazy">Odkazy</a></li>
				<li><a href="ohlasy">Ohlasy</a></li>
				<li><a href="kontakt">Kontakt</a></li>
				<li class="right to-top"><a href="#top"></a></li>
			</ul>
		</nav>
		
		<div class="copyright">&copy; 2012 řezbář Milan Klement</div>
	</footer>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
<!--script src='<?php echo Router::url('/js/libs/jquery-1.5.1.min.js') ?>'></script-->

<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
<![endif]-->

<?php
	echo $this->Html->script(
		array(
			"rezbar-klement.js?$ver",
		),
		array('once'=>true)
	);
	echo $scripts_for_layout;
	//echo $this->element('sql_dump');
?>
<?php if (Configure::read('GA.account')): ?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo Configure::read('GA.account');?>']);
		_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
<?php endif; ?>

</body>
</html>