<?php

namespace Xtpl\Extensions\Bootstrap;

class BadgeElement extends SpanElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'badge' );
    }
}