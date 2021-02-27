<?php

function debug( $var, $to_console=false ) {
    
	$backtrace = debug_backtrace();
	$caller = array_shift( $backtrace );
	
	if ( $to_console ) {
	    echo '<script>console.log("Line ' . $caller['line'] . ' of: ' . $caller['file'] . '");</script>';
	    echo '<script>console.log(' . json_encode($var, JSON_HEX_TAG) . ');</script>';
	} else {
	    echo 'Line <strong>' . $caller['line'] . '</strong> of: ' . $caller['file'];
	    echo '<pre>';
		   if ( is_array( $var ) || is_object( $var ) ) {
			  print_r( $var );
		   } elseif (is_string($var)) {
			  echo $var;
		   }
	    echo '</pre>';
	}
 
 }