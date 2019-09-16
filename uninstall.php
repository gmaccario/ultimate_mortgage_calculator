<?php
/* die when the file is called directly */
if ( !defined( 'WP_UNINSTALL_PLUGIN' )) 
{
    die;
}

include('devon_wpf.php');

delete_option( DEVON_WPF_OPT_DEBUG );