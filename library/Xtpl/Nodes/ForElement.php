<?php

namespace Xtpl\Nodes;

class ForElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'FOR', $attributes );
    }

    public function render( $nice = false, $level = 0 ) {

        $pre = $nice ? "\n".str_repeat( '    ', $level ) : '';

        $html = '';
        if( $this->hasAttribute( 'EACH' ) && $this->hasAttribute( 'AS' ) ) {
            $html = $pre.'<?php foreach( $'.$this->getAttribute( 'EACH' ).' as $'.$this->getAttribute( 'AS' ).' ): ?>';
            $html .= $this->renderChildren( $nice, $level + 1 );
            $html .= $pre.'<?php endforeach; ?>';
        }

        return $html;
    }
}