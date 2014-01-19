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
                case 'lg':
                    $classes[] = 'btn-lg';
                    break;
                case 'small':
                case 'sm':
                    $classes[] = 'btn-sm';
                    break;
                case 'extra-small':
                case 'xs':
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
                $classes[] = 'btn-block';
        }

        $this->addClass( implode( ' ', $classes ) );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof Input\GroupElement ) {
                $span = new SpanElement( array( 'CLASS' => 'input-group-btn' ) );
                $this->getParent()->insertBefore( $this, $span );
                $span->addChild( $this );
            }

            if( $this->getParent() instanceof NavbarElement 
             || ( ( $this->getParent() instanceof CollapseElement || $this->getParent() instanceof HeaderElement )
                && $this->getParent()->getParent() instanceof NavbarElement ) ) {
                
                $this->addClass( 'navbar-btn' );

                if( $this->hasAttribute( 'ALIGN' ) ) {
                    $this->ignoreAttribute( 'ALIGN' );
                    switch( $this->getAttribute( 'ALIGN' ) ) {
                        case 'left':
                            $this->addClass( 'navbar-left' );
                            break;
                        case 'right':
                            $this->addClass( 'navbar-right' );
                    }
                }
            }
        }

        return parent::process();
    }
}