<div class="ultimate_mortgage_calculator wrap">

	<div class="intro">
		<h1><?php _e( ULTIMATE_MORTGAGE_CALCULATOR_NAME, ULTIMATE_MORTGAGE_CALCULATOR_L10N); ?></h1>
		
		<hr />
		
		<hr class="wp-header-end">
	</div>
	
	<!-- wordpress provides the styling for tabs. -->
	<h2 class="nav-tab-wrapper">
		<?php echo $tabs; ?>
	</h2>
	
	<?php if( 'update' == $action ): ?>
		<div id="message" class="updated">
			<p><?php _e( "Settings saved", ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></p>
		</div>
	<?php endif; ?>
	
	<form name="form" class="form" method="post" action=""> <?php /* WARNING: using options.php in action attribute causes a problem with passing values parameters */ ?>
		
		<?php settings_fields( ULTIMATE_MORTGAGE_CALCULATOR_OPT_SETTINGS_FIELDS ); ?>
		
		<?php 
			switch( $active_tab )
			{
			    case 'configuration':
			        do_settings_sections( 'configuration' );
			        
			        submit_button();
			        
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
	<span><?php _e( "Author", 'ultimate_mortgage_calculator' ); ?>:</span>
	<a href="https://www.giuseppemaccario.com/" target="_blank">Giuseppe Maccario</a>
</p>