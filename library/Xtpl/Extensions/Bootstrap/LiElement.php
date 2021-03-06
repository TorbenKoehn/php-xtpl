<?php

namespace Xtpl\Extensions\Bootstrap;

class LiElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'LI', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof ListgroupElement ) {
                
                $this->addClass( 'list-group-item' );
            }
        }

        return parent::process();
    }
}