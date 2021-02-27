<?php

// Add HTML5 markup structure
add_theme_support( 'html5' );

// Remove structural Wraps
remove_theme_support( 'genesis-structural-wraps' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );


add_theme_support( 'genesis-structural-wraps',
	array(
		'footer',
		//'site-inner',
		'footer-widgets',
		'archive-description',
		'taxonomy-archive-description',
	)
);



/**
 * Filter genesis_attr_structural-wrap to use BS .container-fluid classes
 */
add_filter( 'genesis_attr_structural-wrap', 'bsg_attributes_structural_wrap' );
function bsg_attributes_structural_wrap( $attributes ) {
    $attributes['class'] = 'container';
    return $attributes;
}


/**
 * Replacement helper function to dynamically switch
 * change .container to .container-fluid classes
 *
 * Useage: add_filter( 'genesis_structural_wrap-{$context}', 'bsg_wrap_container_fluid');
 */
function bsg_wrap_container_fluid( $output, $original_output ) {
	if ( $original_output == 'open' ) {
	   	$output = sprintf( '<div %s>', genesis_attr( 'container-fluid' ) );
	}
	return $output;
}

// Remove item(s) from genesis admin screens
add_action( 'genesis_admin_before_metaboxes', 'bsg_remove_genesis_theme_metaboxes' );

// Remove item(s) from genesis customizer
add_action( 'customize_register', 'bsg_remove_genesis_customizer_controls', 20 );

/**
 * Remove selected Genesis metaboxes from the Theme Settings and SEO Settings pages.
 *
 * @param string $hook The unique pagehook for the Genesis settings page
 */

function bsg_remove_genesis_theme_metaboxes( $hook ) {
    /** Theme Settings metaboxes */
    //remove_meta_box( 'genesis-theme-settings-version',  $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-feeds',    $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-layout',   $hook, 'main' );
    remove_meta_box( 'genesis-theme-settings-header',   $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-nav',      $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-breadcrumb', $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-comments', $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-posts',    $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-blogpage', $hook, 'main' );
    //remove_meta_box( 'genesis-theme-settings-scripts',  $hook, 'main' );

    /** SEO Settings metaboxes */
    //remove_meta_box( 'genesis-seo-settings-doctitle',   $hook, 'main' );
    //remove_meta_box( 'genesis-seo-settings-homepage',   $hook, 'main' );
    //remove_meta_box( 'genesis-seo-settings-dochead',    $hook, 'main' );
    //remove_meta_box( 'genesis-seo-settings-robots',     $hook, 'main' );
    //remove_meta_box( 'genesis-seo-settings-archives',   $hook, 'main' );
}

/**
 * Filter to remove selected Genesis Customizer Menu controls
 *
 * @param instance of WP_Customize_Manager $wp_customize
 */
function bsg_remove_genesis_customizer_controls( $wp_customize ) {
    // remove Site Title/Logo: Dynamic Text or Image Logo option from Customizer
    $wp_customize->remove_control( 'blog_title' );
    return $wp_customize;
}

add_action( 'genesis_meta', 'bsg_general_layout_genesis_meta' );
function bsg_general_layout_genesis_meta() {
  //Remove Entry Header
  remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
  remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
  remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
  remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
  remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
  remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
  remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
  remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
  remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
  remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
  remove_action( 'genesis_before_loop', 'genesis_do_search_title' );

  //Remove Entry Footer
  remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
  remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
  remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

}


function bsg_be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'bsg_be_remove_genesis_page_templates' );



remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action(    'genesis_after_content',              'genesis_get_sidebar_alt' );
