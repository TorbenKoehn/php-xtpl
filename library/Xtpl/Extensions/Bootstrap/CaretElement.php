<?php

namespace Xtpl\Extensions\Bootstrap;

class CaretElement extends SpanElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'caret' );
    }
}