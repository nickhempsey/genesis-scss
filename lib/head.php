<?php

// remove default doctype
// replace doctype/opening html tag with conditional comments doctype/opening html tag
remove_action(  'genesis_doctype', 'genesis_do_doctype' );
add_action(     'genesis_doctype', 'bsg_conditional_comments' );

function bsg_conditional_comments() {
	if(!is_page('compare-bundles')) {
		$overflow = 'overflow-x-hidden';
	}
   ?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" dir="ltr" lang="en-US"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js wrighttechnologies <?= $overflow; ?>" dir="ltr" lang="en-US"><!--<![endif]-->
<?php /*
 // add IE conditional comments to html element
 // http://www.paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/
 */ ?>
<head profile="http://gmpg.org/xfn/11">
<meta charset="UTF-8" />
   <?php
}

/**
 * Remove the .no-js class from the html element via JavaScript
 *
 * This allows styles targetting browsers without JavaScript
 */

add_action( 'wp_head', 'bsg_remove_no_js_class', 1 );

function bsg_remove_no_js_class() {
    echo "<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>";
}


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