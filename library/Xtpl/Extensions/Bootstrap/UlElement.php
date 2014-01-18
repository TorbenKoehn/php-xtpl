<?php

namespace Xtpl\Extensions\Bootstrap;

class UlElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'UL', $attributes );
    }
}