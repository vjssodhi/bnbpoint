<?php
/**
 * Template Name: Front Page
 *
 * @package Listable
 * @since Listable 1.0
 */

get_header();

global $post; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) : the_post();
				// we'll return a random attachment from image and videos background lists, if one is present
				$the_random_hero = listable_get_random_hero_object();
				
				
				if ( $post_id === null ) {
					global $post;
					$post_id = $post->ID;
				}
                //$image_backgrounds = array();
				$image_backgrounds  = get_post_meta( $post_id, 'image_backgrounds', true );
				$str = $image_backgrounds;
                 $arra = (explode(",",$str));
				$videos_backgrounds = get_post_meta( $post_id, 'videos_backgrounds', true );
				
				//$aa = get_post( 11033 );
				$args = array(
				    'post_type' => 'attachment',
					'post__in' => $arra
				);

                $posts = get_posts($args);
				//print('<pre>'); print_r($posts); print('</pre>'); 
				foreach($posts as $mpost){
					              
								if($mpost->pinged){
									
									$de_img = $mpost;
								} 
							}
							$has_image1       = false;
							$has_image1 = wp_get_attachment_url( $de_img->ID );
							//print('<pre>'); print_r($de_img); print('</pre>');
				$has_image       = false; ?>

				<?php if ( ( empty( $the_random_hero ) || property_exists( $the_random_hero, 'post_mime_type' ) || strpos( $the_random_hero->post_mime_type, 'video' ) !== false ) && is_object( $the_random_hero ) && property_exists( $the_random_hero, 'post_mime_type' ) && strpos( $the_random_hero->post_mime_type, 'image' ) !== false ) {
					$has_image = wp_get_attachment_url( $the_random_hero->ID );
				} ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header has-image">
						<div class="entry-featured"<?php if ( ! empty( $de_img ) ) {
							echo ' style="background-image: url(' . $has_image1 . ');"';
						} ?>>
							<?php /* if  ( ! empty( $the_random_hero ) && property_exists( $the_random_hero, 'post_mime_type' ) && strpos( $the_random_hero->post_mime_type, 'video' ) !== false ) {
								$mimetype = str_replace( 'video/', '', $the_random_hero->post_mime_type );
								if ( has_post_thumbnail($the_random_hero->ID) ) {
									$image = wp_get_attachment_url( get_post_thumbnail_id($the_random_hero->ID) );
									$poster = ' poster="' . $image . '" ';
								} else {
									$poster = ' ';
								}
								echo do_shortcode( '[video ' . $mimetype . '="' . $the_random_hero->guid . '"' . $poster . 'loop="true" autoplay="true"][/video]' );
							} */ ?>
							
							<?php 
							if  ( ! empty( $de_img ) && property_exists( $de_img, 'post_mime_type' ) && strpos( $de_img->post_mime_type, 'video' ) !== false ) {
							$mimetype = str_replace( 'video/', '', $de_img->post_mime_type );
							if ( has_post_thumbnail($de_img->ID) ) {
									$image = wp_get_attachment_url( get_post_thumbnail_id($de_img->ID) );
									$poster = ' poster="' . $image . '" ';
								} else {
									$poster = ' ';
								}
								echo do_shortcode( '[video ' . $mimetype . '="' . $de_img->guid . '"' . $poster . 'loop="true" autoplay="true"][/video]' );
							}
				
							//die("here");
							?>
						</div>
						<div class="header-content">
							<h1 class="page-title"><?php the_title(); ?></h1>

							<div class="entry-subtitle">
								<?php if ( $post->post_excerpt ) {
									the_excerpt();
								} ?>
							</div>

							<?php get_template_part( 'job_manager/job-filters-hero' ); ?>

						</div>

						<div class="top-categories">
							<?php listable_display_frontpage_listing_categories(); ?>
						</div>

					</header>

					<?php if ( $post->post_content ): ?>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>
					<!-- .entry-content -->

					<?php if ( is_active_sidebar( 'front_page_sections' ) ) { ?>
						<div class="widgets_area">
							<?php dynamic_sidebar( 'front_page_sections' ); ?>
						</div>
					<?php } ?>

				</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main>
		<!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();