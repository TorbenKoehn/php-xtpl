<?php

namespace Xtpl\Extensions\Bootstrap;

class ListElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'UL', $attributes );

        $this->ignoreAttribute( 'TYPE' );

        if( $this->hasAttribute( 'TYPE' ) ) {

            switch( $this->getAttribute( 'TYPE' ) ) {
                case 'ordered':
                    $this->setTagName( 'OL' );
                    break;
                case 'unstyled':
                    $this->addClass( 'list-unstyled' );
                    break;
                case 'inline':
                    $this->addClass( 'list-inline' );
                    break;
            }
        }
    }
}