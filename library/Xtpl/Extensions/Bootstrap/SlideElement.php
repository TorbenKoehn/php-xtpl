<?php

namespace Xtpl\Extensions\Bootstrap;

class SlideElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'item' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

        }

        return parent::process();
    }
}