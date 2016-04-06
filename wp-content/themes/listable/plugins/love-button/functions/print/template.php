<?php 
/*
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
?><html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php echo $postData->post_title; ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php 
	$options = get_option('piha_theme_options');
	if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<link rel="stylesheet" href="<?php echo plugins_url('xprint/style.css', $functionDir) ?>" type="text/css" media="screen" />
</head>
<body>
	<div id="content" class="clearfix">
		<article>
			<div class="entry-wrap">
				<header class="entry-header">
					<span class="post-date"><?php echo date(get_option('date_format'), strtotime($postData->post_date_gmt)); ?></span>
					<h1 class="entry-title"><?php echo $postData->post_title; ?></h1>
				</header>
				<div class="entry-content">
					<?php if ( has_post_thumbnail() ): ?>
						<div class="imageWrapper">
							<a class="beitragsbild" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
						</div>
					<?php endif; ?>
					<?php echo apply_filters( 'the_content', $postData->post_content); ?>
				</div>
			</div>	
		</article>
	</div>
</body>
</html>