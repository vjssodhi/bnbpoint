<?php
/*
Plugin Name: Love Button
Description: Secure social sharing plugin. With the Love Button the search for a data privacy correctly social sharing has an ned. This plugin only counts the number of time, the specific sharing buttons are clicked on each page of your website only in your database - nothing else and nowhere else. 
Plugin URI: http://love.delucks.com
Version: 2.0.4
Author: deLucks
Author URI: http://delucks.com

Love Button Free is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Love Button Free is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Love Button Free. If not, see <http://www.gnu.org/licenses/>.

NOTE:
Enabling the premium functions without a valid license makes this software
to another software version which is subject to the terms of http://love.delucks.com/agb
and no longer subject to the GNU/GPL.
*/
?><?php
ini_set('display_errors', 'off');
error_reporting(0);

if(is_admin()){
	#ini_set('display_errors', 'on');
	#error_reporting(E_ALL);
}

$pluginDir = dirname(__FILE__) . '/';
require_once($pluginDir . 'be/nav-menu-item.php');

if(!class_exists('delucksLoveButton')){
	class delucksLoveButton {

		var $dbVersion 				= 1;
		var $pluginVersion			= '2.0.4';
		var $licenseServer			= 'http://love.delucks.com';
		var $pluginDir				= null;
		var $availableNetworks 		= null;
		var $options 				= null;
		var $pluginName				= 'Love Button';
		var $settingPage			= '';
		var $pluginHook				= 'delucks-love-button';
		var $dbTable 				= 'delucksLoveButton';
		var $dbTableStatistics		= 'delucksLoveButtonStatistics';
		var $optionKey				= 'delucks-love-button_option';
		var $sortedNetworks			= array();
		var $networksSettings		= array();
		var $shareTitle				= '';
		var $shareUrl				= '';
		var $shareDescription		= '';
		var $statistic				= null;
		var $statisticTotal			= null;
		var $defaultVerb			= 'Love';
		var $countingAllowed		= false;
		var $user					= null;
		
		
		function __construct($initOnly = false){
			global $new_whitelist_options;
			$new_whitelist_options[ $this->optionKey ][] = $this->optionKey;
			$this->options = get_option($this->optionKey);
			if(!is_array($this->options)){
				$this->setDefaults();
			}
			
			$this->options['licenseServer'] = $this->licenseServer;
			$this->options['pluginUrl'] = plugins_url( '', __FILE__ );
			
			$this->pluginDir = dirname(__FILE__) . '/';
			$this->availableNetworks = $this->getAvailableNetworks();
			$this->sortedNetworks = $this->getSortedNetworks();

			if($initOnly === true){
				add_action('init', array(&$this, 'init'));
				return;
			}

			$this->updateCheck();
			add_shortcode('love-button', array(&$this, 'runShortcode'));
			
			add_action('init', array(&$this, 'init'));
			wp_enqueue_script('jquery');
			
			if(is_admin()){
				//prepare backend
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-sortable');
				
				
				
				
				
				register_activation_hook(__FILE__, array(&$this, 'install'));
				add_action('admin_head', array(&$this, 'prepareAdminHead'));
				
				
				
				add_action('admin_menu', array(&$this, 'addConfigPage'));
				add_action('init', array(&$this, 'register_editor_buttons'));
				if(isset($this->options['stats']['migrate']) && $this->options['stats']['migrate']){
					$this->migrateStatistic();
				}
				$this->statistic = $this->getStatistic();
				$this->statisticTotal = $this->getTotal();
			} else {
				//prepare frontend
				if(isset($this->options['ogImage']) && trim($this->options['ogImage']) && strlen(trim($this->options['ogImage']))){
					add_action('wp_head', array(&$this, 'addOgImage'), -9999999999999999);
				}
				
				add_action('wp_head', array(&$this, 'prepareFrontendHead'));
			
				if(isset($this->options['placement']['filter'])){
					switch($this->options['placement']['filter']){
						case 'above':
						case 'below':
							add_filter('the_content', array(&$this, 'applyFilter'), 50);
							break;
						case 'date':
							$applyOn = 'the_date';
							add_filter('the_date', array(&$this, 'applyFilter'), 50);
							break;
					}
				}
			}
		}
		
		function getRoles(){
			return new WP_Roles();
		}
		
		function getUserRoles(){
			$current_user = $this->user;
			return $current_user->roles;			
		}
		
		function checkPermissions(){
			if(count($this->getUserRoles())){
				foreach($this->getUserRoles() as $k => $v){
					if(isset($this->options['counting']['countGroups']) && is_array($this->options['counting']['countGroups']) && in_array($v, $this->options['counting']['countGroups'])){
						$this->countingAllowed = true;
					}
				}
			} else {
				if(isset($this->options['counting']['countGroups']) && is_array($this->options['counting']['countGroups']) && in_array('guest', $this->options['counting']['countGroups'])){
					$this->countingAllowed = true;
				}
			}
		}
		
		function initNetworkSettings(){
			if(count($this->sortedNetworks)){
				foreach($this->sortedNetworks as $network){
					$settingDir = $this->pluginDir.'functions/settings/';
					if(file_exists($settingsFile = $settingDir.$network['name'].'.php')){
						$settings = @include_once($settingsFile);
						if(is_array($settings)){
							$this->networkSettings[$network['name']] = $settings;
						}
					}
				}
			}
		}
		
		function getInput($settings, $network){
			$input = '';
			switch($settings['type']){
				case 'text':
					$input = '<input type="text" name="'.$this->optionKey.'[networkSettings]['.$network.']['.$settings['name'].']" value="'.$this->options['networkSettings'][$network][$settings['name']].'" />';
					break;
				case 'checkbox':
					$input = '<input type="checkbox" value="1" name="'.$this->optionKey.'[networkSettings]['.$network.']['.$settings['name'].']" '.($this->options['networkSettings'][$network][$settings['name']] == 1 ? 'checked="checked"' : '').' />';
					break;
			}
			return $input;
		}

		/* EDITOR BUTTON START */
		function register_editor_buttons() {
			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
				return;
			}
			if ( get_user_option('rich_editing') == 'true' ) {
				add_filter( 'mce_external_plugins', array(&$this, 'imagerights_add_plugin'));
				add_filter( 'mce_buttons', array(&$this, 'imagerights_register_button'));
			}
		}
		
		function imagerights_add_plugin( $plugin_array ) {
			$plugin_array['dontshareimage'] = plugins_url('be/js/editor-button-dont-share-image-admin.js',__FILE__);
			return $plugin_array;
		}
		
		function imagerights_register_button( $buttons ) {
			array_push( $buttons, "dontshareimage" );
			return $buttons;
		}
		/* EDITOR BUTTON END */


		/*
		 * load language files
		 * */
		function init() {
			$this->user = wp_get_current_user();
			load_plugin_textdomain($this->pluginHook, false, dirname(plugin_basename( __FILE__ )) . '/languages/');
			/*
			 * call user function if is an ajax request
			 * ajax url should look like: /?delucksAjax[method]={method}&delucksAjax[params][]={param1}&delucksAjax[params][]={param2}
			 * */
			if(isset($_GET['delucksAjax']['method']) && method_exists($this, $_GET['delucksAjax']['method'])){
				//prevent error output by any plugin to return a valid response
				ini_set('display_errors', 'off');
				error_reporting(0);
				$output = call_user_func_array(array($this, $_GET['delucksAjax']['method']), (isset($_GET['delucksAjax']['params']) && is_array($_GET['delucksAjax']['params']) ? $_GET['delucksAjax']['params'] : array()));
				if(is_array($output) || is_object($output)){
					die(json_encode($output));
				}
				die($output);
			}
		}
		
		/*
		 * scan function directory and return all filenames without extension
		 * */
		function getAvailableNetworks(){
			$networks = array();
			foreach(scandir($functionDir = $this->pluginDir.'functions/') as $function){
				if(!is_dir($functionDir.$function) && is_readable($functionDir.$function)){
					$networks[] = strtolower(preg_replace('/\.php$/', '', $function));
				}
			}
			return $networks;
		}
		
		/*
		 * get all networks sorted by backend user incl. status
		 * */
		function getSortedNetworks(){
			$networks = array();
			$available = $this->getAvailableNetworks();
			$active = (isset($this->options['networks']) ? $this->options['networks'] : false);

			if(is_array($active) && count($active)){
				foreach($active as $k => $v){
					unset($available[array_search($v, $available)]);
					$network = array('name' => $v, 'active' => 1);
					array_push($networks, $network);
				}
			}
			
			if(is_array($available) && count($available)){
				foreach($available as $k => $v){
					$network = array('name' => $v, 'active' => 0);
					array_push($networks, $network);
				}
			}
			
			return $networks;
		}
		
		function validateOptions($input){
			return $input;
		}

		/*
		 * If no option array exists, get the default value and store in database
		 * */
		function setDefaults(){
			$this->options = array(
					'license' => '',
					'showBranding' => 1,
					'style' => '59x16',
					'theme' => 'bright',
					'displayVerb' => '0',
					'removeBackgrounds' => '0',
					'heartless' => '0',
					'verb' => $this->defaultVerb,
					'verbClass' => '',
					'customImageUrl' => '',
					'showDataPrivacy' => 1,
					'showDataPrivacyTextByDefault' => 0,
					'showCounters' => 1,
					'showCountersPopup' => 1,
					'networks' => array('favorite', 'mail', 'print','facebook', 'google', 'twitter'),
					'useOgImage' => '',
					'useOgImageWidth' => '',
					'useOgImageHeight' => '',
					'ogImage' => '',
					'counting' => array('countGroups' => array()),
					'popup' => array(	'position-y' => 'auto',
										'position-x' => 'auto',
										'columns' => '3'
							   ),
					'placement' => array(	'type' => '3',
											'align' => 'right',
											'filter' => 'below',
											'margin' => array(	'top' => '0',
																'right' => '0',
																'bottom' => '0',
																'left' => '0'),
											'position' => 'relative',
											'position-data' => array( 	'top' => '',
																		'right' => '',
																		'bottom' => '',
																		'left' => '')
									),
					'shareBasedOnId' => 1,
					'countInternalLike' => 0,
					'stats' => array(	'range' => 'week',
										'from' => '',
										'to' => '',
										'limit' => '15',
										'hideEmpty' => 1,
										'migrate' => 0)
			);

			$this->options['db_version'] = $this->db_version;
			update_option( $this->optionKey, $this->options );
		}

		/*
		 * load javascript and styles in backend
		 * */
		function prepareAdminHead(){
			$options = $this->options;
			unset($options['license']);
			$language['AreYouSure'] = __('Are you sure?', $this->pluginHook);
			
			echo "<link rel='stylesheet' href='".plugins_url( 'be/js/DataTables-1.9.4/media/css/jquery.dataTables.css', __FILE__ )."' type='text/css' />\n";
			echo "<link rel='stylesheet' href='".plugins_url( 'be/style.css', __FILE__ )."' type='text/css' />\n";
			if(isset($this->options['removeBackgrounds']) && $this->options['removeBackgrounds'] == 1){
				echo "<link rel='stylesheet' href='".plugins_url( 'fe/removeBackgrounds.css', __FILE__ )."' type='text/css' />\n";
			}

			echo "<script type='text/javascript' src='".plugins_url( 'be/js/DataTables-1.9.4/media/js/jquery.dataTables.min.js', __FILE__ )."'></script>\n";
			echo "<script type='text/javascript' src='https://www.google.com/jsapi'></script>\n";
			echo '<script type="text/javascript">'.";\n";
			echo 'google.load("visualization", "1", {packages:["corechart"]});'."\n";
			echo '</script>'."\n";
			echo "<script type='text/javascript'>\n";
			echo "	loveButtonOptions = ".json_encode($options).";\n";
			echo "	loveButtonLanguage = ".json_encode($language).";\n";
			echo "</script>\n";
			echo "<script type='text/javascript'>var loveButtonAjaxUrl = '". site_url((substr(get_site_url(), -1, 1) == '/') ? '' : '/') ."';</script>";
			
			
			
			#echo "<link rel='stylesheet' href='".plugins_url( 'be/js/tipsy/tipsy.css', __FILE__ )."' type='text/css' />\n";
			
			wp_enqueue_style('tipsy', plugins_url( 'be/js/tipsy/tipsy.css', __FILE__ ));
			wp_enqueue_script('tipsy', plugins_url( 'be/js/tipsy/jquery.tipsy.js', __FILE__ ), array('jquery'));
			
			
			
			if(file_exists(plugin_dir_path(__FILE__ ).'script.js')){
				wp_enqueue_script('love_button_settings', plugins_url( 'script.js', __FILE__ ), array('jquery'));
			} else {
				wp_enqueue_script('love_button_settings', plugins_url( 'script.min.js', __FILE__ ), array('jquery'));
			}
			wp_localize_script('love_button_settings', 'delucksLoveButtonSettings', $this->options);
		}
				
		/*
		 * add backend menu entry, settings page and register settings to edit
		 * */
		function addConfigPage(){
			$this->initNetworkSettings();
			//add_menu_page($this->pluginName, $this->pluginName, 'manage_options', $this->pluginHook, array( &$this, 'getConfigPage' ),   plugins_url('images/menu_icon.png', __FILE__), 100);
			$this->settingPage = add_options_page($this->pluginName, $this->pluginName, 'manage_options', $this->pluginHook , array( &$this, 'getConfigPage' ) );
			register_setting($this->optionKey, $this->optionKey);
		}
		
		/*
		 * include settings page on version > 3.1
		 * */
		function getConfigPage(){
			global $wp_version;
			if(version_compare($wp_version, '3.2', '<')){
				settings_errors();
			}
			include_once('be/config.php');
		}

		/*
		 * create database
		 * */
		function install(){
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$sql = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.$this->dbTable."` ( `id` BIGINT( 20 ) UNSIGNED NULL DEFAULT NULL AUTO_INCREMENT PRIMARY KEY , `url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `total` BIGINT( 20 ) UNSIGNED NULL DEFAULT '0' ) ENGINE = MYISAM ;";
			$wpdb->query($sql);
			$sql = "CREATE TABLE IF NOT EXISTS `".$wpPrefix.$this->dbTableStatistics."` ( `id` BIGINT( 20 ) NOT NULL , `network` VARCHAR( 255 ) NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , INDEX ( `id` ) ) ENGINE = MYISAM ;";
			$wpdb->query($sql);
			$this->installMissingFunctions();
		}
		
		function upgradeDatabase(){

		}
		
		function truncateDatabase(){
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$wpdb->query("TRUNCATE `".$wpPrefix.$this->dbTable."`");
			$wpdb->query("TRUNCATE `".$wpPrefix.$this->dbTableStatistics."`");
			return $sql;
		}
		
		/*
		 * check for update on shop server and prepare updater
		 * updater adds an update notice to plugins page
		 * */
		function updateCheck(){
			if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
				include( dirname( __FILE__ ) . '/be/EDD_SL_Plugin_Updater.php' );
			}

			$edd_updater = new EDD_SL_Plugin_Updater( $this->licenseServer, __FILE__, array(
					'version' 	=> $this->pluginVersion,
					'license' 	=> (isset($this->options['license']) ? trim($this->options['license']) : ''),
					'item_name' => 'Love Button Premium',
					'author' 	=> 'deLucks'
			));

			if(isset($this->options['db_version']) && $this->dbVersion > $this->options['db_version']){
				$this->upgradeDatabase();
			}
		}
		
		/*
		 * get available networks, show wether a network column exists in database and add if not
		 * */
		function installMissingFunctions(){
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
		
			$colNames = array();
			$cols = $wpdb->get_results("SHOW COLUMNS FROM `".$wpPrefix.$this->dbTable."`");
			if(count($cols)){
				foreach($cols as $col){
					$colNames[] = $col->Field;
				}
			}
		
			$availableNetworks = $this->availableNetworks;
			$availableNetworks[] = 'internal';
			
			if(count(array_values($availableNetworks))){
				foreach(array_values($availableNetworks) as $function){
					if(!in_array($function, $colNames)){
						$wpdb->query("ALTER TABLE `".$wpPrefix.$this->dbTable."` ADD `$function` INT NOT NULL DEFAULT '0'");
					}
				}
			}
		}
		
		function addOgImage(){
			if(!isset($this->options['ogImage'])){
				return false;
			}
			echo '<meta property="og:image" content="'.esc_url(trim($this->options['ogImage'])).'" />'."\n";
		}
		
		/*
		 * load javascript and styles in frontend
		 * */
		function prepareFrontendHead(){
			$options = $this->options;
			$this->checkPermissions();
			unset($options['license']);
			$language['DontShowAgain'] = __('Don\'t show again', $this->pluginHook);
			$language['Sec'] = __('Sec.', $this->pluginHook);

			echo "<link rel='stylesheet' href='".plugins_url( 'fe/style.css', __FILE__ )."' type='text/css' />\n";
			
			$customStyleFile = 'love-button-style_custom.css';
			if(is_readable(get_template_directory() . '/' . $customStyleFile)){
				echo "<link rel='stylesheet' href='".get_template_directory_uri() . '/' . $customStyleFile ."' type='text/css' />\n";
			} elseif(is_readable(plugin_dir_path(__FILE__) . 'fe/' . $customStyleFile)){ //get custom style file from plugins dir
				echo "<link rel='stylesheet' href='".plugins_url( 'fe/' . $customStyleFile, __FILE__ )."' type='text/css' />\n";
			}

			if(isset($this->options['removeBackgrounds']) && $this->options['removeBackgrounds'] == 1){
				echo "<link rel='stylesheet' href='".plugins_url( 'fe/removeBackgrounds.css', __FILE__ )."' type='text/css' />\n";
			}
			
			echo "<script type='text/javascript'>var loveButtonAjaxUrl = '". site_url((substr(get_site_url(), -1, 1) == '/') ? '' : '/') ."';</script>";
			echo "<script type='text/javascript'>\n";
			echo "	loveButtonOptions = ".json_encode($options).";\n";
			echo "	loveButtonLanguage = ".json_encode($language).";\n";
			echo "	loveButtonShareData = ".json_encode($this->getShareData()).";\n";
			echo "	loveButtonCountingAllowed = " .  ($this->countingAllowed == true ? 'true' : 'false') . ";\n";
			echo "</script>\n";

			echo "<script type='text/javascript' src='".plugins_url( 'jcookie.min.js', __FILE__ )."'></script>\n";
			if(file_exists(plugin_dir_path(__FILE__ ).'script.js')){
				echo "<script type='text/javascript' src='".plugins_url( 'script.js', __FILE__ )."'></script>\n";
			} else {
				echo "<script type='text/javascript' src='".plugins_url( 'script.min.js', __FILE__ )."'></script>\n";
			}
		}
		
		/*
		 * apply the filter to the correct content position if the current page is a page type set in the backend
		 * */
		function applyFilter($content) {
			$filterAllowed = false;
			if(isset($this->options['placement']['type'])){
				switch($this->options['placement']['type']){
					case 1:
						if(is_single() || is_page() || is_front_page() || is_category()){
							$filterAllowed = true;
						}
						break;
					case 2:
						if(is_single() || is_page()){
							$filterAllowed = true;
						}
						break;
					case 3:
						if(is_single()){
							$filterAllowed = true;
						}
						break;
				}
			}
						
			if(!$filterAllowed){
				return $content;
			}

			$buttons = $this->get();
			if(isset($this->options['placement']['filter'])){
				switch($this->options['placement']['filter']){
					case 'above':
						return $buttons.$content;
						break;
					case 'below':
						return $content.$buttons;
						break;
					case 'date':
						return $buttons.$content;
						break;
					case 'title':
						return $buttons.$content;
						break;
				}
				
				if($this->options['placement']['filter'] == 'below'){
					return $content.$buttons;
				}
			}

			return $buttons.$content;
		}
		
		/*
		 * get share data
		 * */
		function getShareData(){
			$data = array();
			if((isset($this->options['placement']['type']) && $this->options['placement']['type'] == 0) || (isset($this->options['shareBasedOnId']) && $this->options['shareBasedOnId'] != 1)){
				$data['shareTitle']					= urlencode(trim((is_home() || is_front_page() || is_category() ? get_bloginfo('title', 'display') : get_the_title() . ' | ' . get_bloginfo('name'))));
				$data['shareTitleOriginal']			= trim((is_home() || is_front_page() || is_category() ? get_bloginfo('title', 'display') : get_the_title() . ' | ' . get_bloginfo('name')));
				$data['shareUrl'] 					= urlencode(get_bloginfo('wpurl') . $_SERVER['REQUEST_URI']);
				$data['shareDescription'] 			= rawurlencode(wp_strip_all_tags(get_bloginfo('description'), true));
				$data['shareDescriptionOriginal'] 	= wp_strip_all_tags(get_bloginfo('description'), true);
			} else {
				$postId 							= get_the_ID();
				$postData 							= get_post($postId);
				$postPermalink 						= get_permalink($postId);
				$data['shareTitle'] 				= urlencode(trim($postData->post_title));
				$data['shareTitleOriginal'] 		= trim($postData->post_title);
				$data['shareUrl'] 					= urlencode(trim($postPermalink));
				$data['shareDescription'] 			= rawurlencode(wp_strip_all_tags($postData->post_excerpt, true));
				$data['shareDescriptionOriginal'] 	= wp_strip_all_tags($postData->post_excerpt, true);
			}
			return $data;
		}	

		/*
		 * from shortcode get the button with an extra param 'fromShortcode = true'
		 * */
		function runShortcode($args = array()){
			return $this->get($args, true);
		}
		
		/*
		 * get the button
		 * */
		function get($args = false, $fromShortcode = false){
			if(!is_admin()){
				if(!isset($this->options['networks']) || !is_array($this->options['networks']) || !array_keys($this->options['networks'])){
					return false;
				}
			}
			
			$useCustomImage = false;

			if (isset($args['networks']) && strlen($args['networks'])){
				 foreach($args['networks'] as $k => $v){
				 	$opt['networks'][] = array('name' => $v, 'active' => 1);
				 }
			} elseif(is_admin()){
				foreach($this->getAvailableNetworks() as $k => $v){
					$opt['networks'][] = array('name' => $v, 'active' => 1);
				}
			} else {
				$opt['networks'] = $this->sortedNetworks;
			}
			
			$opt['style'] 							= ((isset($args['style']) && strlen($args['style'])) ? $args['style'] : $this->options['style']);
			$opt['theme'] 							= ((isset($args['theme']) && strlen($args['theme'])) ? $args['theme'] : $this->options['theme']);
			$opt['float'] 							= ((isset($args['align']) && strlen($args['align'])) ? $args['align'] : $this->options['placement']['align']);
			$opt['displayverb']						= ((isset($args['displayverb']) && strlen($args['displayverb'])) ? $args['displayverb'] : $this->options['displayVerb']);
			$opt['verb']							= ((isset($args['verb']) && strlen($args['verb'])) ? $args['verb'] : (isset($this->options['verb']) && strlen($this->options['verb']) ? $this->options['verb'] : $this->defaultVerb));
			$opt['verbclass']						= ((isset($args['verbclass']) && strlen($args['verbclass'])) ? $args['verbclass'] : (isset($this->options['verbClass']) && strlen($this->options['verbClass']) ? $this->options['verbClass'] : ''));
			$opt['heartless']						= ((isset($args['heartless']) && strlen($args['heartless'])) ? $args['heartless'] : $this->options['heartless']);
			
			$opt['showcounters']					= (isset($args['showcounters']) ? $args['showcounters'] : $this->options['showCounters']);
			$opt['showcounterspopup']				= (isset($args['showcounterspopup']) ? $args['showcounterspopup'] : $this->options['showCountersPopup']);
			$opt['showdataprivacytextbydefault']	= ((isset($args['showdataprivacytextbydefault']) && strlen($args['showdataprivacytextbydefault'])) ? $args['showdataprivacytextbydefault'] : $this->options['showDataPrivacyTextByDefault']);
			$opt['showdataprivacy']					= ((isset($args['showdataprivacy']) && strlen($args['showdataprivacy'])) ? $args['showdataprivacy'] : $this->options['showDataPrivacy']);
			$opt['popupcolumns']					= ((isset($args['popupcolumns']) && strlen($args['popupcolumns'])) ? $args['popupcolumns'] : $this->options['popup']['columns']);
			$opt['customimageurl']					= ((isset($args['customimageurl']) && strlen($args['customimageurl'])) ? $args['customimageurl'] : $this->options['customImageUrl']);
			
			$opt['popupy']			= 'popupy' . ((isset($args['popupy']) && strlen($args['popupy'])) ? $args['popupy'] : $this->options['popup']['position-y']);
			$opt['popupx']			= 'popupx' . ((isset($args['popupx']) && strlen($args['popupx'])) ? $args['popupx'] : $this->options['popup']['position-x']);

			$opt['margin-top'] 		= ((isset($args['margintop']) && strlen($args['margintop'])) ? $args['margintop'] : $this->options['placement']['margin']['top']) . 'px';
			$opt['margin-right']	= ((isset($args['marginright']) && strlen($args['marginright'])) ? $args['marginright'] : $this->options['placement']['margin']['right']) . 'px';
			$opt['margin-bottom'] 	= ((isset($args['marginbottom']) && strlen($args['marginbottom'])) ? $args['marginbottom'] : $this->options['placement']['margin']['bottom']) . 'px';
			$opt['margin-left'] 	= ((isset($args['marginleft']) && strlen($args['marginleft'])) ? $args['marginleft'] : $this->options['placement']['margin']['left']) . 'px';
				
			$opt['position'] 		= ((isset($args['position']) && strlen($args['position'])) ? $args['position'] : $this->options['placement']['position']);
			$opt['position-top'] 	= ((isset($args['positiontop']) && strlen($args['positiontop'])) ? $args['positiontop'] . 'px' : (strlen($this->options['placement']['position-data']['top']) ? $this->options['placement']['position-data']['top']. 'px' : ''));
			$opt['position-right']	= ((isset($args['positionright']) && strlen($args['positionright'])) ? $args['positionright'] . 'px' : (strlen($this->options['placement']['position-data']['right']) ? $this->options['placement']['position-data']['right']. 'px' : ''));
			$opt['position-bottom'] = ((isset($args['positionbottom']) && strlen($args['positionbottom'])) ? $args['positionbottom'] . 'px' : (strlen($this->options['placement']['position-data']['bottom']) ? $this->options['placement']['position-data']['bottom']. 'px' : ''));
			$opt['position-left'] 	= ((isset($args['positionleft']) && strlen($args['positionleft'])) ? $args['positionleft'] . 'px' : (strlen($this->options['placement']['position-data']['left']) ? $this->options['placement']['position-data']['left']. 'px' : ''));
			
			$opt['position-string'] =  (strlen($opt['position-top']) ? ' top: '.$opt['position-top'].';' : '');
			$opt['position-string'] .= (strlen($opt['position-right']) ? ' right: '.$opt['position-right'].';' : '');
			$opt['position-string'] .= (strlen($opt['position-bottom']) ? ' bottom: '.$opt['position-bottom'].';' : '');
			$opt['position-string'] .= (strlen($opt['position-left']) ? ' left: '.$opt['position-left'].';' : '');
			
			#print_r($opt);

			if($opt['style'] == 'custom'){
				if(!strlen($opt['customimageurl'])){
					$opt['style'] = '59x16';
				} else {
					$useCustomImage = true;
				}
			}

			
			if($fromShortcode || (isset($this->options['shareBasedOnId']) && $this->options['shareBasedOnId'] != 1)){
				$this->shareTitle 		= urlencode(trim((is_home() || is_front_page() || is_category() ? get_bloginfo('title', 'display') : get_the_title() . ' | ' . get_bloginfo('name'))));
				$this->shareUrl 		= urlencode(get_bloginfo('wpurl') . $_SERVER['REQUEST_URI']);
				$this->shareDescription = rawurlencode(wp_strip_all_tags(get_bloginfo('description'), true));
				if(!is_admin()){
					$printAll = true;
				}
			} else {
				$postId 				= get_the_ID();
				$postData 				= get_post($postId);
				$postPermalink 			= get_permalink($postId);				
				$this->shareTitle 		= urlencode(trim($postData->post_title));
				$this->shareUrl 		= urlencode(trim($postPermalink));
				$this->shareDescription = rawurlencode(wp_strip_all_tags($postData->post_excerpt, true));
				
				$likePost = true;
			}
			
			$output = '<div class="delucksShareButtonsClear"></div>';
			$output = '';
			@$output .= '<div class="'.@$postId.'post'.(@$likePost ? ' likePost' : '').' delucksShareButtonsOuterWrapper style_'.$opt['style'].' theme_'.$opt['theme'].' '.(isset($this->options['heartless']) && $this->options['heartless'] && !is_admin() ? ' heartless' : '').' '.$opt['popupy'].' '.$opt['popupx'].'" style="float: '.$opt['float'].'; margin: '.$opt['margin-top'] . ' ' . $opt['margin-right'] . ' ' . $opt['margin-bottom'] . ' ' . $opt['margin-left'].'; position: '. $opt['position'] .';'.$opt['position-string'].'">';
			$output  .= '<div class="delucksShareButtonsTools" title="'.__('Love this, share your love', $this->pluginHook).'">';
			@$output .= '	<span class="delucksShareButtonsTrigger style_'.($args['style'] ? $args['style'] : isset($this->options['style']) ? $this->options['style'] : '').((isset($this->options['countInternalLike']) && $this->options['countInternalLike']) ? ' countClick' : '').'">';
			
			if($opt['style'] == '52x60'){
				$output .= '	<span class="delucksShareButtonsCounter counter '. (!$opt['showcounters'] ? 'hide' : 'show') .'">0</span>';
				$output .= '	<span class="icon">';
				$output .= 			'<span class="verb' . (strlen($opt['verbclass']) ? ' '. $opt['verbclass'] : '') . '"' . ($opt['displayverb'] ? '' : ' style="display:none;"') . '>'.$opt['verb'].'</span>';
				$output .= '	</span>';
			} elseif($opt['style'] == 'custom' && $useCustomImage){
				$output .= '	<span class="icon"><img src="'.$opt['customimageurl'].'" alt=""/></span>';
			} else {
				$output .= '	<span class="icon">';
				$output .= 			'<span class="verb'. (strlen($opt['verbclass']) ? ' '. $opt['verbclass'] : '') .'"' . ($opt['displayverb'] ? '' : ' style="display:none;"') . '>'.$opt['verb'].'</span>';
				$output .= '	</span>';
				$output .= '	<span class="delucksShareButtonsCounter counter '. (!$opt['showcounters'] ? 'hide' : 'show') .'">0</span>';
			}
			
			$output .= '	</span>';
			$output .= '	<div style="clear: left;"></div>';
			$output .= '</div>';
			$output .= '<div class="delucksShareButtonsInnerWrapper">';
			
			#echo "<pre>";
			#print_r($opt['networks']);
			#echo "</pre>";

			
			
			
			if(is_array($opt['networks']) && count(is_array($opt['networks']))){
				$i = 1;
				foreach($opt['networks'] as $network){
					if(!$network['active']){
						continue;
					}

					if($opt['style'] == '52x60'){
						$output .= '	<div class="buttonWrapper">';
						$output .= '	<span class="' . $network['name'] . ' counter '. (!$opt['showcounterspopup'] ? 'hide' : 'show') .'">0</span>';
						$output .=  @include('functions/'.strtolower($network['name']).'.php');
						$output .= '	</div>';
						if($opt['popupcolumns']){
							if($i++ % $opt['popupcolumns'] == 0){
								$output .= '<br/>';
							}
						}
					} else {
						$output .=  @include('functions/'.strtolower($network['name']).'.php');
						if($opt['popupcolumns']){
							if($i++ % $opt['popupcolumns'] == 0){
								$output .= '<br/>';
							}
						}
					}
				}
			}
		
			$output .= '	<div class="delucksShareButtonsLinks"'.(!$this->options['showBranding'] && !$opt['showdataprivacy'] ? ' style="display: none;"' : '').'>';
			$output .= '		<span class="dataPrivacy"'.(!$opt['showdataprivacy'] ? ' style="display: none;"' : '').'><a href="#">'.__('Data privacy', $this->pluginHook).'</a></span>';
			$output .= '		<span class="loveButton"'.(!$this->options['showBranding'] ? ' style="display: none;"' : '').'><a href="'.$this->licenseServer.'" target="_blank">Love Button</a></span>';
			$output .= '	</div>';
			$output .= '	<div class="subscription"'.(!$opt['showdataprivacytextbydefault'] || !$opt['showdataprivacy'] ? ' style="display: none;"' : '').'>';
			$output .= '		<div class="text">'.__('The next click will forward you to a social network, where your IP address might be saved by the provider.', $this->pluginHook).'</div>';
			$output .= '	</div>';
			
			$output .= '</div>'; //inner
			$output .= '</div>'; //outer
			
			return $output;
		}

		/*
		 * get the network counter
		 * */
		function getCounter($network = false, $postId = false){
			if(!strlen($network) || $network == 'false' || $network == false){
				$network = false;
			}

			if(!$postId){
				//get current url if comes from shortcode or option 'shareBasedOnId = 0'
				$url = str_replace(home_url(), '', $_SERVER['HTTP_REFERER']);
				$url = str_replace('http://'.$_SERVER['HTTP_HOST'], '', $url);
				$url = str_replace('//','/', $url);
			} else {
				//get post url
				$postData = get_post($postId);
				if($postData->post_type == 'page'){
					$postPermalink = '/'.trim($postData->post_name).'/';
				} else {
					$postPermalink = get_permalink($postId);
				}

				$url = trim($postPermalink);
				$url = str_replace(home_url(), '', $url);
				$url = str_replace('http://'.$_SERVER['HTTP_HOST'], '', $url);
				$url = str_replace('https://'.$_SERVER['HTTP_HOST'], '', $url).'/';
				$url = str_replace('//','/', $url);
			}			
			
			if(!strlen($url)){
				return false;
			}
			
			$this->installMissingFunctions();
			
			//add or update network count and get the result to return
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);

			$this->checkPermissions();

			if($this->countingAllowed){
				if($network !== false && strlen($network)){
					if(!strlen($network) || $network == false ){
						break;
					}
					$res = $wpdb->get_results("SELECT * FROM `".$wpPrefix.$this->dbTable."` WHERE url = '".$url."'");
					$res = $res[0];
					if(!$res){
						$wpdb->query("INSERT INTO `".$wpPrefix.$this->dbTable."` (url) VALUES ('".$url."')");
					}
					$availableNetworks = $this->availableNetworks;
					$availableNetworks[] = 'internal';
					$wpdb->query("UPDATE `".$wpPrefix.$this->dbTable."` SET `total` = (`".implode('`+`',array_values($availableNetworks))."`+1), `$network` = `$network` +1 WHERE url = '".$url."'");
				}
			}
			$res = $wpdb->get_results( "SELECT * FROM `".$wpPrefix.$this->dbTable."` WHERE url = '".$url."'" );
			$res = $res[0];			

			if(!$res){ return "0"; }
			

			if($network !== false && $this->countingAllowed){
				$this->logClickToStatistic($res->id, $network);
			}
		
			
			//if option 'countInternalLike = 0' hide internal clicks for the frontend
			if(!isset($this->options['countInternalLike']) || !$this->options['countInternalLike']){
				$res->total -= $res->internal;
			}
		
			return $res;
		}
		
		/*
		 * log click for statistics
		 * */
		function logClickToStatistic($id, $network){
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$wpdb->query("INSERT INTO `".$wpPrefix.$this->dbTableStatistics."` (`id`, `network`, `date`, `time`) VALUES ($id, '".$network."', '".date( 'Y-m-d', time() )."', '".date( 'H:i:s', time() )."')");
		}
		
		function xPrint($postId = false){
			if(!$postId || strtolower($postId) == 'print'){
				return false;
			} else {
				$postData = get_post($postId);
			}

			$functionDir = $this->pluginDir.'functions/print/';
			if(!is_readable($functionDir.'template.php')){
				return 'function Print does not exist';
			}
						
			$output =  @include($functionDir.'template.php');
			return $output;
		}
		
		/*
		 * get the statistics
		 * if range is set in backend it will be used 
		 * */
		function getStatistic($dashboardWidget = false){
			if($dashboardWidget !== false){
				$date = 'AND DATE(`date`) > DATE(DATE_SUB(NOW(), INTERVAL 7 day))';
			} else {
				if(isset($this->options['stats']['range'])){
					switch($this->options['stats']['range']){
						case 'today':
							$date = 'AND `date` = CURDATE()';
							break;
						case 'yesterday':
							$date = "AND `date` = DATE_SUB( CONCAT( CURDATE( ) , ' 00:00:00' ) , INTERVAL 1 DAY )";
							break;
						case 'currentWeek':
							$date = "AND YEARWEEK(`date`) = YEARWEEK(CURRENT_DATE)";
							break;
						case 'lastWeek':
							$date = "AND YEARWEEK(`date`) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
							break;
						case 'currentMonth':
							$date = "AND MONTH(`date`) = MONTH(CURRENT_DATE) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
							break;
						case 'lastMonth':
							$date = "AND MONTH(`date`) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(`date`) = YEAR(CURRENT_DATE)";
							break;
						case 'currentYear':
							$date = "AND YEAR(`date`) = YEAR(CURRENT_DATE)";
							break;
						case 'lastYear':
							$date = "AND YEAR(`date`) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR)";
							break;
						default:
							$date = false;
					}
				}
			}
			
			$arr = array();
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$totals = $wpdb->get_results("SELECT * FROM `".$wpPrefix.$this->dbTable."` WHERE ".(isset($this->options['stats']['hideEmpty']) && $this->options['stats']['hideEmpty'] ? '`total` > 0' : '1')." ORDER BY `total` DESC " . (isset($this->options['stats']['limit']) && $this->options['stats']['limit'] > 0 ? 'LIMIT '.$this->options['stats']['limit'] : '' ));
			
			if(count($totals)){
				foreach($totals as $k => $v){
					$arr[$v->id]['totals'] = $v;
				}
			}

			if($arr){
				foreach($arr as $k => $v){
					$sql = "SELECT COUNT(`network`) AS `count`, `network` FROM `".$wpPrefix.$this->dbTableStatistics."` WHERE `id` = $k ";
					if($date !== false){
							$sql .= "$date ";
					}
					if(isset($this->options['stats']['from']) && (strlen($this->options['stats']['from']) || strlen($this->options['stats']['to']))){
						if(strlen($this->options['stats']['from']) && strlen($this->options['stats']['to'])){
							$sql .= "AND `time` BETWEEN '{$this->options['stats']['from']}' AND '{$this->options['stats']['to']}' ";
						} elseif(strlen($this->options['stats']['from']) && !strlen($this->options['stats']['to'])){
							$sql .= "AND `time` >= '{$this->options['stats']['from']}' ";
						} elseif(!strlen($this->options['stats']['from']) && strlen($this->options['stats']['to'])){
							$sql .= "AND `time` <= '{$this->options['stats']['to']}' ";
						}
					}
					$sql .= "GROUP BY `network`";
					
					if($resRange = $wpdb->get_results($sql)){
						$rangeTotal = 0;
						foreach($resRange as $network){
							$arr[$k]['range'][$network->network] =$network->count;
							$rangeTotal += $network->count;
						}
						$arr[$k]['range']['total'] = $rangeTotal;
					} else if(isset($this->options['stats']['hideEmpty']) && $this->options['stats']['hideEmpty']){
						unset($arr[$k]);
					}
				}
			}
			
			return $arr;
		}
		
		/*
		 * get total clicks of a network
		 * */
		function getTotal($network = false){
			if(!$network){
				return false;
			}
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$res = $wpdb->get_var("SELECT SUM(`$network`) as `total` FROM `".$wpPrefix.$this->dbTable."` WHERE 1");
			return $res;
		}
		
		function getStatisticTotal($network = false, $dashboardWidget = false){
			$statistic = $this->getStatistic($dashboardWidget);
			$totals = array();
			
			if(count($statistic)){
				foreach($statistic as $row){
					if(count($row)){
						foreach($row['range'] as $k => $count){
							$totals[$k] += $count;
						}
					}
				}
			}
			
			if($network != false){
				return $totals[$network];
			}
			
			return $totals;
		}
		
		/*
		 * dev only
		 * */
		function migrateStatistic(){
			return;
			global $wpdb;
			$wpPrefix = $wpdb->get_blog_prefix(1);
			$totals = $wpdb->get_results("SELECT * FROM `".$wpPrefix.$this->dbTable."` WHERE ".(isset($this->options['stats']['hideEmpty']) && $this->options['stats']['hideEmpty'] ? '`total` > 0' : '1')." ORDER BY `total` DESC");
			
			if(count($totals)){
				foreach($totals as $row){
					$id = $row->id;
					unset($row->id, $row->url, $row->total);
					if(count($row)){
						foreach($row as $network => $count){
							for($i = 0; $i < $count; $i++){
								$this->logClickToStatistic($id, $network);
							}
						}
					}
				}
			}
		}
		
		/*
		 * get networks clicks for google pie chart
		 * */
		function getPieTotals($dashboardWidget = false){
			$statisticsTotal = (array)$this->getStatisticTotal(false, $dashboardWidget);
			unset($statisticsTotal['internal'], $statisticsTotal['total']);
			return $statisticsTotal;
		}
		
		function getSettings(){
			return $this->options;
		}
		
	}
}


