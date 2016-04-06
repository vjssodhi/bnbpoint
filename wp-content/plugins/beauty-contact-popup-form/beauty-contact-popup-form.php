<?php
/*
Plugin Name: Beauty Contact Popup Form
Description: It is an simple and Beautiful contact popup form, with simple backend options. All you need is just to activate the plugin and insert the shortcode  [show_tagwebs_beauty_contact_popup_form id="1"] into the text. This is the plugin for contacting the admin of website which allow users to send email. This plugin built with mobile responsive.
Version: 6.0
Author: Dilip kumar
Plugin URI: http://demo.uholder.com/plugin/beauty-contact-popup-form/
Author URI: http://www.uholder.com/
License: GPL2
*/

function TagPopup()

	{
		
		$categories = get_terms( 'job_listing_category' );
		foreach($categories as $category){ 
           // print('<pre>'); print_r($category); print('</pre>'); die;
		}		
		?>
<a href='javascript:TagPopup_OpenForm("TagPopup_FormContainer","TagPopup_FormContainerBody","TagPopup_FormContainerFooter");'><?php echo get_option('TagPopup_ButtonLink'); ?></a>
<div style="display: none;" id="TagPopup_FormContainer">
  <div id="TagPopup_FormContainerHeader">
    <div id="TagPopup_FormTitle"><?php echo get_option('TagPopup_title'); ?></div>
    <div id="TagPopup_FormClose"><a href="javascript:TagPopup_HideForm('TagPopup_FormContainer','TagPopup_FormContainerFooter');"><?php _e('Close', 'tag-popup'); ?></a></div>
  </div>
  <div id="TagPopup_FormContainerBody">
    <form action="#" name="TagPopup_Form" id="TagPopup_Form">
      <div id="TagPopup_FormAlert"> <span id="TagPopup_alertmessage"></span> </div>
      <div id="TagPopup_FormLabel"> <?php _e('Please Select the service that you required', 'tag-popup'); ?> </div>
      <div id="TagPopup_FormLabel">
	   <select id="TagPopup_cat" name="TagPopup_cat"><?php foreach($categories as $category){ 
	   ?>
         <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
	  <?php } ?></select>
      </div>
      <div id="TagPopup_FormLabel"> <?php _e('Please select the date and time you wish to inquire below', 'tag-popup'); ?> </div>
      <div id="TagPopup_FormLabel">
        <select id="TagPopup_start" class="inq_date_time" name="TagPopup_start">
              <option value="volvo">Volvo</option>
			  <option value="saab">Saab</option>
			  <option value="vw">VW</option>
			  <option value="audi" selected>Audi</option>
	   </select>
	    <select id="TagPopup_end" class="inq_date_time" name="TagPopup_end">
              <option value="volvo">Volvo</option>
		      <option value="saab">Saab</option>
		      <option value="vw">VW</option>
		      <option value="audi" selected>Audi</option>
	   </select>
	   <input type="date" id="bday" name="bday" class="inq_date_time1" style="width: 40%;margin-left: 8px;">
      </div>
      <div id="TagPopup_FormLabel"> <?php _e('Select Number of kids and age below', 'tag-popup'); ?> </div>
      <div id="TagPopup_FormLabel">
        <select id="TagPopup_kids" class="inq_kid" name="TagPopup_kids">
		      <option value="none">Select</option>
              <option value="1">1 Kid</option>
			  <option value="2">2 Kids</option>
			  <option value="3">3 Kids</option>
			  <option value="4" selected>4 Kids</option>
			  <option value="5">5 Kid</option>
			  <option value="6">6 Kids</option>
			  <option value="7">7 Kids</option>
			  <option value="8">8 Kids</option>
	   </select>
	    <select id="TagPopup_year" class="inq_kid" name="TagPopup_year">
              <option value="none">Select</option>
              <option value="1">1 yr</option>
			  <option value="2">2 yrs</option>
			  <option value="3">3 yrs</option>
			  <option value="4" selected>4 yrs</option>
			  <option value="5">5 yrs</option>
			  <option value="6">6 yrs</option>
			  <option value="7">7 yrs</option>
			  <option value="8">8 yrs</option>
	   </select>
	   <select id="inquiry_year1" class="inq_kid">
              <option value="none">Select</option>
              <option value="1">1 yr</option>
			  <option value="2">2 yrs</option>
			  <option value="3">3 yrs</option>
			  <option value="4" selected>4 yrs</option>
			  <option value="5">5 yrs</option>
			  <option value="6">6 yrs</option>
			  <option value="7">7 yrs</option>
			  <option value="8">8 yrs</option>
	   </select>
	   <select id="inquiry_year2" class="inq_kid">
              <option value="none">Select</option>
              <option value="1">1 yr</option>
			  <option value="2">2 yrs</option>
			  <option value="3">3 yrs</option>
			  <option value="4" selected>4 yrs</option>
			  <option value="5">5 yrs</option>
			  <option value="6">6 yrs</option>
			  <option value="7">7 yrs</option>
			  <option value="8">8 yrs</option>
	   </select>
      </div>
      <div id="TagPopup_FormLabel">
        <input type="button" name="button" class="TagPopup_Button" value="Submit" onClick="javascript:TagPopup_Submit(this.parentNode,'<?php echo home_url(); ?>');">
      </div>
    </form>
  </div>
</div>
<div style="display: none;" id="TagPopup_FormContainerFooter"></div>
<?php
	
}

