<?php

namespace Xtpl\Extensions\Bootstrap\Carousel;

class IndicatorsElement extends \Xtpl\Extensions\Bootstrap\ListElement {

    public function __construct( array $attributes = array() ) {
        $attributes[ 'TYPE' ] = 'ordered';
        parent::__construct( $attributes );

        $this->addClass( 'carousel-indicators' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

        }

        return parent::process();
    }
}