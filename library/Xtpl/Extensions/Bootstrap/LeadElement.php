<?php

namespace Xtpl\Extensions\Bootstrap;

class LeadElement extends PElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'lead' );
    }
}