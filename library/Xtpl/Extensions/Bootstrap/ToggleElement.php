<?php

namespace Xtpl\Extensions\Bootstrap;

class ToggleElement extends ButtonElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof HeaderElement && $this->getParent()->getParent() instanceof NavbarElement ) {

                $collapse = array_values( array_filter( $this->getParent()->getParent()->find( 'DIV' ), function( $value ) {

                    return $value instanceof CollapseElement;
                } ) );

                if( !empty( $collapse ) ) {

                    $collapse = $collapse[ 0 ];
                    $uid = $collapse->getUniqueId();
                    $collapse->addClass( $uid );
                    $this->addClass( 'navbar-toggle' );
                    $this->setAttribute( 'DATA-TOGGLE', 'collapse' );
                    $this->setAttribute( 'DATA-TARGET', ".$uid" );
                }
            }
        }

        return parent::process();
    }
}