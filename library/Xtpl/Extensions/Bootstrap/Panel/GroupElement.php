<?php

namespace Xtpl\Extensions\Bootstrap\Panel;

class GroupElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'panel-group' );
    }
}