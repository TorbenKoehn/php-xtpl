<?php

namespace Xtpl\Nodes;

class ForElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'FOR', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            if( $this->hasAttribute( 'EACH' ) && $this->hasAttribute( 'AS' ) ) {
                //it's a foreach( $arr as $key => $val ) loop

                $as = $this->hasAttribute( 'KEY' ) ? '$'.$this->getAttribute( 'KEY' ).' => $'.$this->getAttribute( 'AS' ) : '$'.$this->getAttribute( 'AS' );
                $this->prependPhp( 'foreach( $'.$this->getAttribute( 'EACH' ).' as '.$as.' ):' );
                $this->addPhp( 'endforeach;' );
            }

            if( $this->hasAttribute( 'TIMES' ) ) {

                $start = $this->hasAttribute( 'FIRST' ) ? intval( $this->getAttribute( 'FIRST' ) ) : 0;
                $as = $this->hasAttribute( 'AS' ) ? $this->getAttribute( 'AS' ) : '_xtplLoopCounter';
                $end = $start + intval( $this->getAttribute( 'TIMES' ) );
                $this->prependPhp( 'for( $'.$as.' = '.$start.'; $'.$as.' < '.$end.'; $'.$as.'++ ):' );
                $this->addPhp( 'endfor;' );
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function render( $nice = false, $level = 0 ) {

        return $this->renderChildren( $nice, $level );
    }
}