<?php

namespace Xtpl\Extensions\Bootstrap\Table;

class ResponsiveElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'table-responsive' );
    }
}