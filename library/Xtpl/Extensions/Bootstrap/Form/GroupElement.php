<?php

namespace Xtpl\Extensions\Bootstrap\Form;

class GroupElement extends \Xtpl\Extensions\Bootstrap\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'DIV', $attributes );

        $this->ignoreAttribute( 'THEME' );
        $this->addClass( 'form-group' );

        if( $this->hasAttribute( 'THEME' ) ) {

            $theme = $this->getAttribute( 'THEME' );

            switch( $theme ) {
                case 'success':
                    $this->addClass( 'has-success' );
                    break;
                case 'warning':
                    $this->addClass( 'has-warning' );
                    break;
                case 'error':
                    $this->addClass( 'has-error' );
                    break;
            }
        }
    }
}