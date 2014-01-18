<?php

namespace Xtpl\Extensions\Bootstrap;

class SpanElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'SPAN', $attributes );
    }
}