<?php

namespace Xtpl\Extensions\Bootstrap;

class LabelElement extends ColElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->setTagName( 'LABEL' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof Form\GroupElement )
                $this->addClass( 'control-label' );
        }

        return parent::process();
    }
}