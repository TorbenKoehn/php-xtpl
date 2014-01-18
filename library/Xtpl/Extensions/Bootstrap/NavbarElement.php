<?php

namespace Xtpl\Extensions\Bootstrap;

class NavbarElement extends NavElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

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

            switch( $this->getAttribute( 'FIXED' ) ) {
                case 'top':
                    $this->addClass( 'navbar-fixed-top' );
                    break;
                case 'bottom':
                    $this->addClass( 'navbar-fixed-bottom' );
                    break;
            }
        }

        if( $this->hasAttribute( 'STATIC' ) ) {

            switch( $this->getAttribute( 'STATIC' ) ) {
                case 'top':
                    $this->addClass( 'navbar-static-top' );
                    break;
                case 'bottom':
                    $this->addClass( 'navbar-static-bottom' );
                    break;
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {


        }

        return parent::process();
    }
}