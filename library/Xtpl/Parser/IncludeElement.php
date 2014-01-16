<?php

namespace Xtpl\Parser;

class IncludeElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'INCLUDE', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {
            if( $this->hasAttribute( 'FILE' ) ) {

                $includePath = $cwd.DIRECTORY_SEPARATOR.$this->getAttribute( 'FILE' );
                $xtpl = $compiler->parseFile( $includePath, $realPath );
                $xtpl->compile( $compiler, dirname( $realPath ) );

                //Apply arguments on templates (Even on extended ones, yay!)
                $this->applyArgs( $xtpl );

                $this->addChild( $xtpl->getRoot() );
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function getHtml() {

        //Render only the children
        return $this->getChildHtml();
    }

    protected function applyArgs( Node $node ) {

        if( $node instanceof TextNode )
            $node->setContent( $this->interpolate( $node->getContent() ) );
        else if( $node instanceof Element ) {

            foreach( $node->getAttributes() as $attr => $value )
                $node->setAttribute( $attr, $this->interpolate( $value ) );
        }

        foreach( $node->getChildren() as $child )
            $this->applyArgs( $child );
    }

    protected function interpolate( $string ) {

        $node = $this;
        return preg_replace_callback( '/\[\[([a-z\-]+)\]\]/Usi', function( $matches ) use( $node ) {

            $attr = strtoupper( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $matches[ 1 ] ) );

            if( $node->hasAttribute( $attr ) )
                return $node->getAttribute( $attr );

            return $matches[ 0 ];
        }, $string );
    }
}