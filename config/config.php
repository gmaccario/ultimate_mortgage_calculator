<?php
return [
    'settings' => [
		'dependencies' => [],
		'restrictions' => []
	],
	'features' => [
		'backend' => [
			'hooks' => [],
			'filters'=> [],
			'shortcodes'=> [],
			'ajax'=> [],
			'routes'=> [],
		    'additional_js' => [],
		    'additional_css' => [],
			'pages'=> [
				[
				    'name'=> 'Ultimate Mortgage Calculator Backend name', 
    				'slug'=> 'ultimate_mortgage_calculator_menu_page', 
    				'attributes'=> [
    					'callback'=> 'configuration', 
    					'tabs'=> [ 
    						[ 
    							'name' => 'Welcome', 
    							'slug' => 'welcome', 
    							'callback' => 'displayTabWelcome' 
    						],
    						[ 
    							'name' => 'Configuration', 
    							'slug' => 'configuration', 
    							'callback' => 'displayTabConfiguration' 
    						]
    					]
    				]
				]
			]
		],
		'frontend' => [
			'hooks'=> [],
			'filters'=> [],
			'shortcodes'=> [
				['ultimate_mortgage_calculator'=> 'get_mortgage_shortcode']
			],
			'ajax'=> [ 'get_mortgage_calculator_results' ],
			'routes'=> [],
		    'additional_js' => [ 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js' ],
		    'additional_css' => []
		]
	],
	'comments'=> 'Pages will create new pages for your backend and tabs will create tabs inside backend pages. | Frontend shortcodes: [shortcode => frontend method]'
];