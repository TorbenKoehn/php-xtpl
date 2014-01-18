<?php

namespace Xtpl\Extensions\Bootstrap;

class FormElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'FORM', $attributes );

        $this->ignoreAttribute( 'TYPE' );
        if( $this->hasAttribute( 'TYPE' ) ) {
            switch( $this->getAttribute( 'TYPE' ) ) {
                case 'inline':
                    $this->addClass( 'form-inline' );
                    break;
                case 'horizontal':
                    $this->addClass( 'form-horizontal' );
                    break;
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof NavbarElement 
             || ( $this->getParent() instanceof CollapseElement && $this->getParent()->getParent() instanceof NavbarElement ) ) {

                $this->addClass( 'navbar-form' );
            }
        }

        return parent::process();
    }
}