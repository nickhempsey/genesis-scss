<?php

$version = wp_get_theme()->Version;

// Bootstrap JS and dependencies
wp_register_script(
    'bsg_popper_js',
    'https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js',
    array( 'jquery' ), '1.0.0', false);


wp_register_script(
    'bsg_bootstrap_js',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js',
    //get_stylesheet_directory_uri() . '/js/bootstrap.min.js',
    array( 'jquery' ), '1.0.0', false );


//  Fonts
wp_register_style(
    'bsg-typekit-fonts',
    'https://use.typekit.net/bcj4ekv.css');


// Animate On Scroll
wp_register_script(
	'bsg_aos_js',
	'https://unpkg.com/aos@2.3.1/dist/aos.js',
	array( 'jquery' ), '1.0.0', false );

wp_register_style(
	'bsg_aos_css',
	'https://unpkg.com/aos@2.3.1/dist/aos.css',
	array(), $version );


	
// Theme assets
wp_register_style(
    'bsg_bootstrap_css',
    get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap.min.css',
    array(), $version );


wp_register_style(
    'bsg_combined_css',
    get_stylesheet_directory_uri() . '/css/style.min.css',
    array(), $version );


wp_register_script(
    'bsg_combined_js',
    get_stylesheet_directory_uri() . '/js/common.min.js',
    array('jquery', 'bsg_bootstrap_js',),
    $version, false );

wp_register_style(
    'bsg_admin_css',
    get_stylesheet_directory_uri().'/css/admin.min.css',
    array(), $version);


remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'wp_enqueue_scripts', 'bsg_enqueue_css_js' );
add_action( 'admin_enqueue_scripts', 'bsg_enqueue_css_js');
function bsg_enqueue_css_js() {

    $post_type = get_post_type();
    $allow = array(
        //'post',
        'page',
    );
    if(!is_admin() || (is_admin() && in_array($post_type, $allow)) ) {
        //  Fonts
        wp_enqueue_style( 'bsg-typekit-fonts');

        // Theme assets
        wp_enqueue_style( 'bsg_bootstrap_css');
        wp_enqueue_style( 'bsg_combined_css');
    }


    // Admin Specific
    if(is_admin()) {

        wp_enqueue_style('bsg_admin_css');

    }

    
    // Frontend Specific
    if(!is_admin()) {


		// Bootstrap JS
		wp_enqueue_style( 'bsg_aos_js');
		wp_enqueue_script( 'bsg_aos_css');

		// Bootstrap JS
		wp_enqueue_script( 'bsg_popper_js');
		wp_enqueue_script( 'bsg_bootstrap_js');

		// Theme JS
		wp_enqueue_script( 'bsg_combined_js');


    }

}


// Avoid conflicts with ACF field groups so lets dequeue it so it doesn't get all janky.
//add_action('acf/field_group/admin_enqueue_scripts', 'dequeue_scripts_acf_field_groups');
function dequeue_scripts_acf_field_groups() {

    wp_dequeue_style( 'bsg-typekit-fonts');
    wp_dequeue_style( 'bsg_bootstrap_css');
    wp_dequeue_style( 'bsg_combined_css');
    wp_dequeue_script( 'bsg_combined_js');

}
