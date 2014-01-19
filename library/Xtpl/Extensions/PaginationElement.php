<?php

namespace Xtpl\Extensions\Bootstrap;

class PaginationElement extends ListElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'pagination' );
    }
}