function TagPopup_install() 
{
	global $wpdb, $wp_version;
	add_option('TagPopup_title', "Inquiry Form");
	add_option('TagPopup_FormTitle', "Inquiry Us");
	add_option('TagPopup_fromemail', "no-reply-beauty-popup@tagwebs.in");
	add_option('TagPopup_On_SendEmail', "YES");
	add_option('TagPopup_On_MyEmail', "Enter your mail address to receive mails");
	add_option('TagPopup_On_Subject', "Enter the email subject which you like to receive");
	add_option('TagPopup_On_Captcha', "YES");
	add_option('TagPopup_ButtonLink', "<img src='".get_option('siteurl')."/wp-content/plugins/beauty-contact-popup-form/inc/img/contact-tag1.png' />");
	$url = home_url();
	add_option('TagPopup_homeurl', $url);
}

function TagPopup_widget($args) 
{
	
	$title = get_option('TagPopup_title');

		extract($args);
	    echo $before_widget;
		TagPopup();
		echo $after_widget;

}
	
function TagPopup_control() 
{
	echo '<p>';
	_e('Use shortcode to display the form in posts or pages. Now the Beauty Contact Form link is displayed in the sidebar. For Demo', 'tag-popup');
	?> <a target="_blank" href="http://demo.uholder.com/plugin/beauty-contact-popup-form/"><?php _e('click here', 'tag-popup'); ?></a></p><?php
}

function TagPopup_sidewidget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget( __('Tagwebs Popup Form', 'tag-popup'), __('Tagwebs Popup Form', 'tag-popup'), 'TagPopup_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control( __('Tagwebs Popup form', 'tag-popup'), array(__('Tagwebs Popup form', 'tag-popup'), 'widgets'), 'TagPopup_control');
	} 
}

function TagPopup_deactivation() 
{
	// No action required.
}

function TagPopup_admin()
{
	global $wpdb;
	include('tag-setting.php');
}

function TagPopup_add_to_menu() 
{
	add_menu_page('Tagwebs contact popup form', 'B Popup form', 'manage_options', 'tag-popup', 'TagPopup_admin',plugins_url('inc/img/icon.png', __FILE__));
}

if (is_admin()) 
{
	add_action('admin_menu', 'TagPopup_add_to_menu');
}

/* adding css and js file */
function TagPopup_add_javascript_files() 
{

	if (!is_admin())
	{
		wp_enqueue_style( 'tag-popup-form', get_option('siteurl').'/wp-content/plugins/beauty-contact-popup-form/inc/beauty-contact-popup-form.css');
		wp_enqueue_script( 'tag-popup-form', get_option('siteurl').'/wp-content/plugins/beauty-contact-popup-form/inc/beauty-contact-popup-form.js');
		wp_enqueue_script( 'tag-popup-popup', get_option('siteurl').'/wp-content/plugins/beauty-contact-popup-form/inc/beauty-contact-popup.js');
	}
}   
/* ending css and js file */

