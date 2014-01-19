<?php

namespace Xtpl\Extensions\Bootstrap\Close;

class ButtonElement extends \Xtpl\Extensions\Bootstrap\ButtonElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( trim( $this->getText() ) == '' ) {
                $this->setAttribute( 'ARIA-HIDDEN', 'true' );
                $this->addClass( 'close' );
                $this->addChild( new \Xtpl\Nodes\TextNode( '&times;' ) );
            }

            if( $this->getParent() instanceof \Xtpl\Extensions\Bootstrap\AlertElement ) {

                $this->setAttribute( 'DATA-DISMISS', 'alert' );
                $this->getParent()->addClass( 'alert-dismissable' );
            }

            if( $this->getParent()->hasClass( 'modal-header', 'modal-content', 'modal-body', 'modal-footer', 'modal-header', 'modal-dialog', 'modal' ) > 0 ) {

                $this->setAttribute( 'DATA-DISMISS', 'modal' );
            }
        }

        return parent::process();
    }
}