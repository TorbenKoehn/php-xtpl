<?php

namespace Xtpl\Extensions\Bootstrap;

class RadioElement extends Element {

    protected $display = true;

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'DIV', $attributes );

        $this->ignoreAttribute( 'TYPE' );
        $this->addClass( 'radio' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->hasAttribute( 'TYPE' ) ) {
                switch( $this->getAttribute( 'TYPE' ) ) {
                    case 'inline':

                        $labels = $this->find( 'LABEL' );
                        foreach( $labels as $label )
                            $label->addClass( 'radio-inline' );

                        $this->display = false;
                        break;
                }
            }
        }

        return parent::process();
    }

    public function render( $nice = false, $level = 0 ) {

        if( $this->display )
            return parent::render();

        return $this->renderChildren( $nice, $level );
    }
}