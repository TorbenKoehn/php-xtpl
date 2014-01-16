<?php

namespace Xtpl\Parser;

class VarElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'VAR', $attributes );
    }

    public function getHtml() {

        if( $this->hasAttribute( 'VALUE' ) )
            return '<?php $'.$this->getAttribute( 'NAME' ).' = "'.$this->getAttribute( 'VALUE' ).'; ?>';

        return '<?php empty( $'.$this->getAttribute( 'NAME' ).' ) ? "'.( $this->hasAttribute( 'DEFAULT' ) ? $this->getAttribute( 'DEFAULT' ) : '' ).' : $'.$this->getAttribute( 'NAME' ).'; ?>';
    }
}