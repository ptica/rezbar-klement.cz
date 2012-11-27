<?php

	$uri = $this->params['url']['url'];

	$menu = 'home odkazy ohlasy nástroje galerie kontakt';
	$menu = explode(' ', $menu);
?>

<header id="header" class="noprint">
	<nav class="menu">
		<ul>
			<?php 
				foreach ($menu as $item) {
					$title = mb_strtoupper($item);
					$url   = '/' . $item;
					if ($title == 'home') $url = '/';
					$link = $this->Html->link($title, $url);
					if ($uri == $item) {
						echo $this->Html->tag('li', $link, array('class'=>'current'));
					} else {
						echo $this->Html->tag('li', $link);
					}
				}
			?>
		</ul>
	</nav>
</header>