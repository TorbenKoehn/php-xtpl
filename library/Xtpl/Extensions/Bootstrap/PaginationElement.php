<?php

namespace Xtpl\Extensions\Bootstrap;

class PaginationElement extends ListElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'pagination' );

        if( $this->hasAttribute( 'SIZE' ) ) {

            $size = $this->getAttribute( 'SIZE' );
            $this->ignoreAttribute( 'SIZE' );
            switch( $size ) {
                case 'large':
                case 'lg':
                    $this->addClass( 'pagination-lg' );
                    break;
                case 'small':
                case 'sm':
                    $this->addClass( 'pagination-sm' );
                    break;
            }
        }
    }
}