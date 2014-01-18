<?php

namespace Xtpl\Extensions\Bootstrap;

class AddonElement extends SpanElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof Input\GroupElement )
                $this->addClass( 'input-group-addon' );
        }

        return parent::process();
    }
}