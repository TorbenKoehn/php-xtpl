<?php

namespace Xtpl\Extensions\Bootstrap;

class ThElement extends TrElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes, 'TH' );
    }
}