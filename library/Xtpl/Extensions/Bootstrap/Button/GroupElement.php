<?php

namespace Xtpl\Extensions\Bootstrap\Button;

class GroupElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'btn-group' );
        $this->ignoreAttribute( array( 'SIZE', 'TYPE' ) );

        if( $this->hasAttribute( 'SIZE' ) ) {

            $size = $this->getAttribute( 'SIZE' );

            switch( $size ) {
                case 'large':
                case 'lg':
                    $this->addClass( 'btn-group-lg' );
                    break;
                case 'small':
                case 'sm':
                    $this->addClass( 'btn-group-sm' );
                    break;
                case 'extra-small':
                case 'xs':
                    $this->addClass( 'btn-group-xs' );
                    break;
            }
        }

        if( $this->hasAttribute( 'TYPE' ) ) {

            $size = $this->getAttribute( 'TYPE' );

            switch( $size ) {
                case 'vertical':
                    $this->removeClass( 'btn-group' );
                    $this->addClass( 'btn-group-vertical' );
                    break;
                case 'justified':
                    $this->addClass( 'btn-group-justified' );
                    break;
            }
        }
    }
}