<?php

namespace Xtpl\Extensions\Bootstrap;

class NavElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'NAV', $attributes );

        //Normally, this is a <nav> element, but when you set a type="", it's a <ul> element
        $this->ignoreAttribute( 'TYPE' );

        $types = explode( ' ', $this->getAttribute( 'TYPE' ) );

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
             || ( $this->getParent() instanceof CollapseElement && $this->getParent()->getParent() instanceof NavbarElement ) ) {

                $this->addClass( 'navbar-nav' );
            }
        }

        return parent::process();
    }
}