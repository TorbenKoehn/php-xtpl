<?php

namespace Xtpl\Extensions\Bootstrap\Media;

class ListElement extends \Xtpl\Extensions\Bootstrap\ListElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'media-list' );
    }
}