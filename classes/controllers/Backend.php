<?php

namespace DVNWPF\Controller\Classes;

use DVNWPF\General\Classes\Common;

if(!interface_exists('DVNWPF\Controllers\Classes\iBackend'))
{
    interface iBackend
    {
        public function configuration() : void;
        public function displayTabWelcome() : void;
        public function displayTabConfiguration() : void;
    }
}

if(!class_exists('\DVNWPF\Controllers\Classes\Backend'))
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
	                        $links .= '<span>' . __( $tab[ "name" ], DEVON_WPF_L10N) . '</span>';
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
		public function configuration() : void
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
			    $this->params['value_debug'] = get_option( DEVON_WPF_OPT_DEBUG );
			    
			} else {
				
				/*
				 * GET VALUES FROM POST
				 * *********************************************
				 */
				$this->params['value_debug'] = filter_input( INPUT_POST, DEVON_WPF_OPT_DEBUG, FILTER_SANITIZE_NUMBER_INT );
				
				/*
				 * UPDATE NEW VALUES
				 * *********************************************
				 */
				update_option( DEVON_WPF_OPT_DEBUG, $this->params['value_debug'] );
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
		public function displayTabWelcome() : void
		{
		    ?>
		    <h3><?php echo _e( "Devon W.P.F. (Wordpress Plugin Framework) is intended as a starter kit for Developers to create their own plugins.", DEVON_WPF_L10N ); ?></h3>
        	
        	<?php if( count( $this->params['available_shortcodes'] ) > 0 ): ?>
            	<div class="shortcodes">
            		<table>
                		<thead>
                    		<tr>
                    			<th colspan="2">
                    				<h2 class=""><?php echo _e( "AVAILABLE SHORTCODES", DEVON_WPF_L10N ); ?></h2>
                    			</th>
                            </tr>
                            <tr>
                                <th><?php echo _e( "Shortcode", DEVON_WPF_L10N ); ?></th>
                                <th><?php echo _e( "Frontend Method", DEVON_WPF_L10N ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($this->params['available_shortcodes'] as $available_shortcode): ?>
                        		<tr>
                        			<?php foreach($available_shortcode as $shortcode => $method): ?>
                                    	<td><?php echo $shortcode; ?></td>
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
		 * @name displayTabDocumentation
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function displayTabDocumentation() : void
		{
		    ?>
		    @todo Documentation
		    <?php 
		}
		
		/**
		 * @name displayTabConfiguration
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function displayTabConfiguration() : void
		{
		    ?>
    		    <h4><?php echo __( 'Debug', DEVON_WPF_L10N ); ?></h4>
    			<p>
    				<input type="radio" class="debug" value="1" name="<?php echo DEVON_WPF_OPT_DEBUG; ?>" id="debug_enable" <?php echo ( $this->params['value_debug'] == 1 ) ? 'checked="checked"' : ''; ?>>
    				<label for="debug_enable" class="radio"><?php echo __( 'Enable', DEVON_WPF_L10N ); ?></label>
    			</p>
    			<p>
    				<input type="radio" class="debug" value="0" name="<?php echo DEVON_WPF_OPT_DEBUG; ?>" id="debug_disable" <?php echo ( $this->params['value_debug'] == 0 ) ? 'checked="checked"' : ''; ?>>
    				<label for="debug_disable" class="radio"><?php echo __( 'Disable', DEVON_WPF_L10N ); ?></label>
    			</p>
		    <?php 
		}
	}
}