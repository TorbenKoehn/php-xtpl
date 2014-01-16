<?php

namespace Xtpl\Nodes;

class TextNode extends Node {

    protected $content;

    public function __construct( $content = '' ) {

        $this->content = $content;
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

        //Text nodes probably never have children (They're not tags)
        return $pre.$this->content;
    }
}