<?php
/* die when the file is called directly */
if ( !defined( 'WP_UNINSTALL_PLUGIN' )) 
{
    die;
}

include('ultimate_mortgage_calculator.php');
include('include/constants.php');

delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_SETTINGS_FIELDS );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR );
delete_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE );