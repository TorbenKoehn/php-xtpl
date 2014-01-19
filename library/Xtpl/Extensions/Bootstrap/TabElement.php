<?php

namespace Xtpl\Extensions\Bootstrap;

class TabElement extends AElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->ignoreAttribute( 'NAME' );
        if( !$this->hasAttribute( 'NAME' ) )
            $this->setAttribute( 'NAME', $this->getUniqueId() );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $li = new LiElement;
            if( $this->hasClass( 'active' ) )
                $li->addClass( 'active' );

            $this->getParent()->insertBefore( $this, $li );
            $li->addChild( $this );
            $this->setAttribute( 'HREF', '#xtpl-boostrap-tab-'.$this->getAttribute( 'NAME' ) );
            $this->setAttribute( 'DATA-TOGGLE', 'tab' );
        }

        return parent::process();
    }
}