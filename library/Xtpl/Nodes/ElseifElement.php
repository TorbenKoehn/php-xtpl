<?php

namespace Xtpl\Nodes;

class ElseifElement extends IfElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes, true );
    }
}