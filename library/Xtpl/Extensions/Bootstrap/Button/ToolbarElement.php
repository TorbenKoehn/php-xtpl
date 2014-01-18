<?php

namespace Xtpl\Extensions\Bootstrap\Button;

class ToolbarElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'btn-toolbar' );
        $this->setAttribute( 'ROLE', 'toolbar' );
    }
}