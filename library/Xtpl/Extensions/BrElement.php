<?php

namespace Xtpl\Extensions;

class BrElement extends \Xtpl\Nodes\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'BR', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->hasAttribute( 'REPEAT' ) ) {

                $this->ignoreAttribute( 'REPEAT' );
                $times = intval( $this->getAttribute( 'REPEAT' ) ) - 1;
                for( $i = 0; $i < $times; $i++ )
                    $this->getParent()->insertAfter( $this, new self );
            }
        }

        return parent::process();
    }
}