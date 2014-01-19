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

            if( $this->getParent() instanceof AlertElement ) {

                $this->addClass( 'alert-link' );
            }

            if( $this->getParent() instanceof ListgroupElement ) {

                $this->addClass( 'list-group-item' );
                $this->getParent()->setTagName( 'DIV' );
            }
        }

        return parent::process();
    }
}