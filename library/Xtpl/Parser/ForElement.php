<?php

namespace Xtpl\Parser;

class ForElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'FOR', $attributes );
    }

    public function getHtml() {

        $html = '';
        if( $this->hasAttribute( 'EACH' ) && $this->hasAttribute( 'AS' ) ) {
            $html = '<?php foreach( $'.$this->getAttribute( 'EACH' ).' as $'.$this->getAttribute( 'AS' ).' ): ?>';
            $html .= $this->getChildHtml();
            $html .= '<?php endforeach; ?>';
        }

        return $html;
    }
}