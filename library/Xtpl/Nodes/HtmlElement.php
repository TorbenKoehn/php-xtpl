<?php

namespace Xtpl\Nodes;

class HtmlElement extends Element {

    protected $version;

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'HTML', $attributes );

        $this->ignoreAttribute( 'VERSION' );
    }

    public function render( $nice = false, $level = 0 ) {

        $html = '';

        if( $this->hasAttribute( 'VERSION' ) ) {
            //Doctype implementations
            switch( $this->getAttribute( 'VERSION' ) ) {
                default:
                case 5:
                    $html = '<!doctype html>';
            }
        }

        return $html.parent::render( $nice, $level );
    }
}