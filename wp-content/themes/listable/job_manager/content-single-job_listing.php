<?php
/**
 * The template for displaying the WP Job Manager listing details on single listing pages
 *
 * @package Listable
 */
 

global $userdata;
get_currentuserinfo();


global $post;

$taxonomies = array();
$data_output = '';
$terms = get_the_terms(get_the_ID(), 'job_listing_type');
$termString = '';
if ( is_array($terms) || is_object($terms) ) {
	$firstTerm = $terms[0];
	if ( ! $firstTerm == NULL ) {
		$term_id = $firstTerm->term_id;

		$data_output .= 'data-icon="' . listable_get_term_icon_url($term_id) .'"';
		$count = 1;
		foreach ( $terms as $term ) {
			$termString .= $term->name;
			if ( $count != count($terms) ) {
				$termString .= ', ';
			}
			$count++;
		}
	}
}

$listing_is_claimed = false;
if ( class_exists( 'WP_Job_Manager_Claim_Listing' ) ) {
	$classes = WP_Job_Manager_Claim_Listing()->listing->add_post_class( array() );

	if ( isset( $classes[0] ) && ! empty( $classes[0] ) ) {
		if ( $classes[0] == 'claimed' )
			$listing_is_claimed = true;
	}
} ?>

<div class="single_job_listing"
	data-latitude="<?php echo get_post_meta($post->ID, 'geolocation_lat', true); ?>"
	data-longitude="<?php echo get_post_meta($post->ID, 'geolocation_long', true); ?>"
	data-categories="<?php echo $termString; ?>"
	<?php echo $data_output; ?>>
<?php //print('<pre>'); print_r($post->post_author); print('</pre>'); ?>
	<?php if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) : ?>
		<div class="job-manager-info"><?php esc_html_e( 'This listing has expired.', 'listable' ); ?></div>
	<?php else : ?>
		<div class="grid">
			<div class="grid__item  column-content  entry-content">
				<header class="entry-header">
					<nav class="single-categories-breadcrumb">
						<a href="<?php echo listable_get_listings_page_url(); ?>"><?php esc_html_e( 'Listings', 'listable' ); ?></a> >>
						<?php
						$term_list = wp_get_post_terms(
							$post->ID,
							'job_listing_category',
							array(
								"fields" => "all",
								'orderby' => 'parent',
							)
						);

						if ( ! empty( $term_list ) && ! is_wp_error( $term_list ) ) {
							// @TODO make them order by parents
							foreach ( $term_list as $key => $term ) {
								echo '<a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a>';
								if ( count( $term_list ) - 1 !== $key ) {
									echo ' >>';
								}
							}
						} ?>
					</nav>

					<h1 class="entry-title" itemprop="name"><?php
						echo get_the_title();
						if ( $listing_is_claimed ) :
							echo '<span class="listing-claimed-icon">';
							get_template_part('assets/svg/checked-icon');
							echo '<span>';
						endif;
					?></h1>
						<?php
                    $user_info = get_user_meta($post->post_author);
                    //print('<pre>'); print_r($term_list); print('</pre>');
                    //print('<pre>'); print_r($user_info); print('</pre>');
					?>
					
					<?php the_company_tagline( '<span class="entry-subtitle" itemprop="description">', '</span>' ); ?>
					<?php
