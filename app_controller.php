<?php

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $components = array('Session');
	var $helpers    = array('Session', 'Html', 'Form', 'CommonText');
}