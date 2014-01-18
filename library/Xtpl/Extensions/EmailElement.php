<?php

namespace Xtpl\Extensions;

class EmailElement extends \Xtpl\Nodes\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'A', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $this->setAttribute( 'HREF', 'mailto:'.$this->getText() );
        }

        return parent::process();
    }
}