<?php
/**
 * Template Name: Account Settings
 *
 * @package Listable
 * @since Listable 1.2.5
 */

if(isset($_POST)){
	$user_ = wp_get_current_user();
	$user = get_user_by( 'login', $user_->user_login );
	$user_current_id = $user->ID;
	foreach ($_POST as $key => $value) {		
		if($key == "privacy_option"){
			$privacy_option = implode(',', $value);
			update_user_meta( $user_current_id, 'privacy_option', $privacy_option, $prev_value );
		}elseif ($key == "mailing_options") {
			$mailing_options = implode(',', $value);
			update_user_meta( $user_current_id, 'mailing_options', $mailing_options, $prev_value );
		}elseif($key == 'account_status'){
			update_user_meta( $user_current_id, $key, $value, $prev_value );			
		}		
	}
	$pass = $_POST['current_pass'];
	if ( $user && wp_check_password( $pass, $user->data->user_pass, $user->ID) )
	   wp_set_password( $_POST['new_pass'], $user->ID );	
	   
}
$results = get_user_meta($user_current_id);
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        	<div class="entry-content"><form action="" method="POST" onsubmit="return save_details()">
		    	<div class="blocked_members">
		           <span class="card__title">Managed Blocked Members</span><br>		    		
		           <a href="#">View blocked members</a>
		    	</div><br>
		    	<div class="blocked_members">
		           <span class="card__title">Privacy Options</span><br>
		           <div><input type="checkbox" name="privacy_option[]" <?php if(in_array(1, $results['privacy_option'])){ echo 'checked'; }?> value="1"/> Allow Google, Bing and other search engines to index my profile for their search results (recommended)</div>
		           <div><input type="checkbox" name="privacy_option[]" <?php if(in_array(2, $results['privacy_option'])){ echo 'checked'; }?>value="2"/> Show my age in my profile page on Irishacare.ie (recommended)</div>
		    	</div>
		    	<br>
		    	<div class="blocked_members">
		           <span class="card__title">Mailing Options</span><br>
		           I would like to recive mail notifications when:
		           <div><input type="checkbox" name="mailing_options[]" <?php if(in_array(1, $results['mailing_options'])){ echo 'checked'; }?>value="1"/> I receive a new message</div>
		           <div><input type="checkbox" name="mailing_options[]" <?php if(in_array(2, $results['mailing_options'])){ echo 'checked'; }?>value="2"/> Someone adds me in their favourites.</div>
		           <div><input type="checkbox" name="mailing_options[]" <?php if(in_array(3, $results['mailing_options'])){ echo 'checked'; }?>value="3"/> Someone view my profile.</div>
		    	</div>
		    	<br>
		    	<div class="blocked_members">
		           <span class="card__title">Accounts Status</span><br>		           
		           <div><input type="radio" name="account_status" value="1"/> Active (Current Status)</div>
		           <div><input type="radio" name="account_status" value="1"/> Inactive.</div>
		    	</div>
		    	<br>
		    	<div class="blocked_members">
		           <span class="card__title">Closed Your Account</span><br>		           
		           <div><input type="checkbox" name="user_status" value="1"/> Close my account</div>
		           <p>Please make sure you have any services booked on your account.</p>
		    	</div>
		    	<br>
		    	<div class="blocked_members">
		           <span class="card__title">Password Change</span><br>		           
		           <div><input type="password" name="current_pass" placeholder="Type your current password"/></div><br>
		           <div class="grid__item  grid__item--widget"><input type="password" name="new_pass" id="new_pass" placeholder="Type new password"/></div>
		           <div class="grid__item  grid__item--widget"><input type="password" name="renew_pass" id="renew_pass" placeholder="Re-Type new password"/></div><br><br>
		           <div class="grid__item "><p class="err_" style="display: none; color: red;">Password didn't matched</p></div>
		           <div class="grid__item  grid__item--widget"><input type="submit" value="Save changes"/></div>
		    	</div></form>
           </div>
        </main>
        <!-- #main -->
    </div>
    <!-- #primary -->
    <?php
	get_sidebar();
	get_footer();
	?>
	<script type="text/javascript">
		function save_details(){						
			if(jQuery("#new_pass").val() == jQuery("#renew_pass").val()){
				return true;
			}else{
				jQuery(".err_").show();
				return false;
			}
		}
	</script>