<?php

namespace Xtpl\Extensions\Bootstrap;

class RowElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'row' );
    }
}