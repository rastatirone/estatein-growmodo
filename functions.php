<?php
/**
 * Estatein Growmodo functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Theme Setup
function estatein_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    // Register Nav Menus
    register_nav_menus(
        array(
            'primary'        => esc_html__( 'Primary Menu', 'estatein-growmodo' ),
            'footer'         => esc_html__( 'Footer Menu (legacy)', 'estatein-growmodo' ),
            'footer_menu_1'  => esc_html__( 'Footer - Home Column', 'estatein-growmodo' ),
            'footer_menu_2'  => esc_html__( 'Footer - About Us Column', 'estatein-growmodo' ),
            'footer_menu_3'  => esc_html__( 'Footer - Properties Column', 'estatein-growmodo' ),
            'footer_menu_4'  => esc_html__( 'Footer - Services Column', 'estatein-growmodo' ),
            'footer_menu_5'  => esc_html__( 'Footer - Contact Us Column', 'estatein-growmodo' ),
        )
    );
}
add_action( 'after_setup_theme', 'estatein_theme_setup' );

/**
 * Allow SVG uploads in the Media Library.
 *
 * Core does not ship SVG as an allowed mime type; finfo often mislabels SVG,
 * which triggers “This file cannot be processed by the web server.”
 * SVG may contain scripts — only users who can upload files get this (admins/editors by default).
 */
function estatein_allow_svg_mime_types( $mimes ) {
	if ( ! current_user_can( 'upload_files' ) ) {
		return $mimes;
	}
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'estatein_allow_svg_mime_types' );

/**
 * Trust .svg / .svgz extension when server MIME detection does not return image/svg+xml.
 *
 * @param array{ext?: string, type?: string, proper_filename?: string} $data     File type data.
 * @param string                                                       $file     Full path to file (unused).
 * @param string                                                       $filename Original filename.
 * @param string[]|null                                                $mimes    Mime types keyed by extension.
 * @return array{ext?: string, type?: string, proper_filename?: string}
 */
