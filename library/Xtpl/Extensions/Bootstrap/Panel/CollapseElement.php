<?php

namespace Xtpl\Extensions\Bootstrap\Panel;

class CollapseElement extends \Xtpl\Extensions\Bootstrap\CollapseElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $id = 'xtpl-bootstrap-panel-collapse-'.$this->getUniqueId();
        $this->setAttribute( 'ID', $id );
        $this->addClass( 'panel-collapse' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent( 2 ) instanceof \Xtpl\Extensions\Bootstrap\AccordionElement ) {

                //Search for a-element
                $header = $this->getPrevious();

                if( $header ) {

                    $result = $header->find( 'A', array( 'DATA-TOGGLE' => 'collapse' ) );
                    $a = end( $result );
                    if( $a )
                        $a->setAttribute( 'HREF', '#'.$this->getAttribute( 'ID' ) );
                }

                //Check if were the first to show
                if( $this->getParent( 2 )->getFirstChild() === $this->getParent() )
                    $this->addClass( 'in' );
            }
        }

        return parent::process();
    }
}