//$user_id = 1;
$awesome_level = $post->post_author;
$user_id = wp_get_current_user();
?>
					<?php if($user_info['usertype'][0] == 'looking_services'){ ?>
						<div class="user_data">
                            <div class="user_image"><img src="<?php if($user_info['user_image'][0]){ echo $user_info['user_image'][0];}else{echo "http://localhost/irishcare/wp-content/themes/listable/images/avtar.jpg";};?>" alt="Smiley face" height="" width="90"> <?php echo $user_info['nickname'][0];?></div>
						    <div class="user_action_button1">  
							  <div class="btn_blk_1"> 
							    <a class="button-primary" href="#">Verify</a>
								<?php
       if(isset($_POST['submit']))
         {
         wp_mail('reena.chandel25@gmail.com', 'TEST', 'Should only send once.');
        } 
               ?>

      <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
       This page is to test the double get/post. Here 3.
         <input type="submit" name="submit" value="send email" />
        </form>
			<a class="button-primary" onclick="<?php send_AJAX_mail_before_submit(); ?>" href="#">Like this Job</a>
						     <!--<a class="button-primary" href="#">Like This Job</a>--><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;"></iframe>
										
	                             <!--   <div class="facebook_like_button_holder">

										<div class="fb-like" data-href="<?php //echo get_permalink(); ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true"></div>

									</div> -->
                                
	
							  </div>  
							    <div class="btn_blk_1">
								<a class="button-primary" href="<?php add_user_meta( $user_id, 'blocked_user', $awesome_level);  ?>">Block</a>
								<a class="button-primary" href="#">Report</a>
							  </div> 
							</div>
					    </div> 
						
						
					<?php }else{  ?>
                    <div class="user_data">
                        <div class="user_image"><img src="<?php if($user_info['user_image'][0]){ echo $user_info['user_image'][0];}else{echo "http://localhost/irishcare/wp-content/themes/listable/images/avtar.jpg";};?>" alt="Smiley face" height="" width="90"> <?php echo $user_info['nickname'][0];?></div>
                      <div class="user_action_button">  <div class="btn_blk_1"> 
					   <button type="button" style="color:white;"><?php TagPopup(); ?></button>
					   <button type="button">Like This Job</button></div>  
						
						<div class="btn_blk_1"><button type="button">Block</button>  <button type="button">Report</button></div> </div>
					</div> 
					<?php }
					/**
					 * single_job_listing_start hook
					 *
					 * @hooked job_listing_meta_display - 20
					 * @hooked job_listing_company_display - 30
					 */
					
					//do_action( 'single_job_listing_start' );
					//$categories = get_terms( 'job_listing_category' );
					//print('<pre>'); print_r($categories); print('</pre>');
					//html_form_code();
					//echo add_shortcode( 'sitepoint_contact_form', 'cf_shortcode' );
					?>
				     
					<div class="social_block"><div class="social_block1"><?php echo do_shortcode('[love-button]'); ?></div><div class="social_block1"><div id="fb-root"></div>
                      <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                      <fb:like href="<?php echo get_permalink(); ?>" show_faces="true" width="450"></fb:like>
                    </div></div>
					
                    <div class="social_block2">
                     <?php //echo really_simple_share_publish($link='http://connect.facebook.net', $title='this is testing'); 
					// echo really_simple_share_publish(get_bloginfo('url'), get_bloginfo('name'));?>
					</div>   
</header><!-- .entry-header -->
				<?php if ( is_active_sidebar( 'listing_content' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--main">
						<?php dynamic_sidebar('listing_content'); ?>
					</div>
				<?php endif; ?>
			</div> <!-- / .column-1 -->

			<div class="grid__item  column-sidebar">
				<?php if ( is_active_sidebar( 'listing__sticky_sidebar' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--top  listing-sidebar--secondary">
						<?php dynamic_sidebar('listing__sticky_sidebar'); ?>
					</div>
				<?php endif; ?>
                     <div class="listing-sidebar  listing-sidebar--bottom  listing-sidebar--secondary">
					<?php _e('Last login ','appthemes'); ?></br> <?php echo appthemes_get_last_login($userdata->ID); ?>
						
					</div>
				<?php if ( is_active_sidebar( 'listing_sidebar' ) ) : ?>
					<div class="listing-sidebar  listing-sidebar--bottom  listing-sidebar--secondary">
						<?php dynamic_sidebar('listing_sidebar'); ?>
					</div>
				<?php endif; ?>

			</div><!-- / .column-2 -->
		</div>
	<?php endif; ?>
</div>