function estatein_fix_svg_filetype_on_upload( $data, $file, $filename, $mimes ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
	if ( ! current_user_can( 'upload_files' ) ) {
		return $data;
	}
	$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
	if ( 'svg' === $extension ) {
		$data['ext']              = 'svg';
		$data['type']             = 'image/svg+xml';
		$data['proper_filename'] = $filename;
		return $data;
	}
	if ( 'svgz' === $extension ) {
		$data['ext']              = 'svgz';
		$data['type']             = 'image/svg+xml';
		$data['proper_filename'] = $filename;
		return $data;
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'estatein_fix_svg_filetype_on_upload', 10, 4 );

/**
 * Skip raster thumbnail generation for SVG (no GD/Imagick SVG support on most hosts).
 *
 * @param array<string, mixed> $metadata      Attachment metadata.
 * @param int                  $attachment_id Attachment post ID.
 * @param string               $context       Create context.
 * @return array<string, mixed>
 */
function estatein_svg_attachment_metadata( $metadata, $attachment_id, $context ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
	if ( 'image/svg+xml' !== get_post_mime_type( $attachment_id ) ) {
		return $metadata;
	}
	$file = get_attached_file( $attachment_id );
	if ( ! $file || ! is_readable( $file ) ) {
		return $metadata;
	}
	$relative = wp_make_relative_upload_path( $file );

	return array(
		'file'   => $relative,
		'width'  => 0,
		'height' => 0,
	);
}
add_filter( 'wp_generate_attachment_metadata', 'estatein_svg_attachment_metadata', 10, 3 );

// Enqueue Scripts & Styles
function estatein_growmodo_scripts() {
    // 1. Enqueue Tailwind utilities first.
    wp_enqueue_style(
        'estatein-tailwind',
        get_template_directory_uri() . '/assets/css/tailwind-output.css',
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // 2. Enqueue style.css second so design tokens and components override Tailwind.
    wp_enqueue_style(
        'estatein-style',
        get_stylesheet_uri(),
        array( 'estatein-tailwind' ),
        wp_get_theme()->get( 'Version' )
    );

    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        array( 'estatein-style' ),
        '6.5.2'
    );

    if ( estatein_should_enqueue_promo_banner_script() ) {
        wp_enqueue_script(
            'estatein-promo-banner',
            get_template_directory_uri() . '/assets/js/promo-banner.js',
            array(),
            wp_get_theme()->get( 'Version' ),
            true
        );
    }

    wp_enqueue_script(
        'estatein-header-scroll',
        get_template_directory_uri() . '/assets/js/header-scroll.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    wp_enqueue_script(
        'estatein-mobile-navigation',
        get_template_directory_uri() . '/assets/js/mobile-navigation.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    if ( is_page() ) {
        wp_enqueue_script(
            'estatein-section-card-loop',
            get_template_directory_uri() . '/assets/js/section-card-loop.js',
            array(),
            wp_get_theme()->get( 'Version' ),
            true
        );
    }

    if ( is_singular( 'property' ) ) {
        wp_enqueue_script(
            'estatein-property-detail',
            get_template_directory_uri() . '/assets/js/property-detail.js',
            array(),
            wp_get_theme()->get( 'Version' ),
            true
        );
    }
}

/**
 * Whether the promo announcement bar is configured and needs its dismiss script.
 *
 * @return bool
 */
function estatein_should_enqueue_promo_banner_script() {
    if ( ! function_exists( 'get_field' ) || ! get_field( 'enable_banner', 'option' ) ) {
        return false;
    }

    $text = (string) get_field( 'banner_text', 'option' );
    $link = get_field( 'banner_link', 'option' );
    $bg    = get_field( 'promo_banner_background_image', 'option' );
    $bg_url = '';

    if ( is_array( $bg ) && ! empty( $bg['url'] ) ) {
        $bg_url = $bg['url'];
    }

    return ( $text !== '' || $bg_url !== '' || ( is_array( $link ) && ! empty( $link['url'] ) ) );
}
add_action( 'wp_enqueue_scripts', 'estatein_growmodo_scripts' );

/**
 * Output one footer column: grey title from the top-level parent item (e.g. "Home"), links from its children.
 * WordPress menu name (e.g. "Footer Menu 1") is not used as the column title.
 *
 * @param string $theme_location Registered menu location slug.
 */
function estatein_render_footer_nav_column( $theme_location ) {
    if ( ! has_nav_menu( $theme_location ) ) {
        return;
    }

    $locations = get_nav_menu_locations();
    if ( empty( $locations[ $theme_location ] ) ) {
        return;
    }

    $menu_id = (int) $locations[ $theme_location ];
    $items   = wp_get_nav_menu_items( $menu_id, array( 'update_post_term_cache' => false ) );
    if ( empty( $items ) || ! is_array( $items ) ) {
        return;
    }

    $top_level = array();
    foreach ( $items as $item ) {
        if ( ! isset( $item->ID, $item->menu_item_parent ) ) {
            continue;
        }
        if ( (int) $item->menu_item_parent !== 0 ) {
            continue;
        }
        $top_level[] = $item;
    }

    usort(
        $top_level,
        function ( $a, $b ) {
            return (int) $a->menu_order - (int) $b->menu_order;
        }
    );

    if ( empty( $top_level ) ) {
        return;
    }

    foreach ( $top_level as $parent ) {
        $heading = isset( $parent->title ) ? wp_strip_all_tags( $parent->title ) : '';
        if ( $heading === '' && ! empty( $parent->object_id ) ) {
            $heading = get_the_title( (int) $parent->object_id );
        }
        $heading = apply_filters( 'nav_menu_item_title', $heading, $parent, (object) array(), 0 );
        if ( $heading === '' ) {
            continue;
        }

        $children = array();
        foreach ( $items as $item ) {
            if ( ! isset( $item->menu_item_parent, $item->ID ) ) {
                continue;
            }
            if ( (int) $item->menu_item_parent === (int) $parent->ID ) {
                $children[] = $item;
            }
        }

        usort(
            $children,
            function ( $a, $b ) {
                return (int) $a->menu_order - (int) $b->menu_order;
            }
        );

        $parent_url   = isset( $parent->url ) ? $parent->url : '#';
        $parent_attrs = ' href="' . esc_url( $parent_url ) . '"';
        if ( ! empty( $parent->target ) && '_blank' === $parent->target ) {
            $parent_attrs .= ' target="_blank" rel="noopener noreferrer"';
        }
        if ( ! empty( $parent->attr_title ) ) {
            $parent_attrs .= ' title="' . esc_attr( $parent->attr_title ) . '"';
        }

        echo '<div class="site-footer__nav-group">';
        echo '<h3 class="site-footer__nav-heading site-footer__nav-heading--is-link">';
        echo '<a' . $parent_attrs . '>' . esc_html( $heading ) . '</a>';
        echo '</h3>';

        if ( ! empty( $children ) ) {
            echo '<ul class="site-footer__menu" role="list">';
            foreach ( $children as $child ) {
                estatein_render_footer_nav_menu_link_li( $child );
            }
            echo '</ul>';
        }

        echo '</div>';
    }
}

/**
 * Print one &lt;li&gt; for a footer submenu (or fallback) link.
 *
 * @param object $item Nav menu item object.
 */
function estatein_render_footer_nav_menu_link_li( $item ) {
    if ( ! isset( $item->ID, $item->url ) ) {
        return;
    }

    $title = isset( $item->title ) ? wp_strip_all_tags( $item->title ) : '';
    $title = apply_filters( 'nav_menu_item_title', $title, $item, (object) array(), 1 );
    if ( $title === '' ) {
        $title = __( 'Menu item', 'estatein-growmodo' );
    }

    $classes = isset( $item->classes ) && is_array( $item->classes ) ? array_filter( $item->classes ) : array();
    $classes[] = 'menu-item';
    $li_class  = trim( implode( ' ', array_unique( $classes ) ) );

    $attr_out = ' href="' . esc_url( $item->url ) . '"';
    if ( ! empty( $item->target ) && '_blank' === $item->target ) {
        $attr_out .= ' target="_blank"';
    }
    $rel = array();
    if ( ! empty( $item->target ) && '_blank' === $item->target ) {
        $rel[] = 'noopener';
        $rel[] = 'noreferrer';
    }
    if ( ! empty( $item->xfn ) ) {
        $rel = array_merge( $rel, preg_split( '/\s+/', trim( $item->xfn ) ) );
    }
    if ( ! empty( $rel ) ) {
        $attr_out .= ' rel="' . esc_attr( implode( ' ', array_unique( array_filter( $rel ) ) ) ) . '"';
    }
    if ( ! empty( $item->attr_title ) ) {
        $attr_out .= ' title="' . esc_attr( $item->attr_title ) . '"';
    }

    printf(
        '<li class="%1$s"><a%2$s>%3$s</a></li>',
        esc_attr( $li_class ),
        $attr_out,
        esc_html( $title )
    );
}

// Include Custom Post Types
require get_template_directory() . '/inc/cpt-registration.php';
require_once get_template_directory() . '/inc/card-loop-helpers.php';
require_once get_template_directory() . '/inc/property-template-helpers.php';
require_once get_template_directory() . '/inc/property-inquiry-handler.php';
require_once get_template_directory() . '/inc/dummy-data-seed.php';

/* ==========================================================================
   ACF JSON Synchronization
   ========================================================================== */

// Set ACF-JSON save point
add_filter( 'acf/settings/save_json', 'estatein_acf_json_save_point' );
function estatein_acf_json_save_point( $path ) {
    return get_template_directory() . '/acf-json';
}

// Set ACF-JSON load point
add_filter( 'acf/settings/load_json', 'estatein_acf_json_load_point' );
function estatein_acf_json_load_point( $paths ) {
    // Remove the original path
    unset( $paths[0] );
    // Append our custom path
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}

/* ==========================================================================
   ACF Global Options Page
   ========================================================================== */

// Register a Global Settings Options Page while we are at it
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page(
        array(
            'page_title' => 'Global Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        )
    );
}

/**
 * Hide legacy duplicate "Global FAQs" field group (DB) now merged into Global Settings JSON.
 */
function estatein_acf_deactivate_orphan_global_faqs_group() {
    if ( ! function_exists( 'acf_get_field_group' ) || ! function_exists( 'acf_update_field_group' ) ) {
        return;
    }
    $group = acf_get_field_group( 'group_global_faqs' );
    if ( empty( $group['ID'] ) ) {
        return;
    }
    if ( ! empty( $group['active'] ) ) {
        acf_update_field_group( array_merge( $group, array( 'active' => false ) ) );
    }
}
add_action( 'acf/init', 'estatein_acf_deactivate_orphan_global_faqs_group', 5 );

/**
 * Allowed HTML for inline social SVG / icon snippets (ACF repeater).
 *
 * @return array<string, array<string, bool>>
 */
function estatein_allowed_footer_icon_tags() {
    $svg_attrs = array(
        'class'           => true,
        'xmlns'           => true,
        'viewbox'         => true,
        'viewBox'         => true,
        'fill'            => true,
        'width'           => true,
        'height'          => true,
        'role'            => true,
        'aria-hidden'     => true,
        'focusable'       => true,
        'stroke'          => true,
        'stroke-width'    => true,
        'stroke-linecap'  => true,
        'stroke-linejoin' => true,
        'd'               => true,
        'cx'              => true,
        'cy'              => true,
        'r'               => true,
        'x'               => true,
        'y'               => true,
        'rx'              => true,
        'transform'       => true,
        'opacity'         => true,
    );

    return array(
        'svg'    => $svg_attrs,
        'path'   => $svg_attrs,
        'circle' => $svg_attrs,
        'g'      => $svg_attrs,
        'rect'   => $svg_attrs,
        'title'  => array(),
        'i'      => array( 'class' => true, 'aria-hidden' => true ),
    );
}

/**
 * Markup for footer social icon (Font Awesome classes or SVG HTML from ACF).
 *
 * @param string $icon_raw Repeater sub-field `platform_icon`.
 * @return string Safe HTML (empty string if no icon).
 */
function estatein_footer_social_icon_html( $icon_raw ) {
    $icon_raw = is_string( $icon_raw ) ? trim( $icon_raw ) : '';
    if ( $icon_raw === '' ) {
        return '';
    }
    if ( strpos( $icon_raw, '<' ) === 0 ) {
        return wp_kses( $icon_raw, estatein_allowed_footer_icon_tags() );
    }
    return '<i class="' . esc_attr( $icon_raw ) . '" aria-hidden="true"></i>';
}
