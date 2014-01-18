<?php

namespace Xtpl\Extensions\Bootstrap\Input;

class GroupElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'input-group' );
        $this->ignoreAttribute( array( 'SIZE', 'TYPE' ) );

        if( $this->hasAttribute( 'SIZE' ) ) {

            $size = $this->getAttribute( 'SIZE' );

            switch( $size ) {
                case 'large':
                case 'lg':
                    $this->addClass( 'input-group-lg' );
                    break;
                case 'small':
                case 'sm':
                    $this->addClass( 'input-group-sm' );
                    break;
                case 'extra-small':
                case 'xs':
                    $this->addClass( 'input-group-xs' );
                    break;
            }
        }
    }
}