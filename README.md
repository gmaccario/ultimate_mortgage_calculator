# Devon W.P.F. (WordPress Plugin Framework)
## version 1.0
This is a Devon W.P.F. (WordPress Plugin Framework).

Devon W.P.F. (Wordpress Plugin Framework) is intended as a starter kit for Developers to create their own plugins.

Why a Framework? As Developer I worked for years in a company as WordPress Developer and every time I started a new plugin development I was forced to create a new folder, new files, a new structure that was pretty similar to the previous ones. I really don't like repeat unnecessary and manual tasks. Errors are just around the corner. I early decided to start to create my own Skeleton, that's became a Framework. Based on a config file, Developers can just be focused on their own business logic.

My starting points: 
* a configuration file where set up hooks, filters and shortcodes + ajax calls and dependencies with other plugin (e.g. 'woocommerce/woocommerce.php')
* a mechanism that read the config and create everything I need without modify the code everytime
* static resources already in places at the creation of the plugin
* you can write your business logic only inside two controller classes: Fronted and Backend
* add your templates view and add your JS + CSS + HTML codes
* an autolader system that allows to auto load every class I need
* and so on...

Different version of the early Skeleton are using on several production websites, you can find a list on my personal website (@todo).

## Things to do before start - Mandatory
- Change the folder name;
- Change the name of the main file with the same name of the folder (now devon-wpf.php);
- Search and replace placeholder strings. Find and replace in in files (match case):
	- DEVON_WPF => constants, i.e. MY_GALACTIC_PLUGIN
	- DVNWPF => namespace, i.e. MYNEWNAMESPACE
	- devon_wpf => function name, i.e. your_plugin_slug
	- devon-wpf => function name, i.e. your-plugin-slug
	- DevonWPF => method name, i.e. YourPluginSlug
	- Devon W.P.F. (WordPress Plugin Framework) => string, i.e. Your plugin name
- Launch composer dump-autoload to install the dependencies

**Have fun (and money!) adding your new features!**

## Example 1
### Add an Ajax call to the frontend:
- Create a page in your WordPress installation
- Insert shortcode [default_template_shortcode] inside you new page
- Add this snippet into /assets/js/frontend.js:
~~~~javascript
var data = {
	'action': 'echo_foo',
	'whatever': 1234
};
jQuery.post(ajaxurl, data, function(response) {
	console.log('Got this from the server: ', response);
});
~~~~
- Refresh the page: check into your console (F12)!

You can do the same on backend side: 
- insert your shortcodes in config file  (features->backend->shoortcodes)
- create your method that returns a json result inside Backend class
- add an ajax call to your backend javascript
- Refresh page your backend page and check into your console (F12)!

** Explanation:
The default config starts with preconfigured shortcode and ajax (default_template_shortcode and echo_foo). 
Everything is ready in the Frontend controller, then we can just consume the result with a JQuery post request and log it into the console.

## Example 2
### Add a new page on backend
- Set new pages in config
- Create a new callback method in classes/controllers/Controller.php
- In case of new tabs, create a new callback method in classes/controllers/Controller.php
- In case of new options, Add new updates in configuration() 
- Create your own template

## Example 3
### Add a new tabs on backend page
- Add new tabs in config
- Create a new callback method in classes/controllers/Controller.php
- In case of new inputs, add the new updates inside page method, configuration() for instance 
- Add your new section using do_settings_sections() inside your template

## Composer
https://getcomposer.org/doc/01-basic-usage.md
php composer.phar install
composer require --dev phpunit/phpunit ^5.*

-> to test it: phpunit --version

## PHPUnit
https://phpunit.readthedocs.io/en/latest/installation.html
https://phpunit.de/getting-started/phpunit-6.html

How to launch a test:
phpunit --verbose <YOUR PATH>\devon_wpf\tests\Common.test.php

## Autoload
https://getcomposer.org/doc/01-basic-usage.md#autoloading

## Tested on
- PHP 7.1.20
- Apache/2.4.25 (Debian)
- WordPress Version 5.2.2

## Change log Devon Framework
### 1.1
* @todo

## Change log Skeleton
### 2.0
* Updated to PHP 7 and dispatcher refactoring
* [default_template] renamed in [default_template_shortcode]
* Added new config features: pages and tabs
### 1.8.1
* Fixed shortcode and render view
* Minor fixes
* Moved frontend/backend css/js version into constants
* Use config to generate backend pages and Settings link (on plugins list page)
* Remove constants and put them into the config (i.e. DEVON_WPF_BACKEND_MENU)
* Config loaded into the Basic class
### 1.8
* [basic_form] renamed in [default_template]
* Moved [basic_form] shortcode into the config file
* Added config file to manage hooks and filters
* Add render_view method in Common class
* Re-organized classes folder based on purpose, autoloader modified
* Added Backend and Frontend Manager classes in order to make Backend and Frontend basic classes more similar to a controller
* Added separate constants file
### 1.7
* Moved constants into specific file
* Added some HTML to the configuration backend page
* Improved frontend_enqueue and backend_enqueue
* Created new constants OPTIONS and STRINGS
* Modified Backend.class on configuration_page controller
* Added print_array in Basic.class
* Created constant DEVON_WPF_L10N for Localization

## TODO
- Add languages translation
- Improve checkDependencies
- Improve uninstall: missing constants in main file
- check https://codex.wordpress.org/WordPress_Coding_Standards

### Why the name Devon?
https://knight-rider.fandom.com/wiki/Devon_Miles

## License
GNU General Public License v3.0 https://www.gnu.org/licenses/gpl-3.0.en.html

## Author
* Author: Giuseppe Maccario
* Author URI: https://www.giuseppemaccario.com/
* Github URI: https://github.com/gmaccario/devon-wpf