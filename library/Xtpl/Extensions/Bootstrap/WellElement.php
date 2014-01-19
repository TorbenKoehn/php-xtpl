<?php

namespace Xtpl\Extensions\Bootstrap;

class WellElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'well' );

        if( $this->hasAttribute( 'SIZE' ) ) {

            $size = $this->getAttribute( 'SIZE' );
            $this->ignoreAttribute( 'SIZE' );
            switch( $size ) {
                case 'large':
                case 'lg':
                    $this->addClass( 'well-lg' );
                    break;
                case 'small':
                case 'sm':
                    $this->addClass( 'well-sm' );
                    break;
            }
        }
    }
}