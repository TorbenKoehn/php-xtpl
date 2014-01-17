<?php

namespace Xtpl\Nodes;

class ElseElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'ELSE', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            if( $this->hasParent() && $this->getParent() instanceof IfElement ) {

                $this->prependPhp( "else:" );
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function render( $nice = false, $level = 0 ) {

        return $this->renderChildren( $nice, $level );
    }
}