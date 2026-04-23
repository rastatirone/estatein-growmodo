<?php
/**
 * Helpers for single property templates.
 *
 * @package estatein-growmodo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalize ACF gallery (+ featured image fallback) into image rows for templates.
 *
 * @param int $post_id Property post ID.
 * @return array<int, array{id:int, url:string, thumb:string, alt:string}>
 */
function estatein_property_gallery_images( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id < 1 ) {
		return array();
	}

	$out = array();

	if ( function_exists( 'get_field' ) ) {
		$gallery = get_field( 'gallery', $post_id );
		if ( is_array( $gallery ) ) {
			foreach ( $gallery as $row ) {
				$item = estatein_property_normalize_gallery_row( $row );
				if ( $item !== null ) {
					$out[] = $item;
				}
			}
		}
	}

	if ( $out === array() && has_post_thumbnail( $post_id ) ) {
		$id   = (int) get_post_thumbnail_id( $post_id );
		$full = wp_get_attachment_image_url( $id, 'full' );
		$lg   = wp_get_attachment_image_url( $id, 'large' ) ?: $full;
		$th   = wp_get_attachment_image_url( $id, 'medium' ) ?: $lg;
		if ( is_string( $lg ) && $lg !== '' ) {
			$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
			$out[] = array(
				'id'    => $id,
				'url'   => $lg,
				'thumb' => is_string( $th ) && $th !== '' ? $th : $lg,
				'alt'   => $alt !== '' ? $alt : get_the_title( $post_id ),
			);
		}
	}

	return $out;
}

/**
 * @param mixed $row ACF gallery row (array or attachment ID).
 * @return array{id:int, url:string, thumb:string, alt:string}|null
 */
function estatein_property_normalize_gallery_row( $row ) {
	if ( is_numeric( $row ) ) {
		$id = (int) $row;
		if ( $id < 1 ) {
			return null;
		}
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( ! is_string( $url ) || $url === '' ) {
			return null;
		}
		$thumb = wp_get_attachment_image_url( $id, 'medium' ) ?: $url;
		$alt   = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );

		return array(
			'id'    => $id,
			'url'   => $url,
			'thumb' => $thumb,
			'alt'   => $alt,
		);
	}

	if ( ! is_array( $row ) ) {
		return null;
	}

	$id = isset( $row['ID'] ) ? (int) $row['ID'] : 0;
	if ( $id < 1 && ! empty( $row['id'] ) ) {
		$id = (int) $row['id'];
	}

	$url = '';
	if ( ! empty( $row['sizes']['large'] ) ) {
		$url = (string) $row['sizes']['large'];
	} elseif ( ! empty( $row['url'] ) ) {
		$url = (string) $row['url'];
	} elseif ( $id > 0 ) {
		$url = (string) wp_get_attachment_image_url( $id, 'large' );
	}

	if ( $url === '' ) {
		return null;
	}

	$thumb = '';
	if ( ! empty( $row['sizes']['medium'] ) ) {
		$thumb = (string) $row['sizes']['medium'];
	} elseif ( $id > 0 ) {
		$thumb = (string) wp_get_attachment_image_url( $id, 'medium' );
	}
	if ( $thumb === '' ) {
		$thumb = $url;
	}

	$alt = isset( $row['alt'] ) ? (string) $row['alt'] : '';
	if ( $alt === '' && $id > 0 ) {
		$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
	}

	return array(
		'id'    => $id,
		'url'   => $url,
		'thumb' => $thumb,
		'alt'   => $alt,
	);
}

/**
 * Format count for display (e.g. bedrooms as "04").
 *
 * @param mixed $value Raw number or string.
 * @return string
 */
function estatein_property_stat_display( $value ) {
	if ( $value === null || $value === '' ) {
		return '';
	}
	if ( is_numeric( $value ) ) {
		$n = (int) $value;
		return $n < 100 ? sprintf( '%02d', $n ) : (string) $n;
	}
	return (string) $value;
}
