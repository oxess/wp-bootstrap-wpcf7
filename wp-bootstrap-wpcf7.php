<?php

define( "DELIMITER", ";" );
define( "INPUT_TYPES", "text|date|email|tel|number" );

define( "INPUT_PRIMARY_REGEXP",  DELIMITER . '\<input\s*type\s*=\s*\"\s*(' . INPUT_TYPES . ')\s*\".*class\s*=\s*\"([\w\-\s]*)\"(.*)\/\>'    . DELIMITER );
define( "INPUT_TEXTAREA_REGEXP", DELIMITER . '\<textarea\s*(.*)class\s*=\s*\"([\w\-\s]*)\"(.*)\s*\>(.*)\<\/textarea\>'                      . DELIMITER );
define( "INPUT_SELECT_REGEXP",   DELIMITER . '\<select\s*(.*)class\s*=\s*\"([\w\-\s]*)\"(.*)\s*\>(.*)\<\/select\>'                          . DELIMITER );

if( ! function_exists( 'ox_search_and_replace' ) ):

/*
 * Search input by regex and add class form-control
 * from bootstrap
 * 
 * @param String $re       regexp for search
 * @param String $html     rendered html from contact form 7
 * @return $html
 */
function ox_search_and_replace( $re, $html ) {

    preg_match_all( $re, $html, $matches, PREG_SET_ORDER, 0 );
    
    if( empty( $matches ) ) return $html;

    foreach( $matches as $input ) {

        $full  = $input[ 0 ];
        $class = $input[ 2 ];

        $class_arr = explode( ' ', $class );
        array_push( $class_arr, 'form-control' );
        array_unique( $class_arr, SORT_STRING );

        $class_new = join( ' ', $class_arr );

        $full_new   = str_replace( $class, $class_new, $full );
        $html       = str_replace( $full,  $full_new,  $html );
    }
    
    return $html;
}

endif;

/**
 * Finish render html
 *
 * @param $html
 * @return $html
 */
add_filter( 'wpcf7_form_elements', function( $html ) {

    $html = ox_search_and_replace( INPUT_PRIMARY_REGEXP,  $html );
    $html = ox_search_and_replace( INPUT_TEXTAREA_REGEXP, $html );
    $html = ox_search_and_replace( INPUT_SELECT_REGEXP,   $html );

    return $html;
} );
