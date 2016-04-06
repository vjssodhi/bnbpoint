<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	//exit; // Exit if accessed directly
}

wc_print_notices(); 


 global $userdata,$wpdb,$post;
 
 $current_user = wp_get_current_user();
 $user_current_id = $current_user->ID;
 
 $results = $wpdb->get_results("SELECT * FROM wp_dmfw_usercare where user_current_id = '".$user_current_id."'", OBJECT );
                
 //print_r($results);
 echo $result->address;

?>

<div class="myaccount">
	<div class="myaccount__flex clearfix">
		<div class="myaccount__avatar">
			<?php global $userdata; get_currentuserinfo(); echo get_avatar( $userdata->ID, 200 )."</br>"; 
			
			?>
			<p><?php 
		
		printf(
				$current_user->display_name,
				wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
			);
			
		
		?></p>
		</div>
		
		<div class="myaccount__content">
			<?php
			printf(
				__( 'Hello <strong>%1$s</strong>!', 'woocommerce' ) . ' ',
				$current_user->display_name,
				wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) )
			);

			printf( __( 'From your account dashboard you can view & control all function of your account', 'woocommerce' ),
				wc_customer_edit_account_url()
			);
			?>
		</div>
	</div>
	<div class="addresses">

	<div class="addresses__description">
		<h2>Profile Type</h2>
		<p class="myaccount_address">
			Dual Profile(for babbysitter & parents or families)	</p>
	</div>

			<div class="addresses__description">
		<h2>Booking Inquires</h2>
		<p class="myaccount_address">
			No booking inquires yet!	</p>
	</div>
	</div>
	<div class="clear"></div>
<div class="addresses">

	<div class="addresses__description">
		<h2>Booking I Made</h2>
		<p class="myaccount_address">
			I din't make any booking yet!</p>
	</div>

			<div class="addresses__description">
		<h2>My Booking Appointments</h2>
		<p class="myaccount_address">
			I dont Have any booking appointments yet	</p>
	</div>
	</div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>Help Center</h2>
		<p class="myaccount_address">
			<a href="#">Click here to view</a>		</p>
	</div>

			<div class="addresses__description">
		<h2>Who Viewed My Profile</h2>
		<p class="myaccount_address">
			<a href="#">Click here to view</a>			</p>
	</div>
	</div><div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>My Social Login Accounts</h2>
		<p class="myaccount_address">
			<a href="#">onnect one now</a>			</p>
	</div>

			<div class="addresses__description">
		<h2>Who I Viewed</h2>
		<p class="myaccount_address">
			<a href="#">Click here to view</a>			</p>
	</div>
	</div><div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>My Address</h2>
		<p class="myaccount_address">
			<a href="#">Edit Now</a>			</p>
	</div>

			<div class="addresses__description">
		<h2>My Listing</h2>
		<p class="myaccount_address">
			<a href="/listings-dashboard/">Click here to view</a>			</p>
	</div>
	</div><div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>My E-mail Address</h2>
		<p class="myaccount_address">
			<?php echo $current_user->user_email; ?> <a href="#">Edit Now</a>			</p>
	</div>

			<div class="addresses__description">
		<h2>My Favourites</h2>
		<p class="myaccount_address">
			<a href="#">Click here to view</a>			</p>
	</div>
	</div><div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>Post an Ad</h2>
		<p class="myaccount_address">
			<a href="/self/add-listing/">Click here post your Ad</a>			</p>
	</div>

			<div class="addresses__description">
		<h2>Edit Profile</h2>
		<p class="myaccount_address">
			<a href="/self/my-account/edit-account/">Click here to edit</a>			</p>
	</div>
	</div><div>
	<div class="clear"></div>
	<div class="addresses">
	<div class="addresses__description">
		<h2>Change password</h2>
		<p class="myaccount_address">
			<a href="#">Click to change password</a>			</p>
	</div>

			<div class="addresses__description">
		<h2>Resolution Center</h2>
		<p class="myaccount_address">
			<a href="#">Click here to visit</a>		</p>
	</div>
	</div><div>
	<div class="clear"></div>
</div>

<?php //do_action( 'woocommerce_before_my_account' ); ?>

<?php //wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php //wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php //wc_get_template( 'myaccount/my-address.php' ); ?>

<?php //do_action( 'woocommerce_after_my_account' ); ?>
