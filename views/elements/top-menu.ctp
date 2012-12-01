<?php

	$uri = $this->params['url']['url'];
	$uri = preg_replace('#^/#', '', $uri);

	$menu = '/ odkazy ohlasy nástroje galerie kontakt';
	$menu = explode(' ', $menu);
?>

<header id="header" class="noprint">
	<nav class="menu">
		<ul>
			<?php 
				foreach ($menu as $item) {
					$title = $item;
					$url   = $this->CommonText->to_ascii($item);
					if ($item == '/' && $uri == '') {
						$title = 'home';
						$link = $this->Html->link($title, '/'.$url, array('class'=>'current'));
						echo $this->Html->tag('li', $link);
					}
					else if ($item == '/') {
						$title = 'home';
						$link = $this->Html->link('Řezbář Klement', '/'.$url, array('class'=>'logo-small'));
						echo $this->Html->tag('li', $link, array('class'=>'logo-small'));
					}
					else if ($uri == $url) {
						$link = $this->Html->link($title, '/'.$url, array('class'=>'current'));
						echo $this->Html->tag('li', $link);
					}
					else {
						$link = $this->Html->link($title, '/'.$url);
						echo $this->Html->tag('li', $link);
					}
				}
			?>
		</ul>
	</nav>
</header>