<?php
/**
 * @name BackendManager
 * @description The BackendManager is a wrapper for all backend wordpress related activites for example add the pages in the backend menu, add the backend js/css.
 *
 * @author G.Maccario <g_maccario@hotmail.com>
 */

namespace UMC\Setup\Classes;

use UMC\Controller\Classes\Controller;

if(!interface_exists('UMC\Setup\Classes\iBackendManager'))
{
    interface iBackendManager
    {
        public function getPages() : array;
        public function backendEnqueue();
        public function customActionLinks(array $links) : array;
        public function backendMenu();
        public function whenUltimateMortgageCalculatorStart();
    }
}

if( !class_exists('\UMC\Setup\Classes\BackendManager'))
{
    class BackendManager extends Manager
	{		
		/**
		 * @name __construct
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return
		 */
		public function __construct(Controller $backend)
		{
		    parent::__construct($backend);
		    
		    $this->setConfig();
		}
		
		/**
		 * @name getPages
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function getPages() : array
		{
		    if(!isset($this->config[ 'features' ][ 'backend' ][ 'pages' ]))
		    {
                return []; 
		    } 
		    else {
		        return $this->config[ 'features' ][ 'backend' ][ 'pages' ];
		    }
		}
		
		/**
		 * @name backendEnqueue
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function backendEnqueue()
		{
			/*
			 * Add additional frontend css/js 
			 */
			$additional_js = $this->config['features']['backend']['additional_js'];
			$additional_css = $this->config['features']['backend']['additional_css'];
			
			$this->enqueueAdditionalStaticFiles($additional_js, 'js');
			$this->enqueueAdditionalStaticFiles($additional_css, 'css');
			
			/*
			 * Add basic static files
			 */
			wp_enqueue_style('ultimate_mortgage_calculator-admin-css', sprintf( '%s%s', ULTIMATE_MORTGAGE_CALCULATOR_URL, '/assets/css/backend.css' ), array(),  '1.0');
			wp_enqueue_script('ultimate_mortgage_calculator-admin-js', sprintf( '%s%s', ULTIMATE_MORTGAGE_CALCULATOR_URL, '/assets/js/backend.js' ), array( 'jquery' ),  '1.0', true);
		}
		
		/**
		 * @name customActionLinks
		 *
		 * @param array $links
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return array
		 */
		public function customActionLinks(array $links) : array
		{
		    $pages = $this->getPages();
		    
		    if( count( $pages ) > 0 )
			{
				return array_merge($links, array( 
					sprintf( '<a href="%s">%s</a>', 
					    admin_url( 'admin.php?page=' . $this->controller->getCommon()->getConstant( $pages[0][ 'slug' ] )), 
						__( 'Settings', ULTIMATE_MORTGAGE_CALCULATOR_L10N ) 
					)
				));
			}
			
			return null;
		}
		
		/**
		 * @name backendMenu
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function backendMenu()
		{
		    $pages = $this->getPages();
		    
		    if( $pages ) 
			{
				$main_page = null;

				foreach( $pages as $k => $page )
				{
					if( 0 === $k )
					{
						$main_page = $this->controller->getCommon()->getConstant( $page[ 'slug' ] );
						
						/* TRICK: https://kylebenk.com/change-title-first-submenu-page/ */
						add_menu_page(
								__( ULTIMATE_MORTGAGE_CALCULATOR_NAME, ULTIMATE_MORTGAGE_CALCULATOR_L10N ),
								__( ULTIMATE_MORTGAGE_CALCULATOR_NAME, ULTIMATE_MORTGAGE_CALCULATOR_L10N ),
								'manage_options',
						    $this->controller->getCommon()->getConstant( $page[ 'slug' ] ),
								array( $this->controller, $page[ 'attributes' ][ 'callback' ] ),
								'dashicons-chart-line'
						);
					}

					add_submenu_page(
						$main_page,
						__( $page[ 'name' ], ULTIMATE_MORTGAGE_CALCULATOR_L10N ),
						__( $page[ 'name' ], ULTIMATE_MORTGAGE_CALCULATOR_L10N ),
						'manage_options',
					    $this->controller->getCommon()->getConstant( $page[ 'slug' ] ),
						array( $this->controller, $page[ 'attributes' ][ 'callback' ] )
					);
				}
			}
		}
		
		/**
		 * @name whenUltimateMortgageCalculatorStart
		 *
		 * @author G.Maccario <g_maccario@hotmail.com>
		 * @return void
		 */
		public function whenUltimateMortgageCalculatorStart()
		{
			register_setting( ULTIMATE_MORTGAGE_CALCULATOR_OPT_SETTINGS_FIELDS, ULTIMATE_MORTGAGE_CALCULATOR_OPT_DEBUG );
			
			/*
			WordPress Settings API
			tabs, sections, fields and settings. 
			Tabs contains sections, sections contain field(form elements) and settings are just the value attribute of the form elements. 
			http://qnimate.com/wordpress-settings-api-a-comprehensive-developers-guide/
			--
			section name
			display name
			callback to print description of section
			page to which section is attached.
			add_settings_section
			*/
			
			$active_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			$active_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			
			$pages = $this->getPages();
			
			if( $pages )
			{
			    foreach( $pages as $page )
			    {
					if( $page[ 'slug' ] == $active_page )
					{
						$tabs = $page[ 'attributes' ][ 'tabs' ];
						foreach( $tabs as $tab )
						{
							if( empty( $active_tab ) || $active_tab == $tab[ 'slug' ] )
							{
							    add_settings_section(
                                    $tab[ 'slug' ],
							        $tab[ 'name' ],
							        array( $this->controller, $tab[ 'callback' ] ) , 
							        $tab[ 'slug' ]
							    );
							}
						}
						
						break;
					}
				}
			}
		}
	}
}