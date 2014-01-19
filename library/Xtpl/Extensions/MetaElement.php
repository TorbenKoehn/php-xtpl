<?php

namespace Xtpl\Extensions;

class MetaElement extends \Xtpl\Nodes\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'META', $attributes );
    }
}