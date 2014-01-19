<?php

namespace Xtpl\Extensions\Bootstrap;

class AlertElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'alert' );
        if( $this->hasAttribute( 'THEME' ) ) {

            $this->ignoreAttribute( 'THEME' );
            switch( $this->getAttribute( 'THEME' ) ) {
                case 'success':
                    $this->addClass( 'alert-success' );
                    break;
                case 'info':
                    $this->addClass( 'alert-info' );
                    break;
                case 'warning':
                    $this->addClass( 'alert-warning' );
                    break;
                case 'danger':
                    $this->addClass( 'alert-danger' );
                    break;
            }
        }
    }
}