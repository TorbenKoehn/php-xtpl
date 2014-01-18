<?php

namespace Xtpl\Extensions\Bootstrap\Form;

class ControlElement extends \Xtpl\Extensions\Bootstrap\InputElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'form-control' );

        if( $this->hasAttribute( 'SIZE' ) ) {

            switch( $this->getAttribute( 'SIZE' ) ) {
                case 'large':
                case 'lg':
                    $this->addClass( 'input-lg' );
                    $this->ignoreAttribute( 'SIZE' );
                    break;
                case 'sm':
                case 'small':
                    $this->addClass( 'input-sm' );
                    $this->ignoreAttribute( 'SIZE' );
                    break;
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            //Maybe this is just plain text? then its a .form-control-static
            if( !$this->hasAttribute( 'TYPE' ) && !$this->hasAttribute( 'NAME' ) && $this->getText() != '' ) {
                $this->setTagName( 'P' );
                $this->removeClass( 'form-control' );
                $this->addClass( 'form-control-static' );
            }

            //Has it option elements? then it's a select
            if( count( $this->find( 'OPTION' ) ) ) {

                $this->setTagName( 'SELECT' );
            }
        }

        return parent::process();
    }
}