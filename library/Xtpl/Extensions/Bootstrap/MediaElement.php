<?php

namespace Xtpl\Extensions\Bootstrap;

class MediaElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'DIV', $attributes );

        $this->addClass( 'media' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof Media\ListElement ) {

                $this->setTagName( 'LI' );
            }
        }

        return parent::process();
    }
}