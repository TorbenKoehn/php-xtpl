<?php

namespace Xtpl\Extensions\Bootstrap;

class HeaderElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'HEADER', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof DropdownElement ) {
                $this->setTagName( 'LI' );
                $this->addClass( 'dropdown-header' );
            }

            if( $this->getParent() instanceof NavbarElement ) {
                $this->addClass( 'navbar-header' );
            }

            if( $this->getParent()->hasClass( 'media-body' ) ) {

                $size = 4;
                if( $this->hasAttribute( 'SIZE' ) ) {
                    $this->ignoreAttribute( 'SIZE' );
                    $size = intval( $this->getAttribute( 'SIZE' ) );
                }
                $this->setTagName( "H$size" );
                $this->addClass( 'media-heading' );
            }

            if( $this->getParent()->hasClass( 'list-group-item' ) ) {

                $size = 4;
                if( $this->hasAttribute( 'SIZE' ) ) {
                    $this->ignoreAttribute( 'SIZE' );
                    $size = intval( $this->getAttribute( 'SIZE' ) );
                }

                $this->setTagName( "H$size" );
                $this->addClass( 'list-group-item-heading' );
            }

            if( $this->getParent() instanceof PanelElement ) {

                $this->addClass( 'panel-heading' );
            }

            if( $this->getParent()->hasClass( 'modal-content' ) ) {

                $this->addClass( 'modal-header' );
            }
        }

        return parent::process();
    }
}