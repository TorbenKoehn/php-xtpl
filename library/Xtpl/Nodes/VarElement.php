<?php

namespace Xtpl\Nodes;

class VarElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'VAR', $attributes );
    }

    public function render( $nice = false, $level = 0 ) {

        $pre = $nice ? "\n".str_repeat( '    ', $level ) : '';
        if( $this->hasAttribute( 'VALUE' ) )
            return $pre.'<?php $'.$this->getAttribute( 'NAME' ).' = "'.$this->getAttribute( 'VALUE' ).'; ?>';

        return $pre.'<?php empty( $'.$this->getAttribute( 'NAME' ).' ) ? "'.( $this->hasAttribute( 'DEFAULT' ) ? $this->getAttribute( 'DEFAULT' ) : '' ).' : $'.$this->getAttribute( 'NAME' ).'; ?>';
    }
}