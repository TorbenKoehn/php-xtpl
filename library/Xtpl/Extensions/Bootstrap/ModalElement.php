<?php

namespace Xtpl\Extensions\Bootstrap;

class ModalElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        if( !$this->hasAttribute( 'NAME' ) )
            throw new \Exception( "Modals need a name attribute!" );

        $this->addClass( 'modal fade' );
        $this->ignoreAttribute( 'NAME' );
        $this->setAttribute( 'ID', 'xtpl-bootstrap-modal-'.$this->getAttribute( 'NAME' ) );
        $this->setAttribute( 'ROLE', 'dialog' );
        $this->setAttribute( 'ARIA-HIDDEN', 'true' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $dialog = new DivElement( array( 'CLASS' => 'modal-dialog' ) );
            $content = new DivElement( array( 'CLASS' => 'modal-content' ) );

            foreach( $this->getChildren() as $child )
                $content->addChild( $child );

            $this->addChild( $dialog );
            $dialog->addChild( $content );
        }

        return parent::process();
    }
}