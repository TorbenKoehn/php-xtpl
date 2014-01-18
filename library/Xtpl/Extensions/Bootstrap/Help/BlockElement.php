<?php

namespace Xtpl\Extensions\Bootstrap\Help;

class BlockElement extends \Xtpl\Extensions\Bootstrap\PElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'help-block' );
    }
}