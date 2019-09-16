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
				    'name'=> 'Devon W.P.F. (WordPress Plugin Framework) Backend name', 
    				'slug'=> 'devon_wpf_menu_page', 
    				'attributes'=> [
    					'callback'=> 'configuration', 
    					'tabs'=> [ 
    						[ 
    							'name' => 'Welcome', 
    							'slug' => 'welcome', 
    							'callback' => 'displayTabWelcome' 
    						],
    					    [
    					        'name' => 'Documentation',
    					        'slug' => 'documentation',
    					        'callback' => 'displayTabDocumentation'
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
				['default_template_shortcode'=> 'default_template']
			],
			'ajax'=> [ 'echo_foo' ],
			'routes'=> [],
		    'additional_js' => [],
		    'additional_css' => []
		]
	],
	'comments'=> 'Pages will create new pages for your backend and tabs will create tabs inside backend pages. | Frontend shortcodes: [shortcode => frontend method]'
];