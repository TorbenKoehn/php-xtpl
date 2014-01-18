<?php

namespace Xtpl\Extensions\Bootstrap;

class TdElement extends TrElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes, 'TD' );
    }
}