function TagPopup_shortcode( $atts ) 
{
	//shortcode [show_tagwebs_beauty_contact_popup_form id="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	
	$id = $atts['id'];
	$title = $atts['title'];
	$TagPopup_FormTitle =  get_option('TagPopup_FormTitle');
	$TagPopup_ButtonLink = get_option('TagPopup_ButtonLink');
	$TagPopup_title = $title;
	$siteurl = "'". home_url() . "'";
	$close = "javascript:TagPopup_HideForm('TagPopup_FormContainer','TagPopup_FormContainerFooter');";
	$open = 'javascript:TagPopup_OpenForm("TagPopup_FormContainer","TagPopup_FormContainerBody","TagPopup_FormContainerFooter");';
/* caption sum two numbers start */	
	$tagnumber1 = rand(1,9);
	$tagnumber2 = rand(1,9);
	$tagsum = $tagnumber1 + $tagnumber2;
/* caption sum two numbers start */	
	
	$html = "<a href='".$open."'>".$TagPopup_ButtonLink."</a>";
	$html .= '<div style="display: none;" id="TagPopup_FormContainer">';
	  $html .= '<div id="TagPopup_FormContainerHeader">';
	  		$html .= '<div id="TagPopup_FormClose"><a href="'.$close.'">'.__('X', 'tag-popup').'</a></div>';
		 $html .= '<div id="TagPopup_FormTitle"> '.__('', 'tag-popup').' '.$TagPopup_FormTitle.' ';
		   $html .= '</div>';
	  $html .= '</div>';
	  $html .= '<div id="TagPopup_FormContainerBody">';
		$html .= '<form action="#" name="TagPopup_Form" id="TagPopup_Form">';
		  $html .= '<div id="TagPopup_FormAlert"> <span id="TagPopup_alertmessage"></span> </div>';
		  $html .= '<div id="TagPopup_FormLabel_Page">';
			$html .= '<input name="TagPopup_name" class="TagPopup_TextForm" type="select" id="TagPopup_name" Placeholder="Your Name" maxlength="120">';
		  $html .= '</div>';
		  $html .= '<div id="TagPopup_FormLabel_Page">';
			$html .= '<input name="TagPopup_mail" class="TagPopup_TextForm" type="text" id="TagPopup_mail"  Placeholder="Your Email" maxlength="120">';
		  $html .= '</div>';
		  $html .= '<div id="TagPopup_FormLabel_Page">';
			$html .= '<textarea name="TagPopup_message" class="TagPopup_TextArea" rows="3" id="TagPopup_message"  Placeholder="Enter Your Message"></textarea>';
		  $html .= '</div>';
		   $html .= '<input type="hidden" id="TagCorrectsum" name="TagCorrectsum" value="'.$tagsum.'"/>';
		  $html .= '<div id="TagPopup_FormLabel_Page" class="TagPopup_Human" > '.__('Verify Human:', 'tag-popup').' '.$tagnumber1.' + '.$tagnumber2.' = ';
		   $html .= '</div>';
			$html .= '<input name="TagPopup_captcha" class="TagPopup_TextForm" type="text" id="TagPopup_captcha"  Placeholder="Enter the sum eg: 1+1=2" maxlength="120">';
		  $html .= '<div id="TagPopup_FormLabel_Page">';
			$html .= '<input type="button" name="button" class="TagPopup_Button" value="Submit" onClick="javascript:TagPopup_Submit(this.parentNode,'.$siteurl.');">';
		  $html .= '</div>';
		$html .= '</form>';
	  $html .= '</div>';
	$html .= '</div>';
	$html .= '<div style="display: none;" id="TagPopup_FormContainerFooter"></div>';
	
	return $html;
	
}

function TagPopup_plugin_query_vars($vars) 
{
	$vars[] = 'tagpopup';
	return $vars;
}

function TagPopup_plugin_parse_request($qstring)
{
	
	//print('<pre>'); print_r($qstring); print('</pre>'); die("here");
	if (array_key_exists('tagpopup', $qstring->query_vars)) 
	{
		$page = $qstring->query_vars['tagpopup'];
		switch($page)
		{
			case 'send-mail':				
				$TagPopup_name = isset($_POST['TagPopup_name']) ? $_POST['TagPopup_name'] : '';
				$TagPopup_mail = isset($_POST['TagPopup_mail']) ? $_POST['TagPopup_mail'] : '';
				if($TagPopup_mail <> "")
				{
					if (!filter_var($TagPopup_mail, FILTER_VALIDATE_EMAIL))
					{
						echo "invalid-email";
					}
					else
					{
						$homeurl = get_option('TagPopup_homeurl');
						if($homeurl == "")
						{
							$homeurl = home_url();
						}
						
						$samedomain = strpos($_SERVER['HTTP_REFERER'], $homeurl);
						if (($samedomain !== false) && $samedomain < 5) 
						{
							$TagPopup_message = stripslashes($_POST['TagPopup_message']);
							$TagPopup_On_MyEmail = stripslashes(get_option('TagPopup_On_MyEmail'));
							$TagPopup_On_Subject = stripslashes(get_option('TagPopup_On_Subject'));
	
							$sender_mail = esc_sql(trim($TagPopup_mail));
							$sender_name = esc_sql(trim($TagPopup_name));
							$subject = $TagPopup_On_Subject;
							$message = $TagPopup_message;
							
							$headers = "MIME-Version: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
							$headers .= "From: \"$sender_name\" <$sender_mail>\n";
							$headers .= "Return-Path: <" . esc_sql(trim($TagPopup_mail)) . ">\n";
							$headers .= "Reply-To: \"" . esc_sql(trim($TagPopup_name)) . "\" <" . esc_sql(trim($TagPopup_mail)) . ">\n";
							$mailtext = str_replace("\r\n", "<br />", $message);
							@wp_mail($TagPopup_On_MyEmail, $subject, $mailtext, $headers);
		
							echo "mail-sent-successfully";
						}
						else
						{
							echo "there-was-problem";
						}
					}
				}
				else
				{
					echo "empty-email";
				}
				die();
				break;		
		}
	}
}

add_action('parse_request', 'TagPopup_plugin_parse_request');
add_filter('query_vars', 'TagPopup_plugin_query_vars');
add_shortcode( 'show_tagwebs_beauty_contact_popup_form', 'TagPopup_shortcode' );
add_action('wp_enqueue_scripts', 'TagPopup_add_javascript_files');
add_action("plugins_loaded", "TagPopup_sidewidget_init");
register_activation_hook(__FILE__, 'TagPopup_install');
register_deactivation_hook(__FILE__, 'TagPopup_deactivation');
add_action('init', 'TagPopup_sidewidget_init');
?>