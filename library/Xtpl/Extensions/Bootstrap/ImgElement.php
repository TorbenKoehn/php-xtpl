<?php

namespace Xtpl\Extensions\Bootstrap;

class ImgElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'IMG', $attributes );

        $this->ignoreAttribute( 'TYPE' );
        if( $this->hasAttribute( 'TYPE' ) ) {
            switch( $this->getAttribute( 'TYPE' ) ) {
                case 'rounded':
                    $this->addClass( 'img-rounded' );
                    break;
                case 'circle':
                    $this->addClass( 'img-circle' );
                    break;
                case 'thumbnail':
                    $this->addClass( 'img-thumbnail' );
                    break;
                case 'responsive':
                    $this->addClass( 'img-thumbnail' );
                    break;
            }
        }
    }
}