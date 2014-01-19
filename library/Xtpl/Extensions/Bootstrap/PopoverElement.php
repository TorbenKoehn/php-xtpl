<?php

namespace Xtpl\Extensions\Bootstrap;

class PopoverElement extends DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        $compiled = null;
        if( !$this->isCompiled() ) {

            $this->ignoreAttribute( array( 'PLACEMENT', 'TITLE', 'TRIGGER', 'DELAY' ) );
            $id = 'xtpl-bootstrap-popover-'.$this->getUniqueId();
            $this->getParent()->addClass( $id );
            $this->getParent()->setAttribute( 'DATA-TOGGLE', 'tooltip' );

            $args = array();
            $compiled = parent::compile( $compiler, $cwd )->process();
            $args[ 'content' ] = $compiled->render();
            $args[ 'html' ] = true;
            $args[ 'container' ] = 'body';
            if( $this->hasAttribute( 'PLACEMENT' ) )
                $args[ 'placement' ] = $this->getAttribute( 'PLACEMENT' );
            if( $this->hasAttribute( 'TITLE' ) )
                $args[ 'title' ] = $this->getAttribute( 'TITLE' );
            if( $this->hasAttribute( 'TRIGGER' ) )
                $args[ 'trigger' ] = $this->getAttribute( 'TRIGGER' );
            if( $this->hasAttribute( 'DELAY' ) )
                $args[ 'delay' ] = $this->getAttribute( 'DELAY' );

            $this->addJs( "\$( '.$id' ).popover( ".json_encode( $args )." );" );
            $this->getParent()->removeChild( $this );
        }

        return $compiled ? $compiled : parent::compile( $compiler, $cwd );
    }
}