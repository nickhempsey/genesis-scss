<?php

// add bootstrap classes
add_filter( 'genesis_attr_nav-primary',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_nav-secondary',       'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-header',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-inner',          'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_site-container',      'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_content-sidebar-wrap','bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_content',             'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-primary',     'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_sidebar-secondary',   'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_archive-pagination',  'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_entry-content',       'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_entry-pagination',    'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_entry-header',    'bsg_add_markup_class', 10, 2 );
//add_filter( 'genesis_attr_site-footer',         'bsg_add_markup_class', 10, 2 );
add_filter( 'genesis_attr_taxonomy-archive-description', 'bsg_add_markup_class', 10, 2 );

function bsg_add_markup_class( $attr, $context ) {
	// default classes to add
	$queried_object = get_queried_object();

	// Fallback Options
	$containerWidth = 'container';
	$margin = 'my-5';

	if($queried_object && !is_archive()) {
		if(get_field('page_width', $queried_object->ID)) {
			$containerWidth = get_field('page_width', $queried_object->ID);
			$containerWidth = $containerWidth == 'container-small' ? $containerWidth.' container' : $containerWidth;
		}

		if(get_field('remove_vertical_margin', $queried_object->ID)) {
			$margin = get_field('remove_vertical_margin', $queried_object->ID);
		}
	}

	if(
		is_home() || is_category()
		|| is_tag() || is_search() || is_page('blog')
	) {
		$containerWidth = 'fullwidth';
	}

    if(is_404()) {
        $margin = 'my-0';
    }
    $classes_to_add = apply_filters ('bsg-classes-to-add',
        // default bootstrap markup values
        array(
            'nav-primary'                   => 'navbar px-0 navbar-expand-lg',
            'nav-secondary'                 => 'navbar navbar-inverse navbar-static-top',
            'site-container'                => '',
            'site-header'                   => 'fixed-top',
            'site-inner'                    => $containerWidth,
            'site-footer'                   => 'container',
            'content-sidebar-wrap'          => 'row no-gutters',
            'content'                       => 'col-12 col-smg-8',
            'sidebar-primary'               => 'col-12 col-sm-3 offset-1',
            'archive-pagination'            => 'clearfix',
            'entry-content'                 => 'clearfix',
            'entry-pagination'              => 'clearfix bsg-pagination-numeric',
            'taxonomy-archive-description'  => 'container row-padding',
            'author-archive-description'    => 'container',
            'cpt-archive-description'       => 'container',
            'blog-template-description'     => 'container',
            'entry-header'                  => 'text-center',

        ),
        $context,
        $attr
    );

    // populate $classes_array based on $classes_to_add
    $value = isset( $classes_to_add[ $context ] ) ? $classes_to_add[ $context ] : array();

    if ( is_array( $value ) ) {
        $classes_array = $value;
    } else {
        $classes_array = explode( ' ', (string) $value );
    }

    // apply any filters to modify the class
    $classes_array = apply_filters( 'bsg-add-class', $classes_array, $context, $attr );

    $classes_array = array_map( 'sanitize_html_class', $classes_array );

    // append the class(es) string (e.g. 'span9 custom-class1 custom-class2')
    $attr['class'] .= ' ' . implode( ' ', $classes_array );

    return $attr;
}


if( current_user_can('administrator') ) {
    //add_action( 'wp_footer', 'bsg_list_genesis_attr_filters' );
}

function bsg_list_genesis_attr_filters() {
	global $wp_filter;
	$genesis_attr_filters = array();
	$output = '<ul>';
	foreach ( $wp_filter as $key => $val ) {
		if ( FALSE !== strpos( $key, 'genesis_attr' ) ) {
			$genesis_attr_filters[$key][] = var_export( $val, TRUE );
		}
	}
    foreach ( $genesis_attr_filters as $name => $attr_vals ) {
                   $name = str_replace("genesis_attr_","",$name);
		$output .= "<li>$name</li>";
	}
    print "$output</ul>";
}
