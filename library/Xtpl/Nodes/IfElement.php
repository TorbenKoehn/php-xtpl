<?php

namespace Xtpl\Nodes;

class IfElement extends Element {

    public function __construct( array $attributes = array(), $isElseIf = false ) {
        parent::__construct( $isElseIf ? 'ELSE-IF' : 'IF', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            $expr = '';

            if( $this->hasAttribute( 'COND' ) )
                $expr = $this->getAttribute( 'COND' );
            else if( $this->hasAttribute( 'NOT-COND' ) )
                $expr = '!( '.$this->getAttribute( 'NOT-COND' ).' )';
            else if( $this->hasAttribute( 'EMPTY' ) )
                $expr = 'empty( $'.str_replace( '.', '->', $this->getAttribute( 'EMPTY' ) ).' )';
            else if( $this->hasAttribute( 'NOT-EMPTY' ) )
                $expr = '!empty( $'.str_replace( '.', '->', $this->getAttribute( 'NOT-EMPTY' ) ).' )';
            else if( $this->hasAttribute( 'SET' ) )
                $expr = 'isset( $'.str_replace( '.', '->', $this->getAttribute( 'SET' ) ).' )';
            else if( $this->hasAttribute( 'NOT-SET' ) )
                $expr = '!isset( $'.str_replace( '.', '->', $this->getAttribute( 'NOT-SET' ) ).' )';

            if( !empty( $expr ) ) {

                switch( $this->getTagName() ) {
                    default:
                    case 'IF':

                        $this->prependPhp( "if( $expr ):" );
                        //Make sure elses and ifelses are the very last children
                        $else = $this->find( 'ELSE' );
                        $elseIf = $this->find( 'ELSE-IF' );
                        
                        if( !empty( $elseIf ) )
                            $this->addChild( $elseIf[ 0 ] );

                        if( !empty( $else ) )
                            $this->addChild( $else[ 0 ] );

                        $this->addPhp( 'endif;' );
                        break;
                    case 'ELSE-IF':

                        //make sure this one is at the end the children of its parent, but before the closing php
                        $this->prependPhp( "elseif( $expr ):" );
                        break;
                }
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function render( $nice = false, $level = 0 ) {

        return $this->renderChildren( $nice, $level );
    }
}