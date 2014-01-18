<?php

namespace Xtpl\Extensions\Bootstrap;

class HdlElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'DL', $attributes );

        $this->addClass( 'dl-horizontal' );
    }
}