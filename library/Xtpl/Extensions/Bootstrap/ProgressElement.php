<?php

namespace Xtpl\Extensions\Bootstrap;

class ProgressElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'progress' );

        if( $this->hasAttribute( 'THEME' ) ) {

            $styles = explode( ' ', $this->getAttribute( 'THEME' ) );
            foreach( $styles as $style )
                switch( $style ) {
                    case 'striped':
                        $this->addClass( 'progress-striped' );
                        break;
                    case 'active':
                        $this->addClass( 'active' );
                        break;
                }
        }
    }
}