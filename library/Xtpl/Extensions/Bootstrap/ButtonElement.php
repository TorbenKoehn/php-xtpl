<?php

namespace Xtpl\Extensions\Bootstrap;

class ButtonElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'BUTTON', $attributes );

        $this->ignoreAttribute( array( 'SIZE', 'THEME', 'BLOCK' ) );

        if( $this->hasAttribute( 'HREF' ) )
            $this->setTagName( 'A' );

        $classes = array( 'btn' );

        if( $this->hasAttribute( 'SIZE' ) ) {

            $size = $this->getAttribute( 'SIZE' );

            switch( $size ) {
                case 'large':
                    $classes[] = 'btn-lg';
                    break;
                case 'small':
                    $classes[] = 'btn-sm';
                    break;
                case 'extra-small':
                    $classes[] = 'btn-xs';
                    break;
            }
        }

        if( $this->hasAttribute( 'THEME' ) ) {

            $theme = $this->getAttribute( 'THEME' );

            switch( $theme ) {
                case 'default':
                    $classes[] = 'btn-default';
                    break;
                case 'primary':
                    $classes[] = 'btn-primary';
                    break;
                case 'danger':
                    $classes[] = 'btn-danger';
                    break;
                case 'success':
                    $classes[] = 'btn-success';
                    break;
                case 'info':
                    $classes[] = 'btn-info';
                    break;
                case 'warning':
                    $classes[] = 'btn-warning';
                    break;
                case 'link':
                    $classes[] = 'btn-link';
                    break;
            }
        }

        if( $this->hasAttribute( 'BLOCK' ) ) {

            if( $this->getAttribute( 'BLOCK' ) == 'true' )
                $this->addClass( 'btn-block' );
        }

        $this->addClass( implode( ' ', $classes ) );
    }
}