$loveButton = new delucksLoveButton();

include_once('widgets/suggest.php');
include_once('widgets/dashboard.php');


function delucksLoveButtonRegisterWidgets() {
	register_widget('delucksLoveButtonSuggest');
}
add_action('widgets_init', 'delucksLoveButtonRegisterWidgets');











/* OUTPUT BUFFER */
if(isset($loveButton->options['useOgImage']) && $loveButton->options['useOgImage']){

	function getMetaImage($img){
		if (empty( $img )){
			return false;
		}
	
		$img = trim($img);
		if (!empty( $img )){
			if (strpos($img, 'http') !== 0) {
				if ($img[0] != '/'){
					return false;
				}
	
				$parsed_url = parse_url(home_url());
				$img        = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $img;
			}
			return "<meta property=\"og:image\" content=\"" . esc_url( $img ) . "\" />\n";
		}
	}

	function loveButtonBufferCallback($buffer) {
		global $loveButton;
		$buffer = preg_replace("/<meta property=('|\")og:image('|\") content=('|\")(.*?)('|\")(.*)\/>/", '', $buffer);
		
		if (preg_match_all('/<img [^>]+>/', $buffer, $matches)) {
			foreach ( $matches[0] as $img ) {
				if(strpos($img, 'social-network-dont-share')){ /* skip images marked up by toolbar button */
					continue;
				}

				if (preg_match( '/src=("|\')(.*?)\1/', $img, $match)){
					if(file_exists($file = $_SERVER['DOCUMENT_ROOT'].str_replace(home_url(), '', $match[2]))){
						$imageInfo = getimagesize($file);
						
						if(isset($loveButton->options['useOgImageWidth']) && !empty($loveButton->options['useOgImageWidth']) && $imageInfo[0] < $loveButton->options['useOgImageWidth']){
							continue;
						}
						
						if(isset($loveButton->options['useOgImageHeight']) && !empty($loveButton->options['useOgImageHeight']) && $imageInfo[1] < $loveButton->options['useOgImageHeight']){
							continue;
						}
		
						$images[] = $match[2];
					}
				}
			}
		}
		
		$metaImages = array();
		if(count($images)){
			foreach($images as $image){
				$metaImages[] = getMetaImage($image);
			}
		}

		return join("", $metaImages) . $buffer;
	}
	
	function loveButtonBufferStart() {
		ob_start("loveButtonBufferCallback");
	}
	
	function loveButtonBufferEnd() {
		ob_end_flush();
	}
	
	add_action('wp_head', 'loveButtonBufferStart', -1000000);
	add_action('wp_footer', 'loveButtonBufferEnd');
}


?>