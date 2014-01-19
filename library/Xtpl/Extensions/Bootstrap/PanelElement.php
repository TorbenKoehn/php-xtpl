<?php

namespace Xtpl\Extensions\Bootstrap;

class PanelElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'panel' );
        if( $this->hasAttribute( 'THEME' ) ) {

            $this->ignoreAttribute( 'THEME' );
            switch( $this->getAttribute( 'THEME' ) ) {
                case 'default':
                    $this->addClass( 'panel-default' );
                    break;
                case 'primary':
                    $this->addClass( 'panel-primary' );
                    break;
                case 'success':
                    $this->addClass( 'panel-success' );
                    break;
                case 'info':
                    $this->addClass( 'panel-info' );
                    break;
                case 'warning':
                    $this->addClass( 'panel-warning' );
                    break;
                case 'danger':
                    $this->addClass( 'panel-danger' );
                    break;
            }
        }
    }
}