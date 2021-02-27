<?php

add_filter( 'genesis_attr_title-area', 'bsg_title_area_markup' );
/**
 * Replace `title-area` class with a ID for div.title-area
 *
 * @param array $attributes attributes of HTML element which are assembled into the output.
 * @return attributes of HTML element which are assembled into the output.
 */
function bsg_title_area_markup( $attributes ) {
    $attributes['class'] = 'title-area';

    return $attributes;
}

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );


//add_action('wp_head', 'bsg_hotjar');
function bsg_hotjar() {
    ?>
<!-- Hotjar Tracking Code for https://ingredientsafe.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1940940,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
    <?php
}
