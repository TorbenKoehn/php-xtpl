<?php

namespace Xtpl\Extensions\Bootstrap;

class BrandElement extends AElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'navbar-brand' );
    }
}