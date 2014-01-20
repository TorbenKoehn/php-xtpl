<?php

namespace Xtpl\Extensions\Bootstrap;

class AccordionElement extends Panel\GroupElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $id = 'xtpl-bootstrap-accordion-'.$this->getUniqueId();
        $this->setAttribute( 'ID', $id );
    }

    public function process() {

        if( !$this->isProcessed() ) {

        }

        return parent::process();
    }
}