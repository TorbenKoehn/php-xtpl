<?php

namespace Xtpl\Extensions\Bootstrap;

class TabsElement extends NavElement {

    protected $contentElement;

    public function __construct( array $attributes = array() ) {

        if( empty( $attributes[ 'TYPE' ] ) ) {
            $attributes[ 'TYPE' ] = 'tabs';
        }

        parent::__construct( $attributes );

        $ce = new DivElement( array( 'CLASS' => 'tab-content' ) );
        $this->contentElement = $ce;
    }

    public function getContentElement() {

        return $this->contentElement;
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $this->getParent()->insertAfter( $this, $this->contentElement );
        }

        $result = parent::process();

        if( $this->hasClass( 'fade' ) )
            $this->removeClass( 'fade' );

        return $result;
    }
}