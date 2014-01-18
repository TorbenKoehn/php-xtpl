<?php

namespace Xtpl\Extensions\Bootstrap;

class AElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'A', $attributes );
    }
}