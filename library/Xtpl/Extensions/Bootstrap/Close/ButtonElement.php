<?php

namespace Xtpl\Extensions\Bootstrap\Close;

class ButtonElement extends \Xtpl\Extensions\Bootstrap\ButtonElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'close' );
        $this->addChild( new \Xtpl\Nodes\TextNode( '&times;' ) );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof \Xtpl\Extensions\Bootstrap\AlertElement ) {

                $this->setAttribute( 'DATA-DISMISS', 'alert' );
                $this->setAttribute( 'ARIA-HIDDEN', 'true' );
                $this->getParent()->addClass( 'alert-dismissable' );
            }
        }

        return parent::process();
    }
}