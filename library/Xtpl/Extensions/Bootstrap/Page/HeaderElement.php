<?php

namespace Xtpl\Extensions\Bootstrap\Page;

class HeaderElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'page-header' );
    }
}