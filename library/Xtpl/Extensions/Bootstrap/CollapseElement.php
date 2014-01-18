<?php

namespace Xtpl\Extensions\Bootstrap;

class CollapseElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'collapse' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof NavbarElement )
                $this->addClass( 'navbar-collapse' );
        }

        return parent::process();
    }
}