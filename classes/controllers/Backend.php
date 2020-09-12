<?php

namespace UMC\Controller\Classes;

use UMC\General\Classes\Common;

if(!interface_exists('UMC\Controllers\Classes\iBackend'))
{
    interface iBackend
    {
        public function configuration();
        public function displayTabWelcome();
        public function displayTabConfiguration();
    }
}

if(!class_exists('\UMC\Controllers\Classes\Backend'))
{
    /**
     * @name Backend
     * @description Generic class for the Frontend Backend
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
    class Backend extends Controller implements iBackend
	{		
	    /**
		 * @name __construct
		 *
		 * @param Common $common
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
	    public function __construct(Common $common)
	    {
	        parent::__construct($common);
	    }
		
	    /**
	     * @name getHTMLTabs
	     *
	     * @author G.Maccario <g_maccario@hotmail.com>
	     * @return string
	     */
	    protected function getHTMLTabs() : string
	    {
	        $links = '';
	        
	        if( $this->params['pages'] )
	        {
	            foreach( $this->params['pages'] as $page )
	            {
	                if( $page[ 'slug' ] == $this->params['active_page'] )
	                {
	                    $tabs = $page[ 'attributes' ][ 'tabs' ];
	                    foreach( $tabs as $tab )
	                    {
	                        if(empty($links)) 
	                        {
	                            $active = ( $this->params['active_tab'] == $tab[ 'slug' ] || !$this->params['active_tab'] ) ? 'nav-tab-active' : '';
	                        } else {
	                            $active = ( $this->params['active_tab'] == $tab[ 'slug' ] ) ? 'nav-tab-active' : '';
	                        }
	                        
	                        /**
	                         * @todo might be better!
	                         */
	                        $links .= '<a href="?page=' . $page[ "slug" ] . '&tab=' . $tab[ "slug" ] . '" class="nav-tab ' . $active . '">';
	                        $links .= '<span>' . __( $tab[ "name" ], ULTIMATE_MORTGAGE_CALCULATOR_L10N) . '</span>';
                    		$links .= '</a>';
	                    }
		            }
		        }
		    }
		    
		    return $links;
	    }
	    
		/**
		 * @name configuration
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function configuration()
		{
			/*
			 * GET VALUES FROM POST
			 * *********************************************
			 */
			$this->params['action'] = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );
			$this->params['active_page'] = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			$this->params['active_tab'] = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			
			$this->params['pages'] = $this->common->getConfig()[ 'features' ][ 'backend' ][ 'pages' ];
			$this->params['tabs'] = $this->getHTMLTabs();
			/*
			 * UPDATE OPTIONS
			 * *********************************************
			 */
			if ( $this->params['action'] != 'update')
			{
			    /*
			     * GET FRESH VALUES FROM DB
			     * *********************************************
			     */
			    $this->params['value_debug'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG );
			    
			    $this->params['currency'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY );
			    $this->params['country'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY );
			    $this->params['hex_color'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR );
			    $this->params['mortgage_start_value'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE );
			    $this->params['add_bootstrap'] = get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP );
			    
			} else {
				
				/*
				 * GET VALUES FROM POST
				 * *********************************************
				 */
				$this->params['value_debug'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG, FILTER_SANITIZE_NUMBER_INT );
				
				$this->params['currency'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY, FILTER_SANITIZE_STRING );
				$this->params['country'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY, FILTER_SANITIZE_STRING );
				$this->params['hex_color'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR, FILTER_SANITIZE_STRING );
				$this->params['mortgage_start_value'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE, FILTER_SANITIZE_NUMBER_INT );
				$this->params['add_bootstrap'] = filter_input( INPUT_POST, ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP, FILTER_SANITIZE_NUMBER_INT );
				
				/*
				 * UPDATE NEW VALUES
				 * *********************************************
				 */
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG, $this->params['value_debug'] );
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY, $this->params['currency'] );
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY, $this->params['country'] );
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR, $this->params['hex_color'] );
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE, $this->params['mortgage_start_value'] );
				update_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP, $this->params['add_bootstrap'] );
			}
			
			$this->params['available_shortcodes'] = $this->common->getConfig()['features']['frontend']['shortcodes'];
			
			/*
			 * Include Template
			 */
			$this->renderTemplate('configuration');
		}
		
		/**
		 * @name displayTabWelcome
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function displayTabWelcome()
		{
		    ?>
		    <h3><?php echo _e( "Ultimate Mortgage Calculator provides you a shortcode to add your calculator in your WP Posts or Pages.", ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h3>
        	
        	<?php if( count( $this->params['available_shortcodes'] ) > 0 ): ?>
            	<div class="shortcodes">
            		<table>
                		<thead>
                    		<tr>
                    			<th colspan="2">
                    				<h2 class=""><?php echo _e( "AVAILABLE SHORTCODES", ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h2>
                    			</th>
                            </tr>
                            <tr>
                                <th><?php echo _e( "Shortcode", ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></th>
                                <th><?php echo _e( "Frontend Method", ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($this->params['available_shortcodes'] as $available_shortcode): ?>
                        		<tr>
                        			<?php foreach($available_shortcode as $shortcode => $method): ?>
                                    	<td>[<?php echo $shortcode; ?>]</td>
                                    	<td><?php echo $method; ?></td>
                                    <?php endforeach; ?>
                                </tr>
            				<?php endforeach; ?>
                        </tbody>
                     </table>
            	</div>
        	<?php 
        	endif;
		}
		
		/**
		 * @name displayTabConfiguration
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function displayTabConfiguration()
		{
		    ?>
    		    <div class="input choose_currency">
        			<h4><?php echo __( 'Choose Currency', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h4>
        			<div class="element">
        				<?php /* https://html-css-js.com/html/character-codes/currency/ */ ?>
        				<select id="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY; ?>" name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_CURRENCY; ?>">
        					<option value="EUR" <?php echo ( "EUR" == $this->params['currency'] ) ? 'selected' : ''; ?>>Euro</option>
        					<option value="AUD" <?php echo ( "AUD" == $this->params['currency'] ) ? 'selected' : ''; ?>>Australia Dollar</option>
        					<option value="CAD" <?php echo ( "CAD" == $this->params['currency'] ) ? 'selected' : ''; ?>>Canada Dollar</option>
        					<option value="GBP" <?php echo ( "GBP" == $this->params['currency'] ) ? 'selected' : ''; ?>>United Kingdom Pound</option>
        					<option value="USD" <?php echo ( "USD" == $this->params['currency'] ) ? 'selected' : ''; ?>>United States Dollar</option>
        					<option value="CHF" <?php echo ( "CHF" == $this->params['currency'] ) ? 'selected' : ''; ?>>Switzerland Franc</option>
        					<option value="DKK" <?php echo ( "DKK" == $this->params['currency'] ) ? 'selected' : ''; ?>>Denmark Krone</option>
        					<option value="NOK" <?php echo ( "NOK" == $this->params['currency'] ) ? 'selected' : ''; ?>>Norway Krone</option>
        					<option value="SEK" <?php echo ( "SEK" == $this->params['currency'] ) ? 'selected' : ''; ?>>Sweden Krona</option>
        					<?php /* <option value="JMD" <?php ( "EUR" == $currency ) ? 'selected' : ''; ?>>Jamaica Dollar</option> */ ?>
        				</select>
        			</div>
        		</div>
        
        		<div class="input choose_language">
        			<h4><?php echo __( 'Choose Country', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h4>
        			<div class="element">
        				<select id="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY; ?>" name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_COUNTRY; ?>">
        					<optgroup label="Not Europe">
        						<option value="en-AU" <?php echo ( "en-AU" == $this->params['country'] ) ? 'selected' : ''; ?>>English (Australia)</option>
        						<option value="en-CA" <?php echo ( "en-CA" == $this->params['country'] ) ? 'selected' : ''; ?>>English (Canada)</option>
        						<option value="en-US" <?php echo ( "en-US" == $this->params['country'] ) ? 'selected' : ''; ?>>English (United States)</option>
        					</optgroup>
        					<optgroup label="Europe">
        						<option value="de-AT" <?php echo ( "de-AT" == $this->params['country'] ) ? 'selected' : ''; ?>>German (Austria)</option>
        						<option value="fr-BE" <?php echo ( "fr-BE" == $this->params['country'] ) ? 'selected' : ''; ?>>French (Belgium)</option>
        						<option value="nl-BE" <?php echo ( "nl-BE" == $this->params['country'] ) ? 'selected' : ''; ?>>Dutch (Belgium)</option>
        						<option value="bg-BG" <?php echo ( "bg-BG" == $this->params['country'] ) ? 'selected' : ''; ?>>Bulgarian (Bulgaria)</option>
        						<option value="hr-HR" <?php echo ( "hr-HR" == $this->params['country'] ) ? 'selected' : ''; ?>>Croatian (Croatia)</option>
        						<option value="cs-CZ" <?php echo ( "cs-CZ" == $this->params['country'] ) ? 'selected' : ''; ?>>Czech (Czech Republic)</option>
        						<option value="da-DK" <?php echo ( "da-DK" == $this->params['country'] ) ? 'selected' : ''; ?>>Danish (Denmark)</option>
        						<option value="et-EE" <?php echo ( "et-EE" == $this->params['country'] ) ? 'selected' : ''; ?>>Estonian (Estonia)</option>
        						<option value="fi-FI" <?php echo ( "fi-FI" == $this->params['country'] ) ? 'selected' : ''; ?>>Finnish (Finland)</option>
        						<option value="fr-FR" <?php echo ( "fr-FR" == $this->params['country'] ) ? 'selected' : ''; ?>>French (France)</option>
        						<option value="de-DE" <?php echo ( "de-DE" == $this->params['country'] ) ? 'selected' : ''; ?>>German (Germany)</option>
        						<option value="el-GR" <?php echo ( "el-GR" == $this->params['country'] ) ? 'selected' : ''; ?>>Greek (Greece)</option>
        						<option value="hu-HU" <?php echo ( "hu-HU" == $this->params['country'] ) ? 'selected' : ''; ?>>Hungarian (Hungary)</option>
        						<option value="en-IE" <?php echo ( "en-IE" == $this->params['country'] ) ? 'selected' : ''; ?>>English (Ireland)</option>
        						<option value="it-IT" <?php echo ( "it-IT" == $this->params['country'] ) ? 'selected' : ''; ?>>Italy</option>
        						<option value="lv-LV" <?php echo ( "lv-LV" == $this->params['country'] ) ? 'selected' : ''; ?>>Latvian (Latvia)</option>
        						<option value="lt-LT" <?php echo ( "lt-LT" == $this->params['country'] ) ? 'selected' : ''; ?>>Lithuanian (Lithuania)</option>
        						<option value="fr-LU" <?php echo ( "fr-LU" == $this->params['country'] ) ? 'selected' : ''; ?>>French (Luxembourg)</option>
        						<option value="de-LU" <?php echo ( "de-LU" == $this->params['country'] ) ? 'selected' : ''; ?>>German (Luxembourg)</option>
        						<option value="mt-MT" <?php echo ( "mt-MT" == $this->params['country'] ) ? 'selected' : ''; ?>>Maltese (Malta)</option>
        						<option value="nl-NL" <?php echo ( "nl-NL" == $this->params['country'] ) ? 'selected' : ''; ?>>Dutch (Netherlands)</option>
        						<option value="pl-PL" <?php echo ( "pl-PL" == $this->params['country'] ) ? 'selected' : ''; ?>>Polish (Poland)</option>
        						<option value="pt-PT" <?php echo ( "pt-PT" == $this->params['country'] ) ? 'selected' : ''; ?>>Portuguese (Portugal)</option>
        						<option value="ro-RO" <?php echo ( "ro-RO" == $this->params['country'] ) ? 'selected' : ''; ?>>Romanian (Romania)</option>
        						<option value="sk-SK" <?php echo ( "sk-SK" == $this->params['country'] ) ? 'selected' : ''; ?>>Slovak (Slovakia)</option>
        						<option value="sl-SI" <?php echo ( "sl-SI" == $this->params['country'] ) ? 'selected' : ''; ?>>Slovenian (Slovenia)</option>
        						<option value="es-ES" <?php echo ( "es-ES" == $this->params['country'] ) ? 'selected' : ''; ?>>Spanish (Spain)</option>
        						<option value="sv-SE" <?php echo ( "sv-SE" == $this->params['country'] ) ? 'selected' : ''; ?>>Swedish (Sweden)</option>
        						<option value="en-GB" <?php echo ( "en-GB" == $this->params['country'] || empty( $this->params['country'] )) ? 'selected' : ''; ?>>English (United Kingdom)</option>
        						<option value="fr-CH" <?php echo ( "fr-CH" == $this->params['country'] ) ? 'selected' : ''; ?>>French (Switzerland)</option>
        					</optgroup>
        				</select>
        			</div>
        		</div>
        
        		<div class="input hex_color">
        			<h4><?php echo __( 'Line chart color (hex)', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h4>
        			<div class="element">
        				<input name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_HEX_LINE_COLOR; ?>" type="text" placeholder="ffffff" class="form-control" value="<?php echo ( !empty( $this->params['hex_color'] )) ? $this->params['hex_color'] : 'f4ab4c'; ?>" />
        			</div>
        		</div>
        
        		<div class="input mortgage_default_start_value">
        			<h4><?php echo __( 'Mortgage Default start value', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h4>
        			<div class="element">
        				<input name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEFAULT_MORTGAGE_START_VALUE; ?>" type="number" min="15000" placeholder="" aria-describedby="mortgage-addon" class="form-control" step="1000" value="<?php echo ( !empty( $this->params['mortgage_start_value'] )) ? $this->params['mortgage_start_value'] : 280000; ?>" />
        			</div>
        		</div>
        
        		<div class="input add_beauty_layout">
        			<h4><?php echo __( 'Add beauty layout', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></h4>
        			<div class="element">
        				<input type="radio" class="beauty_layout" value="1" name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP; ?>" id="add_boostrap_1" <?php echo ( $this->params['add_bootstrap'] == 1 ) ? 'checked="checked"' : ''; ?> />
        				<label for="add_boostrap_1" class="radio"><?php echo __( 'Yes', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></label>
        			</div>
        			<div class="element">
        				<input type="radio" class="beauty_layout" value="0" name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_ADD_BOOTSTRAP; ?>" id="add_boostrap_0" <?php echo ( $this->params['add_bootstrap'] == 0 ) ? 'checked="checked"' : ''; ?> />
        				<label for="add_boostrap_0" class="radio"><?php echo __( 'No', ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></label>
        			</div>
        		</div>
        
        		<input type="hidden" value="0" name="<?php echo ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG; ?>" />
		    <?php 
		}
	}
}