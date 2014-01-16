<?php

namespace Xtpl\Extensions;

class MenuElement extends \Xtpl\Nodes\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'UL', $attributes );

        $this->ignoreAttribute( 'ORIENTATION' );
    }
}