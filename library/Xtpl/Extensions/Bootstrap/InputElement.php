<?php

namespace Xtpl\Extensions\Bootstrap;

class InputElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'INPUT', $attributes );
    }
}