<?php

namespace Xtpl\Extensions\Bootstrap;

class DividerElement extends LiElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'divider' );
    }
}