<?php

namespace Xtpl\Nodes;

class VarElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'VAR', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            if( $this->hasAttribute( 'NAME' ) ) {

                if( $this->hasAttribute( 'VALUE' ) ) {

                    $this->addPhp( '$'.$this->getAttribute( 'NAME' ).' = \''.$this->getAttribute( 'VALUE' ).'\';' );
                } else {

                    $this->addPhp( 'echo $'.$this->getAttribute( 'NAME' ).';' );
                }
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function render( $nice = false, $level = 0 ) {

        if( $this->hasAttribute( 'NAME' ) ) {

            //render only the children, since this is the var-command, not the HTML tag
            return $this->renderChildren( $nice, $level );
        }

        //else we just render the normal var-tag
        return parent::render( $nice, $level );
    }
}