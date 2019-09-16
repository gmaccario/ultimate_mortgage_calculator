<?php
/*
Plugin Name: Devon W.P.F.
Plugin URI: https://github.com/gmaccario/devon-wpf
Description: Devon W.P.F. (Wordpress Plugin Framework) is intended as a starter kit for Developers to create their own plugins.
Version: 1.0
Author: Giuseppe Maccario
Author URI: https://www.giuseppemaccario.com
License: GPL2
*/

define( 'DEVON_WPF_ENV', 'dev' );

if( DEVON_WPF_ENV == 'dev' )
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* GENERAL CONSTANTS */
define( 'DEVON_WPF_NAME', 'Devon W.P.F.' );

/* BASIC CONSTANTS - MANDATORY HERE CAUSE __FILE__ */
define( 'DEVON_WPF_BASENAME', plugin_basename( __FILE__ ));
define( 'DEVON_WPF_URL', plugins_url( '', __FILE__ ));
define( 'DEVON_WPF_DIR_PATH', plugin_dir_path( __FILE__ ) );

function devon_wpf_init()
{
	/* DEFINE CONSTANTS	*/
	require_once DEVON_WPF_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'constants.php';
	
	/* PSR-4: Autoloader - PHP-FIG */
	require DEVON_WPF_DIR_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
	
	/* DISPATCHER */
	require_once DEVON_WPF_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'dispatcher.php';
}

if( defined( 'ABSPATH' )) {
    
    /*
     * GO!
     */
    devon_wpf_init();
}