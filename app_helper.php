<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import('Core', 'Helper');
App::import('Helper', 'Helper', false);

/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper {
/**
 * Creates a link element for LESS stylesheets.
 *
 * ### Options
 *
 * - `inline` If set to false, the generated tag appears in the head tag of the layout. Defaults to true
 *
 * @param mixed $path The name of a CSS style sheet or an array containing names of
 *   CSS stylesheets. If `$path` is prefixed with '/', the path will be relative to the webroot
 *   of your application. Otherwise, the path will be relative to your CSS path, usually webroot/css.
 * @param string $rel Rel attribute. Defaults to "stylesheet". If equal to 'import' the stylesheet will be imported.
 * @param array $options Array of HTML attributes.
 * @return string CSS <link /> or <style /> tag, depending on the type of link.
 * @access public
 * @link http://book.cakephp.org/view/1437/css
 */
	function less($path, $rel = 'stylesheet/less', $options = array()) {
		$options += array('inline' => true);
		if (is_array($path)) {
			$out = '';
			foreach ($path as $i) {
				$out .= "\n\t" . $this->less($i, $rel, $options);
			}
			if ($options['inline'])  {
				return $out . "\n";
			}
			return;
		}

		if (strpos($path, '://') !== false) {
			$url = $path;
		} else {
			if ($path[0] !== '/') {
				$path = CSS_URL . $path;
			}

			if (strpos($path, '?') === false) {
				if (substr($path, -5) !== '.less') {
					$path .= '.less';
				}
			}
			$url = $this->assetTimestamp($this->webroot($path));

			if (Configure::read('Asset.filter.css')) {
				$pos = strpos($url, CSS_URL);
				if ($pos !== false) {
					$url = substr($url, 0, $pos) . 'ccss/' . substr($url, $pos + strlen(CSS_URL));
				}
			}
		}

		if ($rel == 'import') {
			$out = sprintf($this->tags['style'], $this->_parseAttributes($options, array('inline'), '', ' '), '@import url(' . $url . ');');
		} else {
			if ($rel == null) {
				$rel = 'stylesheet';
			}
			$out = sprintf($this->tags['css'], $rel, $url, $this->_parseAttributes($options, array('inline'), '', ' '));
		}

		if ($options['inline']) {
			return $out;
		} else {
			$view =& ClassRegistry::getObject('view');
			$view->addScript($out);
		}
	}
}
