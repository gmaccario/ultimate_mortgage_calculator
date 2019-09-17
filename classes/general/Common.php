<?php 

namespace UMC\General\Classes;

use UMC\Controller\Classes\iController;

if(!interface_exists('UMC\General\Classes\iCommon'))
{
    interface iCommon
    {
        public function getConfig() : array;
        public function printMyLastQuery() : string;
        public function checkDependencies() : bool;
        public function getNameClass(Basic $object) : string;
        public function renderView(iController $controller, string $view, array $params) : string;
        public function getConstant(string $sz_supposed_constant = '') : string;
        public function errorNoticeDependency();
        public function get_currency_entity( string $currency_symbol ) : string;
        public function get_rgba_from_hex( string $hex ) : string;
        //public function uploadFile(string $dir = '', array $f = []) : bool;
        //public function uploadFiles(string $dir = '', array $f = []) : bool;
    }
}

if(!class_exists('\General\Classes\Common'))
{
    /**
     * @name Common
     * @description Common Controllers behaviour 
     *
     * @author G.Maccario <g_maccario@hotmail.com>
     * @return
     */
	class Common implements iCommon
	{
		protected $debug = false;
		protected $missing_dependency = '';
		
		private $config = null;
		
		/**
		 * __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct()
		{			

		}
		
		/**
		 * prepare
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		public function prepare() : bool
		{
		    return $this->setDebug() && $this->setConfig();
		}
		
		/**
		 * setDebug
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		protected function setDebug() : bool
		{
		    if( empty($this->debug) && function_exists( 'get_option' ))
		    {
		        $this->debug = ( get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG ) ) ? get_option( ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG ) : false;
		        
		        return true;
		    }
		    
		    return false;
		}
		
		/**
		 * setConfig
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		protected function setConfig() : bool
		{
		    $path = ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'config' . DIRECTORY_SEPARATOR . 'config.php';
		    
		    if( empty( $this->config ) && file_exists( $path ))
		    {
		        $this->config = include( $path );
		        
		        return true;
		    }
		    
		    return false;
		}			
		
		/**
		 * @name getConfig
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function getConfig() : array
		{
		    return $this->config;
		}
		
		/**
		 * @name printMyLastQuery
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function printMyLastQuery() : string
		{
			global $wpdb;
			
			return $wpdb->last_query;
		}
		
		/**
		 * @name checkDependencies
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		public function checkDependencies() : bool
		{
		    // @todo
		    //register_activation_hook( __FILE__, array( 'testPlugin', 'activate' ));
		    //add_action( 'activate_plugin', '_20170113_superess_activate', 10, 2 );
		    
		    /*
		     * @note Check dependencies from the config
		     */
		    if ($this->isValidDependency())
		    {
		        return true;
		    }
		    
		    try {
		        if(!function_exists('deactivate_plugins'))
		        {
		            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		        }
		        
		        deactivate_plugins( ULTIMATE_MORTGAGE_CALCULATOR_BASENAME );
		    }
		    catch ( \Error $e ) {
		        echo $e->getMessage();
		    }
		    
		    \add_action('admin_notices', array($this, 'errorNoticeDependency'));
		    
		    return false;
		}
		
		/**
		 * @name renderView
		 *
		 * @param iController $controller
		 * @param string $view
		 * @param array $params
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function renderView(iController $controller, string $view, array $params) : string
		{			
			/* Extract attributes/values of the object to convert them into single variables */
			extract($params);
			
			switch( $this->getNameClass( $controller ))
			{
				case 'Backend':
				    $filename =  ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'templates' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . $view . '.php';
				    if( file_exists( $filename ))
				    {
				        include( $filename );
				    }
					break;
				case 'Frontend':
				    $filename =  ULTIMATE_MORTGAGE_CALCULATOR_DIR_PATH . 'templates' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . $view . '.php';
					if( file_exists( $filename ))
					{
					    ob_start();
					    include( $filename );
					    return ob_get_clean();
					}
					break;
				default:
					break;
			}
			
			return '';
		}
		
		/**
		 * @name getNameClass
		 *
		 * @param Basic $object
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getNameClass(Basic $object) : string
		{
		    $reflect = new \ReflectionClass($object);
		    
		    return $reflect->getShortName();
		}
		
		/**
		 * getConstant
		 *
		 * @param string $sz_supposed_constant
		 * 
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function getConstant(string $sz_supposed_constant = '') : string
		{
		    if(strlen($sz_supposed_constant) == 0) return '';
		    
			return ( defined( $sz_supposed_constant ) ? constant ( $sz_supposed_constant ) : $sz_supposed_constant );
		}
		
		/**
		 * uploadFile
		 *
		 * @param string $path
		 * @param array $files
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		/*public function uploadFile(string $path = '', array $files = []) : bool
		{
		    if( !empty( $files[ 'name' ]))
			{
			    $tmpFilePath = $files['tmp_name'];
					
				if( $tmpFilePath != "" )
				{
				    $filePath = $path . $files['name'];
			
					if( !move_uploaded_file( $tmpFilePath, $filePath ))
					{
						return false;
					}
					else {
						return true;
					}
				}
			}
			return null;
		}*/
		
		/**
		 * uploadFiles
		 * 
		 * @param string $path
		 * @param array $files
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		/*public function uploadFiles(string $path = '', array $files = []) : bool
		{
		    if(count($files['name']) > 0)
			{
				$result = true;
				
				for($i=0; $i<count($files['name']); $i++)
				{
				    $tmpFilePath = $files['tmp_name'][$i];
			
					if( $tmpFilePath != "" )
					{
					    $filePath = $path . $files['name'][$i];
				
						if( !move_uploaded_file( $tmpFilePath, $filePath ))
						{
						    $result = false;
						}
						else {
						    $result = true;
						}
					}
				}
				
				return $result;
		    }
		    
			return null;
		}*/
		
		/**
		 * @name errorNoticeDependency
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function errorNoticeDependency()
		{
		    $error = sprintf("Missing Dependency! %s needs %s in order to work correctly.", ULTIMATE_MORTGAGE_CALCULATOR_BASENAME, $this->missing_dependency);
		    
		    ?>
    		    <div class="error notice">
                    <p><?php echo __( $error, ULTIMATE_MORTGAGE_CALCULATOR_L10N ); ?></p>
                </div>
		    <?php 
		}
		
		/**
		 * @name isValidDependency
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return bool
		 */
		protected function isValidDependency() : bool
		{
		    if( isset( $this->config['settings']['dependencies'] ) )
		    {
    		    $dependencies = $this->config['settings']['dependencies'];
    		    
    		    if( count( $dependencies ) == 0 )
    		    {
    		        return true;
    		    }
    		    
    	        $active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ));
    	        
    	        foreach( $dependencies as $dependency )
    	        {
    	            if( !in_array( $dependency, $active_plugins ))
    	            {
    	                $this->missing_dependency = $dependency;
    	                
    	                return false;
    	            }
    	        }
		    }
		    
		    /**
		     * @note During the installation
		     * */
		    return true;
		}
		
		/**
		 * get_currency_entity
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function get_currency_entity( string $currency_symbol ) : string
		{
		    switch( $currency_symbol )
		    {
		        case 'EUR': return '&#8364;'; break;
		        case 'AUD': return '&#36;'; break;
		        case 'CAD': return '&#36;'; break;
		        case 'GBP': return '&#163;'; break;
		        case 'USD': return '&#36;'; break;
		        case 'CHF': return '&#67;&#72;&#70;'; break;
		        case 'DKK': return '&#107;&#114;'; break;
		        case 'NOK': return '&#107;&#114;'; break;
		        case 'SEK': return '&#107;&#114;'; break;
		        default: return '&#163;'; break;
		    }
		}
		
		/**
		 * get_rgba_from_hex
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return string
		 */
		public function get_rgba_from_hex( string $hex ) : string
		{
		    /*list($r, $g, $b) = array_map( 'hexdec', str_split( $hex, 2 ));*/
		    if( $hex )
		    {
		        $split = str_split( $hex, 2);
		        
		        $r = hexdec( ( $split[0] ) ? $split[0] : '00' );
		        $g = hexdec( ( $split[1] ) ? $split[1] : '00' );
		        $b = hexdec( ( $split[2] ) ? $split[2] : '00' );
		        
		        return sprintf( 'rgba(%s, %s, %s, 0.8)', $r, $g, $b );
		    }
		    
		    return '';
		}
	}
}