<?php

namespace Xtpl\Extensions;

class MenuElement extends \Xtpl\Nodes\Element {

    protected $cssAdded = false;

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'UL', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $uid = $this->getUniqueId();
            $this->addClass( $uid );
            $this->addCss( ".$uid", array(
                'display' => 'block'
            ) );
        }

        return parent::process();
    }
}