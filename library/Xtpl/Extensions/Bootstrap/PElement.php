<?php

namespace Xtpl\Extensions\Bootstrap;

class PElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'P', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof NavbarElement 
             || ( ( $this->getParent() instanceof CollapseElement || $this->getParent() instanceof HeaderElement )
                && $this->getParent()->getParent() instanceof NavbarElement ) ) {

                $this->addClass( 'navbar-text' );

                if( $this->hasAttribute( 'ALIGN' ) ) {
                    $this->ignoreAttribute( 'ALIGN' );
                    switch( $this->getAttribute( 'ALIGN' ) ) {
                        case 'left':
                            $this->addClass( 'navbar-left' );
                            break;
                        case 'right':
                            $this->addClass( 'navbar-right' );
                    }
                }
            }
        }

        return parent::process();
    }
}