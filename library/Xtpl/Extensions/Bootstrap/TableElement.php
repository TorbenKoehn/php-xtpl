<?php

namespace Xtpl\Extensions\Bootstrap;

class TableElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'TABLE', $attributes );

        $this->ignoreAttribute( 'THEME' );

        if( $this->hasAttribute( 'THEME' ) ) {

            $this->addClass( 'table' );
            $styles = explode( ' ', $this->getAttribute( 'THEME' ) );
            foreach( $styles as $style )
                switch( $style ) {
                    case 'striped':
                        $this->addClass( 'table-striped' );
                        break;
                    case 'bordered':
                        $this->addClass( 'table-bordered' );
                        break;
                    case 'hover':
                        $this->addClass( 'table-hover' );
                        break;
                    case 'condensed':
                        $this->addClass( 'table-condensed' );
                        break;
                }
        }
    }
}