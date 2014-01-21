<?php

namespace Xtpl\Extensions\Bootstrap;

class IconElement extends SpanElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        if( $this->hasAttribute( 'TYPE' ) ) {

            $this->ignoreAttribute( 'TYPE' );
            $icon = $this->getAttribute( 'TYPE' );

            if( $icon == 'bar' )
                $this->addClass( 'icon-bar' );
            else
                $this->addClass( "glyphicon glyphicon-$icon" );
        }
    }
}