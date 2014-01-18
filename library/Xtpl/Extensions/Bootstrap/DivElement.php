<?php

namespace Xtpl\Extensions\Bootstrap;

class DivElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'DIV', $attributes );
    }
}