<?php

namespace Xtpl\Extensions\Bootstrap;

class AElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'A', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof PElement && $this->getParent()->hasClass( 'navbar-text' ) ) {

                $this->addClass( 'navbar-link' );
            }
        }

        return parent::process();
    }
}