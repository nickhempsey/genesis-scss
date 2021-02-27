<?php

add_theme_support( 'genesis-footer-widgets', 5 );

/**
* Add bootstrap classes for footer widgets
*/
add_filter( 'genesis_footer_widget_areas', 'add_bootstrap_to_footer', 10 , 2 );
function add_bootstrap_to_footer( $output, $footer_widgets ){
    $footer_widgets = get_theme_support( 'genesis-footer-widgets' );

    if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
        return;

    $footer_widgets = (int) $footer_widgets[0];

    //* Check to see if first widget area has widgets. If not, do nothing. No need to check all footer widget areas.
    if ( ! is_active_sidebar( 'footer-1' ) )
        return;

    $inside  = '';
    $output  = '';
    $counter = 1;

    while ( $counter <= $footer_widgets ) {

        //* Darn you, WordPress! Gotta output buffer.
        ob_start();
        dynamic_sidebar( 'footer-' . $counter );
        $widgets = ob_get_clean();

        if($counter == 1) {
            $col = 'col-md-4';
        } else {
            $col = 'col-sm-6 col-md-2';
        }
        $inside .= sprintf( '<div class="widget-%s col-12 %s">%s</div>', $counter, $col, $widgets );

        $counter++;

    }

    if ( $inside ) {

        $output .= genesis_markup( array(
            'html5'   => '<div class="footer-widgets bg-dark-blue py-5" %s>' . genesis_sidebar_title( 'Footer' ),
            'xhtml'   => '<div id="footer-widgets" class="footer-widgets row-padding">',
            'context' => 'footer-widgets',
            'echo'    => false,
        ) );

            $output .= genesis_structural_wrap( 'footer-widgets', 'open', 0 );
                
                $output .= '<div class="row">';
                
                    $output .= $inside;
                
                $output.= '</div>';

            $output .= genesis_structural_wrap( 'footer-widgets', 'close', 0 );

        $output .= '</div>';

    }
    echo $output;
}



remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'bsg_do_footer' );

function bsg_do_footer() {
    ?>
    <div class="row">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <p>Copyright <?= date('Y'); ?> - .</p>
        </div>

        <div class="col-12 col-md-4 text-md-center mb-3 mb-md-0">
            <p>
                <a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-and-conditions">Terms and Conditions</a>
            </p>
        </div>

        <div class="col-12 col-md-4 text-md-right">
            <p>
                Built with <i class="fas fa-heart"></i> and <i class="fas fa-coffee-togo"></i> by <a href="https://" target="_blank">FILL THIS</a>
            </p>
        </div>
    </div>
    <?php
}