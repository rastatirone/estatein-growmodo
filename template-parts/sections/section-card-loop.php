<?php
/**
 * Dispatches flexible layout `page_card_sections` rows (must be inside `have_rows` / `the_row`).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_row_layout' ) ) {
	return;
}

$estatein_layout = get_row_layout();

switch ( $estatein_layout ) {
	case 'featured_properties':
		get_template_part( 'template-parts/sections/card-loop/layout-featured-properties' );
		break;
	case 'testimonials':
		get_template_part( 'template-parts/sections/card-loop/layout-testimonials' );
		break;
	case 'faq_cards':
		get_template_part( 'template-parts/sections/card-loop/layout-faq-cards' );
		break;
	default:
		break;
}
