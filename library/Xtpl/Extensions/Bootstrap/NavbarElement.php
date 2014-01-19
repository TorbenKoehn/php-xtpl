<?php

namespace Xtpl\Extensions\Bootstrap;

class NavbarElement extends NavElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->ignoreAttribute( 'THEME' );
        switch( $this->getAttribute( 'THEME' ) ) {
            default:
            case 'default':
                $this->addClass( 'navbar-default' );
                break;
            case 'inverse':
                $this->addClass( 'navbar-inverse' );
                break;
        }

        if( $this->hasAttribute( 'FIXED' ) ) {

            //Interpolation doesn't work generally this way.
            //Better like this?
            $this->ignoreAttribute( 'FIXED' );
            $this->addClass( 'navbar-fixed-'.$this->getAttribute( 'FIXED' ) );
        }

        if( $this->hasAttribute( 'STATIC' ) ) {

            $this->ignoreAttribute( 'STATIC' );
            $this->addClass( 'navbar-static-'.$this->getAttribute( 'FIXED' ) );
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {


        }

        return parent::process();
    }
}