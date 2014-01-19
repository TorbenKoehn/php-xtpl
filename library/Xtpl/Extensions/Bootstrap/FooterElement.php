<?php

namespace Xtpl\Extensions\Bootstrap;

class FooterElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'FOOTER', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof PanelElement ) {

                $this->addClass( 'panel-footer' );
            }

            if( $this->getParent()->hasClass( 'modal-content' ) ) {

                $this->addClass( 'modal-footer' );
            }
        }

        return parent::process();
    }
}