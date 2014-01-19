<?php

namespace Xtpl\Extensions\Bootstrap;

class BreadcrumbElement extends ListElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->setTagName( 'OL' );
        $this->addClass( 'breadcrumb' );
    }
}