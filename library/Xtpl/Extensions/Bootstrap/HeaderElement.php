<?php

namespace Xtpl\Extensions\Bootstrap;

class HeaderElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'HEADER', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof DropdownElement ) {
                $this->setTagName( 'LI' );
                $this->addClass( 'dropdown-header' );
            }

            if( $this->getParent() instanceof NavbarElement ) {
                $this->setTagName( 'DIV' );
                $this->addClass( 'navbar-header' );
            }
        }

        return parent::process();
    }
}