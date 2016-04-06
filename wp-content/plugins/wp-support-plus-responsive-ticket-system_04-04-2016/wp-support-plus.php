<?php 
/**
 * Plugin Name: WP Support Plus
 * Plugin URI: https://wordpress.org/plugins/wp-support-plus-responsive-ticket-system/
 * Description: Easy to use Customer Support System in Wordpress itself!
 * License: GPL v3
 * Version: 7.0.2
 * Author: pradeepmakone07
 * Author URI: http://profiles.wordpress.org/pradeepmakone07/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlus{
	public function __construct() {
            $this->define_constants();
            register_activation_hook( __FILE__, array($this,'installation') );
            $this->installation();
            $this->include_files();
            
            if (!wp_next_scheduled('wpsp_offer_and_update_checker')) {
                wp_schedule_event(time(), 'daily', 'wpsp_offer_and_update_checker');
            }
            add_action( 'wpsp_offer_and_update_checker', array( $this, 'check_offer_and_update'));
	}
		
	private function define_constants() {
		define( 'WCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'WCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'WPSP_VERSION', '7.0.2' );
	}
        
        function check_offer_and_update(){
            $siteDataWPSP = file_get_contents('http://pradeepmakone.com/wp_support_plus_update_and_offers.txt');
            $wpsp_update_notice=array(
                'text'=>$siteDataWPSP
            );
            update_option('wpsp_update_notice_txt_time',$wpsp_update_notice);
        }

        private function include_files(){
		if (is_admin()) {
			include_once( WCE_PLUGIN_DIR.'includes/admin/admin.php' );
			include_once( WCE_PLUGIN_DIR.'includes/admin/ajax.php' );
			$ajax=new SupportPlusAjax();
			add_action( 'wp_ajax_createNewTicket', array( $ajax, 'createNewTicket' ) );
			add_action( 'wp_ajax_nopriv_createNewTicket', array( $ajax, 'createNewTicket' ) );
			add_action( 'wp_ajax_getTickets', array( $ajax, 'getTickets' ) );
			add_action( 'wp_ajax_getFrontEndTickets', array( $ajax, 'getFrontEndTickets' ) );
			add_action( 'wp_ajax_openTicket', array( $ajax, 'openTicket' ) );
			add_action( 'wp_ajax_openTicketFront', array( $ajax, 'openTicketFront' ) );
			add_action( 'wp_ajax_replyTicket', array( $ajax, 'replyTicket' ) );
			add_action( 'wp_ajax_getAgentSettings', array( $ajax, 'getAgentSettings' ) );
			add_action( 'wp_ajax_setAgentSettings', array( $ajax, 'setAgentSettings' ) );
			add_action( 'wp_ajax_getGeneralSettings', array( $ajax, 'getGeneralSettings' ) );
			add_action( 'wp_ajax_setGeneralSettings', array( $ajax, 'setGeneralSettings' ) );
			add_action( 'wp_ajax_getCategories', array( $ajax, 'getCategories' ) );
			add_action( 'wp_ajax_createNewCategory', array( $ajax, 'createNewCategory' ) );
			add_action( 'wp_ajax_updateCategory', array( $ajax, 'updateCategory' ) );
			add_action( 'wp_ajax_deleteCategory', array( $ajax, 'deleteCategory' ) );
			add_action( 'wp_ajax_getEmailNotificationSettings', array( $ajax, 'getEmailNotificationSettings' ) );
			add_action( 'wp_ajax_setEmailSettings', array( $ajax, 'setEmailSettings' ) );
                        add_action( 'wp_ajax_deleteTicket', array( $ajax, 'deleteTicket' ) );
		}
		else {
 			include_once( WCE_PLUGIN_DIR.'includes/shortcode.php' );
 			include_once( WCE_PLUGIN_DIR.'includes/support_button.php' );
		}
	}
	
	function installation(){
		include_once( WCE_PLUGIN_DIR.'includes/admin/installation.php' );
	}
}

$GLOBALS['WPSupportPlus'] =new WPSupportPlus();
?>
