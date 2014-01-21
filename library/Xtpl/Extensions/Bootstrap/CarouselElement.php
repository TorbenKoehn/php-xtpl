<?php

namespace Xtpl\Extensions\Bootstrap;

class CarouselElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        if( !$this->hasAttribute( 'ID' ) )
            $this->setAttribute( 'ID', 'xtpl-bootstrap-carousel-'.$this->getUniqueId() );
        $this->ignoreAttribute( 'CONTROLS', 'INDICATORS', 'ICON-LEFT', 'ICON-RIGHT' );
        $this->addClass( 'carousel slide' );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            $controls = $this->hasAttribute( 'CONTROLS' ) ? $this->getAttribute( 'CONTROLS' ) : 'all';
            $indicators = $this->hasAttribute( 'INDICATORS' ) && $this->getAttribute( 'INDICATORS' ) == 'false' ? false : true;

            $inner = $this->wrapInner( new DivElement() );
            $inner->addClass( 'carousel-inner' );
            if( !empty( $controls ) ) {

                $controls = explode( ' ', $controls );
                foreach( $controls as $control ) {
                    switch( $control ) {
                        case 'left':
                            $this->addChild( new Carousel\ControlElement( array( 
                                'ICON' => $this->getAttribute( 'ICON-LEFT' ) 
                            ) ) );
                            break;
                        case 'right':
                            $this->addChild( new Carousel\ControlElement( array( 
                                'ICON' => $this->getAttribute( 'ICON-RIGHT' ),
                                'DIRECTION' => 'right'
                            ) ) );
                            break;
                        case 'all':
                            $this->addChild( new Carousel\ControlElement( array( 
                                'ICON' => $this->getAttribute( 'ICON-LEFT' ) 
                            ) ) );
                            $this->addChild( new Carousel\ControlElement( array( 
                                'ICON' => $this->getAttribute( 'ICON-RIGHT' ),
                                'DIRECTION' => 'right'
                            ) ) );
                            break 2;
                    }
                 }
            }

            if( $indicators ) {
                $slides = $this->find( 'DIV' );

                $slideCount = 0;
                $active = -1;
                $firstSlide = null;
                foreach( $slides as $slide )
                    if( $slide instanceof SlideElement ) {
                        if( !$firstSlide )
                            $firstSlide = $slide;
                        $slideCount++;
                        $inner->addChild( $slide );
                        if( $slide->hasClass( 'active' ) )
                            $active = $slideCount - 1;
                    }

                if( $active < 0 && $firstSlide ) {
                    $active = 0;
                    $firstSlide->addClass( 'active' );
                }

                $ind = $this->prependChild( new Carousel\IndicatorsElement() );
                while( $slideCount-- ) {
                    $li = $ind->prependChild( new LiElement() );
                    $li->setAttribute( 'DATA-TARGET', '#'.$this->getAttribute( 'ID' ) );
                    $li->setAttribute( 'DATA-SLIDE-TO', $slideCount );
                    if( $active === $slideCount )
                        $li->addClass( 'active' );
                }
            }

        }

        return parent::compile( $compiler, $cwd );
    }
}