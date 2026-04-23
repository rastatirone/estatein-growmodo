<?php
/**
 * Register Custom Post Types and Taxonomies
 */

function estatein_register_cpts() {
    // 1. Property CPT
    $property_labels = array(
        'name'                  => _x( 'Properties', 'Post Type General Name', 'estatein-growmodo' ),
        'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'estatein-growmodo' ),
        'menu_name'             => __( 'Properties', 'estatein-growmodo' ),
        'all_items'             => __( 'All Properties', 'estatein-growmodo' ),
        'add_new_item'          => __( 'Add New Property', 'estatein-growmodo' ),
    );
    $property_args = array(
        'label'                 => __( 'Property', 'estatein-growmodo' ),
        'labels'                => $property_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'properties' ),
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-home',
        'show_in_rest'          => true,
    );
    register_post_type( 'property', $property_args );

    // 2. Team Member CPT
    $team_labels = array(
        'name'                  => _x( 'Team Members', 'Post Type General Name', 'estatein-growmodo' ),
        'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'estatein-growmodo' ),
        'menu_name'             => __( 'Team', 'estatein-growmodo' ),
        'all_items'             => __( 'All Team Members', 'estatein-growmodo' ),
    );
    $team_args = array(
        'label'                 => __( 'Team Member', 'estatein-growmodo' ),
        'labels'                => $team_labels,
        'supports'              => array( 'title', 'thumbnail' ),
        'public'                => true,
        'has_archive'           => false,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-groups',
        'show_in_rest'          => true,
    );
    register_post_type( 'team_member', $team_args );

    // 3. Testimonial CPT
    $testimonial_labels = array(
        'name'                  => _x( 'Testimonials', 'Post Type General Name', 'estatein-growmodo' ),
        'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'estatein-growmodo' ),
        'menu_name'             => __( 'Testimonials', 'estatein-growmodo' ),
    );
    $testimonial_args = array(
        'label'                 => __( 'Testimonial', 'estatein-growmodo' ),
        'labels'                => $testimonial_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'public'                => false, // Internal UI use only
        'show_ui'               => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-format-quote',
    );
    register_post_type( 'testimonial', $testimonial_args );

    // Taxonomies for Property
    // Location
    register_taxonomy( 'property_location', array( 'property' ), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x( 'Locations', 'taxonomy general name', 'estatein-growmodo' ),
            'singular_name'     => _x( 'Location', 'taxonomy singular name', 'estatein-growmodo' ),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ) );

    // Property Type
    register_taxonomy( 'property_type', array( 'property' ), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x( 'Property Types', 'taxonomy general name', 'estatein-growmodo' ),
            'singular_name'     => _x( 'Property Type', 'taxonomy singular name', 'estatein-growmodo' ),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ) );
    
    // Property Status
    register_taxonomy( 'property_status', array( 'property' ), array(
        'hierarchical'      => true,
        'labels'            => array(
            'name'              => _x( 'Statuses', 'taxonomy general name', 'estatein-growmodo' ),
            'singular_name'     => _x( 'Status', 'taxonomy singular name', 'estatein-growmodo' ),
        ),
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'estatein_register_cpts', 0 );
