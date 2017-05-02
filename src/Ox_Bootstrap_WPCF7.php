<?php 
/*
 * Plugin for wordpress & contact form 7.
 * When wordpress contact form 7 render the form html
 * this plugin add class from bootstrap to form inputs
 * 
 * @author Mikolaj Jeziorny <mikijezi@gmail.com>
 */

use Ox_Bootstrap_WPCF7;


if( ! class_exists( 'Ox_Bootstrap_WPCF7' ) ):

/*
 * Class with configuration & initialization
 * of this plugin
 *
 * @package Ox_Bootstrap_WPCF7
 */
class Ox_Bootstrap_WPCF7 {

    /*
     * @var mixed[] $cfg default configuration
     */
    private $cfg = array(
        'delimiter'     => ';',
        'priority'      => 99,
        'class__for'    => array(
            'input'    => 'form-control',
            'select'   => 'form-control',
            'textarea' => 'form-control',
            'submit'   => 'btn btn-primary',
        ),
    );

    /*
     * @var mixed[] $re regexps to search inputs in form
     */
    private $re = array(
        'input'     => '\<input\s*type\s*=\s*\"\s*(text|date|email|tel|number)\s*\".*class\s*=\s*\"([\w\-\s]*)\"(.*)\/\>',
        'submit'    => '\<input\s*type\s*=\s*\"\s*(submit)\s*\".*class\s*=\s*\"([\w\-\s]*)\"(.*)\/\>',
        'textarea'  => '\<textarea\s*(.*)class\s*=\s*\"([\w\-\s]*)\"(.*)\s*\>(.*)\<\/textarea\>',
        'select'    => '\<select\s*(.*)class\s*=\s*\"([\w\-\s]*)\"(.*)\s*\>(.*)\<\/select\>'
    );

    /*
     * Create instance of this class with config
     *
     * @param mixed[] $cfg (optional) configuration for plugin
     * @return Ox_Bootstrap_WPCF7
     */
    public static function init ( $cfg = [] ) {
        return new self ( $cfg );
    }

    /*
     * Constuctor for plugin
     * 
     * @param mixed[] $cfg (optional) configuration for plugin
     */
    private function __construct ( $cfg = [] ) {
        $this->cfg = wp_parse_args( $cfg, $this->cfg );
        add_filter( 'wpcf7_form_elements', [ $this, 'callback' ], $this->cfg[ 'priority' ], true );
    }

    /**
     * Callback for filter
     *
     * @param string $html
     * @return string rendered html
     */
    public function callback ( $html ) {

        foreach ( $this->re as $type => $re ) {

            $html = $this->work (
                $this->delimiter( $re ),
                $html,
                $this->cfg[ 'class__for' ][ $type ]
            );
        }

        return $html;
    }
    
    /*
     * Search input by regex and add class form-control
     * from bootstrap
     * 
     * @param string $re         regexp for search
     * @param string $html       rendered html from contact form 7
     * @param string $class      string with class to add
     * @return string $html
     */
    private function work ( $re, $html, $class ) {

        preg_match_all( $re, $html, $matches, PREG_SET_ORDER, 0 );
        
        if( empty( $matches ) ) return $html;

        foreach( $matches as $input ) {

            $full       = $input[ 0 ];
            $classes    = $input[ 2 ];

            $classes_arr = explode( ' ', $classes );
            array_push( $classes_arr, $class );
            array_unique( $classes_arr, SORT_STRING );

            $classes_new = join( ' ', $classes_arr );

            $full_new   = str_replace( $classes, $classes_new, $full );
            $html       = str_replace( $full,    $full_new,  $html );
        }
        
        return $html;
    }
    
    /*
     * Add delimiter to regexp
     * 
     * 
     * @param string $str regular expresion
     * @return string regular expresion with delimiter
     */
    private function delimiter ( $str ) {
        return sprintf ( '%1$s%2$s%1$s', $this->cfg[ 'delimiter' ], $str );
    }
}

endif;

