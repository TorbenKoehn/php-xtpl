<?php

namespace Xtpl\Extensions\Bootstrap;

class NavElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'NAV', $attributes );

        //Normally, this is a <nav> element, but when you set a type="", it's a <ul> element
        $this->ignoreAttribute( 'TYPE' );

        $types = array_filter( explode( ' ', $this->getAttribute( 'TYPE' ) ), function( $value ) {

            return !empty( $value );
        } );

        if( !empty( $types ) ) {

            $this->setTagName( 'UL' );
            $this->addClass( 'nav' );
            foreach( $types as $type )
                switch( $type ) {
                    case 'tabs':

                        $this->addClass( 'nav-tabs' );
                        break;
                    case 'pills':

                        $this->addClass( 'nav-pills' );
                        break;
                    case 'stacked':

                        $this->addClass( 'nav-stacked' );
                        break;
                    case 'justified':

                        $this->addClass( 'nav-justified' );
                        break;
                }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof NavbarElement 
             || ( ( $this->getParent() instanceof CollapseElement || $this->getParent() instanceof HeaderElement )
                && $this->getParent()->getParent() instanceof NavbarElement ) ) {
                
                $this->setTagName( 'UL' );
                $this->addClass( 'nav navbar-nav' );

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