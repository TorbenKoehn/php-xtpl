<?php

namespace Xtpl\Extensions\Bootstrap\Media;

class ObjectElement extends \Xtpl\Extensions\Bootstrap\ImgElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'media-object' );
    }
}