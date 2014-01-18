<?php

namespace Xtpl\Extensions\Bootstrap;

class TrElement extends Element {

    public function __construct( array $attributes = array(), $tagName = null ) {
        parent::__construct( $tagName ? $tagName : 'TR', $attributes );

        $this->ignoreAttribute( 'THEME' );

        if( $this->hasAttribute( 'THEME' ) ) {

            switch( $this->getAttribute( 'THEME' ) ) {
                case 'active':
                    $this->addClass( 'active' );
                    break;
                case 'success':
                    $this->addClass( 'success' );
                    break;
                case 'warning':
                    $this->addClass( 'warning' );
                    break;
                case 'danger':
                    $this->addClass( 'danger' );
                    break;
            }
        }
    }
}