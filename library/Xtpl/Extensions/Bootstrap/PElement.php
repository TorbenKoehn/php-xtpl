<?php

namespace Xtpl\Extensions\Bootstrap;

class PElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'P', $attributes );
    }
}