<?php

namespace Xtpl\Extensions\Bootstrap;

class LabelElement extends ColElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->setTagName( 'LABEL' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->hasAttribute( 'THEME' ) ) {

                $theme = $this->getAttribute( 'THEME' );
                $this->setTagName( 'SPAN' );
                $this->ignoreAttribute( 'THEME' );
                $this->addClass( 'label' );
                switch( $theme ) {
                    case 'default':
                        $this->addClass( 'label-default' );
                        break;
                    case 'primary':
                        $this->addClass( 'label-primary' );
                        break;
                    case 'success':
                        $this->addClass( 'label-success' );
                        break;
                    case 'info':
                        $this->addClass( 'label-info' );
                        break;
                    case 'warning':
                        $this->addClass( 'label-warning' );
                        break;
                    case 'danger':
                        $this->addClass( 'label-danger' );
                        break;
                }
            }

            if( $this->getParent() instanceof Form\GroupElement )
                $this->addClass( 'control-label' );
        }

        return parent::process();
    }
}