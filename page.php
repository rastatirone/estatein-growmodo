<?php
/**
 * Page template — hero (ACF) then main content.
 *
 * @package estatein-growmodo
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/sections/hero' );
		get_template_part( 'template-parts/sections/service-highlights' );
		if ( function_exists( 'have_rows' ) && have_rows( 'page_card_sections' ) ) {
			while ( have_rows( 'page_card_sections' ) ) {
				the_row();
				get_template_part( 'template-parts/sections/section-card-loop' );
			}
		}
		?>
		<div class="container">
			<?php the_content(); ?>
		</div>
		<?php
	endwhile;
endif;

get_footer();
