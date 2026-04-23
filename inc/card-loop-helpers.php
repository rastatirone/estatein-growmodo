<?php
/**
 * Helpers for page card-loop sections (property / testimonial cards).
 *
 * @package estatein-growmodo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param array<string, mixed> $link ACF link array.
 * @return bool
 */
function estatein_card_loop_link_is_usable( $link ) {
	return is_array( $link ) && ! empty( $link['url'] );
}

/**
 * @param int $post_id Property post ID.
 * @return string Primary property type term name or empty string.
 */
function estatein_card_loop_property_type_label( $post_id ) {
	$terms = get_the_terms( $post_id, 'property_type' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}
	$first = reset( $terms );
	return $first && isset( $first->name ) ? (string) $first->name : '';
}

/**
 * @param int $post_id Property post ID.
 * @return string Formatted price or empty.
 */
function estatein_card_loop_property_price_html( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}
	$price = get_field( 'price', $post_id );
	if ( $price === null || $price === '' ) {
		return '';
	}
	return '$' . number_format_i18n( (float) $price );
}

/**
 * Featured image URL for property cards, with size fallbacks and first gallery image.
 * Eager loading in carousels is recommended in the template (lazy often fails inside transformed tracks).
 *
 * @param int $post_id Property post ID.
 * @return string URL or empty string.
 */
function estatein_card_loop_property_card_image_url( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		return '';
	}

	foreach ( array( 'large', 'medium', 'full' ) as $estatein_size ) {
		$estatein_url = get_the_post_thumbnail_url( $post_id, $estatein_size );
		if ( is_string( $estatein_url ) && $estatein_url !== '' ) {
			return $estatein_url;
		}
	}

	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$estatein_gallery = get_field( 'gallery', $post_id );
	if ( ! is_array( $estatein_gallery ) || $estatein_gallery === array() ) {
		return '';
	}

	$estatein_first = $estatein_gallery[0];
	if ( is_numeric( $estatein_first ) ) {
		$estatein_att = wp_get_attachment_image_url( (int) $estatein_first, 'large' );
		return is_string( $estatein_att ) && $estatein_att !== '' ? $estatein_att : '';
	}

	if ( ! is_array( $estatein_first ) ) {
		return '';
	}

	if ( ! empty( $estatein_first['sizes']['large'] ) ) {
		return (string) $estatein_first['sizes']['large'];
	}
	if ( ! empty( $estatein_first['sizes']['medium'] ) ) {
		return (string) $estatein_first['sizes']['medium'];
	}
	if ( ! empty( $estatein_first['url'] ) ) {
		return (string) $estatein_first['url'];
	}

	return '';
}
