<?php

namespace Xtpl\Parser;

class XtplElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'XTPL', $attributes );
    }

    public function getHtml() {

        return $this->getChildHtml();
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {
            if( $this->hasAttribute( 'EXTENDS' ) ) {

                $extendPath = $cwd.DIRECTORY_SEPARATOR.$this->getAttribute( 'EXTENDS' );
                $xtpl = $compiler->parseFile( $extendPath, $realPath );
                $xtpl->compile( $compiler, dirname( $realPath ) );

                //Incorporate trees
                $xtpl->addChild( $this->getRoot() );
            }
        }

        return parent::compile( $compiler, $cwd );
    }
}