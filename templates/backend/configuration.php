<div class="devon_wpf wrap">

	<div class="intro">
		<h1><?php _e( DEVON_WPF_NAME, DEVON_WPF_L10N); ?></h1>
		
		<hr />
		
		<hr class="wp-header-end">
	</div>
	
	<!-- wordpress provides the styling for tabs. -->
	<h2 class="nav-tab-wrapper">
		<?php echo $tabs; ?>
	</h2>
	
	<?php if( 'update' == $action ): ?>
		<div id="message" class="updated">
			<p><?php _e( "Settings saved", DEVON_WPF_L10N ); ?></p>
		</div>
	<?php endif; ?>
	
	<form name="form" class="form" method="post" action=""> <?php /* WARNING: using options.php in action attribute causes a problem with passing values parameters */ ?>
		
		<?php settings_fields( DEVON_WPF_OPT_SETTINGS_FIELDS ); ?>
		
		<?php 
			switch( $active_tab )
			{
			    case 'configuration':
			        do_settings_sections( 'configuration' );
			        
			        submit_button();
			        
			        break;
			    case 'documentation':
			        do_settings_sections( 'documentation' );
			        
			        break;
			    /**
			     *  @todo add here more cases
			     *  
			     *  */

				default:
				    do_settings_sections( 'welcome' );
				    
				    break;
			}
		?>
	</form>
</div>

<hr />

<p>
	<span class="dashicons dashicons-wordpress"> </span>
	<span><?php _e( "Author", 'devon_wpf' ); ?>:</span>
	<a href="https://www.giuseppemaccario.com/" target="_blank">Giuseppe Maccario</a>
</p>