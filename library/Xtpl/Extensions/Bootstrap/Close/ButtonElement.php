<?php

namespace Xtpl\Extensions\Bootstrap\Close;

class ButtonElement extends \Xtpl\Extensions\Bootstrap\ButtonElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'close' );
        $this->addChild( new \Xtpl\Nodes\TextNode( '&times;' ) );
    }
}