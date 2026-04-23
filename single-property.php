<?php
/**
 * Single property listing (detail page).
 *
 * @package estatein-growmodo
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/single-property/content' );
	endwhile;
endif;

get_footer();
