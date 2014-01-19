<?php

namespace Xtpl\Extensions\Bootstrap;

class ThumbnailElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        if( $this->hasAttribute( 'HREF' ) )
            $this->setTagName( 'A' );

        $this->addClass( 'thumbnail' );
    }
}