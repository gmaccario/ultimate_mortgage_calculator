<?php
/*
Plugin Name: Ultimate Mortgage Calculator
Plugin URI: https://www.giuseppemaccario.com/mortgage-calculator/
Description: Ultimate Mortgage Calculator provides you a shortcode to add your calculator in your WP Posts or Pages.
Version: 1.5.1
Author: Giuseppe Maccario
Author URI: https://www.giuseppemaccario.com
License: GPL2
*/

define( 'ULTIMATE_MORTGAGE_CALCULATOR_ENV', 'prod' );

if( ULTIMATE_MORTGAGE_CALCULATOR_ENV == 'dev' )
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* GENERAL CONSTANTS */
define( 'ULTIMATE_MORTGAGE_CALCULATOR_NAME', 'Ultimate Mortgage Calculator' );

/* BASIC CONSTANTS - MANDATORY HERE CAUSE __FILE__ */
define( 'ULTIMATE_MORTGAGE_CALCULATOR_BASENAME', plugin_basename( __FILE__ ));
define( 'ULTIMATE_MORTGAGE_CALCULATOR_URL', plugins_url( '', __FILE__ ));
define( 'ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH', plugin_dir_path( __FILE__ ) );

function ultimate_mortgage_calculator_init()
{
	/* DEFINE CONSTANTS	*/
	require_once ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'constants.php';

	/* PSR-4: Autoloader - PHP-FIG */
	require ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

	/* DISPATCHER */
	require_once ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'include' . DIRECTORY_SEPARATOR . 'dispatcher.php';
}

if( defined( 'ABSPATH' )) {

    /*
     * GO!
     */
    ultimate_mortgage_calculator_init();
}
