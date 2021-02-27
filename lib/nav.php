<?php

remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );


function register_additional_menu() {
    register_nav_menu( 'footer-menu' ,__( 'Footer Menu' ));
}
add_action( 'init', 'register_additional_menu' );
//add_action( 'genesis_before_footer', 'add_footer_nav_genesis' );

function add_footer_nav_genesis() {
    wp_nav_menu( array(
        'theme_location' => 'footer-menu',
        'container_class' => 'genesis-nav-menu footer-menu border-top py-3'
    ));
}

// filter menu args for bootstrap walker and other settings
add_filter( 'wp_nav_menu_args', 'bsg_nav_menu_args_filter' );

// add bootstrap markup around the nav
add_filter( 'wp_nav_menu', 'bsg_nav_menu_markup_filter', 10, 2 );

function bsg_nav_menu_args_filter( $args ) {

    if ('primary' === $args['theme_location']) {
        //$args['depth'] = 2;
        $args['menu_class'] = 'h-100 w-100 navbar-nav justify-content-between m-0 p-0';
        $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
        $args['walker'] = new wp_bootstrap_navwalker();
        $args['link_before'] = '';
        $args['link_after'] = '';
    }

    if ('secondary' === $args['theme_location']) {
        //$args['depth'] = 2;
        $args['menu_class'] = 'nav justify-content-end';
        $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
        $args['walker'] = new wp_bootstrap_navwalker();
    }

    if ('footer-menu' === $args['theme_location']) {
        //$args['depth'] = 2;
        $args['menu_class'] = 'nav justify-content-center navbar-light';
        $args['fallback_cb'] = 'wp_bootstrap_navwalker::fallback';
        $args['walker'] = new wp_bootstrap_navwalker();
    }

    return $args;
}

function bsg_nav_menu_markup_filter( $html, $args ) {
    // only add additional Bootstrap markup to
    // primary and secondary nav locations
    if (
        'primary'   !== $args->theme_location &&
        'secondary' !== $args->theme_location
    ) {
        return $html;
    }

    $data_target = "nav-collapse" . sanitize_html_class( '-' . $args->theme_location );

        $output = '';


            if ( 'primary' === $args->theme_location ) {
                $output .= '<div class="container">';

                    $output .= '<div class="row justify-content-between align-items-center w-100 no-gutters">';

                        $output .= apply_filters( 'bsg_navbar_brand', bsg_navbar_brand_markup() );

                        $output .= '<div class="col navbar-dark navbar-wrapper">';

                            $output .= '<span class="navbar-toggler nav-link" type="button" data-toggle="collapse" data-target="#nav-collapse-primary" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">';
                                $output .= '<span class="nb-closed"><i class="fal fa-bars"></i></span>';
                                $output .= '<span class="nb-opened"><i class="fal fa-times"></i></span>';
                            $output .= '</span>';

                            //$output .= '<div class="col h-100 px-0 ml-4 mr-0">';

                                $output .= "<div class=\" collapse navbar-collapse \" id=\"{$data_target}\">";
                                    $output .= $html;
                                $output .= '</div>'; // .collapse .navbar-collapse

                            //$output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
        }

        if ( 'secondary' === $args->theme_location ) {
            $output .= '<div class="container">';
                $output .= $html;
            $output .= '</div>';
        }

    return $output;
}

function bsg_navbar_brand_markup() {
    $output = '<div class="col navbar-brand">';
        $output .= '<a class="navbar-brand-link" id="logo" title="' .
            esc_attr( get_bloginfo( 'description' ) ) .
            '" href="' .
                esc_url( home_url( '/' ) ) .
        '">';
            //$output .= get_svg_icon('logo');

		  $output .= 'INSERT SVG';
            //$output .= '<img src="'.get_stylesheet_directory_uri().'/images/logo-white.svg" alt="Ithos Global" />';
        $output .= '</a>';
    $output .= '</div>';

    return $output;
}


//add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 3 );
function special_nav_class( $classes, $item, $args ) {
    if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location || 'footer-menu' === $args->theme_location) {
        $classes[] = 'nav-item';
    }

    return $classes;
}

add_filter( 'nav_menu_link_attributes', 'add_link_atts', 10, 3);
function add_link_atts($atts, $item, $args) {
    if ( 'primary' === $args->theme_location || 'footer-menu' === $args->theme_location ) {
        //debug($atts, true);
        //debug($args, true);
        if($args->depth == 0) {
            $atts['class'] = "nav-link ";
        }

        if(in_array('is-button', $item->classes)) {
            $atts['class'] = "btn btn-secondary btn-sm";
        }
    }

    if ( 'secondary' === $args->theme_location ) {
        $atts['class'] .= " nav-link ";

    }

    return $atts;

}
