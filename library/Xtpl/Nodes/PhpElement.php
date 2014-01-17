<?php

namespace Xtpl\Nodes;

class PhpElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'PHP', $attributes );
    }

    public function setCode( $code ) {

        $this->setChildren( array( new TextNode( $code ) ) );
    }

    public function addCode( $code ) {

        $this->addChild( new TextNode( $code ) );
    }

    public function render( $nice = false, $level = 0 ) {

        $pre = $nice ? "\n".str_repeat( '    ', $level ) : '';

        //is this a one-liner?
        $text = $this->getText();
        if( strpos( $text, "\n" ) === false )
            return "$pre<?php $text ?>";

        return "$pre<?php ".$this->renderChildren( $nice, $level + 1 )." $pre?>";
    }
}