<?php

namespace Xtpl\Extensions;

class HeadElement extends \Xtpl\Nodes\Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'HEAD', $attributes );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $charsetMetas = $this->find( 'META', array( 'CHARSET' => true ) );

            if( !count( $charsetMetas ) ) {
                $this->prependChild( new MetaElement( array( 'CHARSET' => 'utf-8' ) ) );
            }
        }

        return parent::process();
    }
}