<?php

namespace Xtpl\Nodes;

class TextNode extends Node {

    protected $content;

    public function __construct( $content = '' ) {

        $this->content = trim( $content );
    }

    public function hasContent() {

        return !empty( $this->content );
    }

    public function setContent( $content ) {

        $this->content = $content;
    }

    public function getContent() {

        return $this->content;
    }

    public function render( $nice = false, $level = 0 ) {

        $pre = $nice ? "\n".str_repeat( '    ', $level ) : '';

        $content = implode( $pre, array_map( 'trim', explode( "\n", $this->content ) ) );

        //Text nodes probably never have children (They're not tags)
        return $pre.$content;
    }
}