<?php

namespace Xtpl\Extensions\Bootstrap\Carousel;

class ControlElement extends \Xtpl\Extensions\Bootstrap\AElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->ignoreAttribute( array( 'DIRECTION', 'ICON' ) );
        $this->addClass( 'carousel-control' );
        switch( $this->getAttribute( 'DIRECTION' ) ) {
            default:
            case 'left':
                $this->addClass( 'left' );
                $this->setAttribute( 'DATA-SLIDE', 'prev' );
                break;
            case 'right':
                $this->addClass( 'right' );
                $this->setAttribute( 'DATA-SLIDE', 'next' );
                break;
        }
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            if( $this->getParent() instanceof \Xtpl\Extensions\Bootstrap\CarouselElement ) {

                $this->setAttribute( 'HREF', '#'.$this->getParent()->getAttribute( 'ID' ) );

                $icon = $this->hasAttribute( 'ICON' ) ? $this->getAttribute( 'ICON' ) : null;

                if( !$icon ) {
                    switch( $this->getAttribute( 'DIRECTION' ) ) {
                        default:
                        case 'left':
                            $icon = 'chevron-left';
                            break;
                        case 'right':
                            $icon = 'chevron-right';
                            break;
                    }
                }

                $this->addChild( new \Xtpl\Extensions\Bootstrap\IconElement( array( 'TYPE' => $icon ) ) );
            }
        }

        return parent::compile( $compiler, $cwd );
    }
}