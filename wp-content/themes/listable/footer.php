<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Listable
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
			<div id="footer-sidebar" class="footer-widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-widget-area' ); ?>
			</div><!-- #primary-sidebar -->
		<?php endif; ?>
		<div class="footer-text-area">
			<div class="site-info">
				<?php
				$footer_copyright = listable_get_option('footer_copyright');
				if ( $footer_copyright ) : ?>
					<div class="site-copyright-area">
						<?php echo $footer_copyright; ?>
					</div>
				<?php endif; ?>
				<?php
				$args = array(
					'theme_location'  => 'footer_menu',
					'container'       => '',
					'container_class' => '',
					'menu_class'      => 'footer-menu',
					'depth'           => 1,
					'fallback_cb'     => null,
				);
				wp_nav_menu( $args );
				?>
			</div><!-- .site-info -->
			<div class="theme-info">
				<a href="<?php echo esc_url( esc_html__( 'https://wordpress.org/', 'listable' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'listable' ), 'WordPress' ); ?></a>
				<span class="sep"> <?php _e( 'and', 'listable' ) ?> </span>
				<?php printf( esc_html__( '%1$s by %2$s.', 'listable' ), '<a href="http://themeforest.net/item/listable-a-friendly-directory-wordpress-theme/13398377?ref=pixelgrade" rel="theme">Listable</a>', '<a href="https://pixelgrade.com/" rel="designer">PixelGrade</a>' ); ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div class="hide">
	<div class="arrow-icon-svg"><?php get_template_part( 'assets/svg/carousel-arrow-svg' ); ?></div>
	<div class="cluster-icon-svg"><?php get_template_part( 'assets/svg/map-pin-cluster-svg' ); ?></div>
	<div class="selected-icon-svg"><?php get_template_part( 'assets/svg/map-pin-selected-svg' ); ?></div>
	<div class="empty-icon-svg"><?php get_template_part( 'assets/svg/map-pin-empty-svg' ); ?></div>
	<div class="card-pin-svg"><?php get_template_part( 'assets/svg/pin-simple-svg' ); ?></div>
</div>

<?php wp_footer(); ?>

</body>
</html>
<script>
 //jQuery('#job_day_chosen ul li.active-result').on('click',function() {
	 //var aa = jQuery(this).val();
	
    //jQuery('.fieldset-job_'+aa).show();	
// });
/* jQuery('#job_day_chosen .chosen-drop ul li').change(function() {
	 //var aa = jQuery(this).val();
	alert("hii");
    //jQuery('.fieldset-job_'+aa).show();	
 });*/
 //var aa = jQuery(this).val();

    /*jQuery(document).ready(function($){ 
     aa =  jQuery(".active-result").chosen();
	 alert(aa);
    });*/
	 jQuery('#job_day').change(function() {
		 var aa = jQuery(this).val();
         jQuery('.fieldset-job_'+aa).show();
		 jQuery('.fieldset-des').show();
		 
	 });
 jQuery('.fieldset-job_0 .close').click(function() {
		     jQuery('.fieldset-job_0').hide();
             jQuery('.fieldset-des').hide();			 
	 });
	 jQuery('.fieldset-job_1 .close').click(function() {
		     jQuery('.fieldset-job_1').hide();
jQuery('.fieldset-des').hide();				 
	 });
	 jQuery('.fieldset-job_2 .close').click(function() {
		     jQuery('.fieldset-job_2').hide();
jQuery('.fieldset-des').hide();				 
	 });
	 jQuery('.fieldset-job_3 .close').click(function() {
		     jQuery('.fieldset-job_3').hide();
jQuery('.fieldset-des').hide();				 
	 });
	 jQuery('.fieldset-job_4 .close').click(function() {
		     jQuery('.fieldset-job_4').hide();	
jQuery('.fieldset-des').hide();				 
	 });
	 jQuery('.fieldset-job_5 .close').click(function() {
		     jQuery('.fieldset-job_5').hide();	 
	 });
	 jQuery('.fieldset-job_6 .close').click(function() {
		     jQuery('.fieldset-job_6').hide();
jQuery('.fieldset-des').hide();				 
	 });
 </script>