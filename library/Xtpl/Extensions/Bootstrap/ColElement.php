<?php

namespace Xtpl\Extensions\Bootstrap;

class ColElement extends DivElement {

    protected $modes = array( '', 'offset-', 'push-', 'pull-' );
    protected $sizes = array(
        'xs' => 'phone',
        'sm' => 'tablet',
        'md' => 'desktop',
        'lg' => 'tv'
    );

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        foreach( $this->sizes as $size => $alt ) {
            foreach( $this->modes as $mode ) {
                $attr = strtoupper( "$mode$size" );
                $altAttr = strtoupper( "$mode$alt" );

                $val = '';
                if( $this->hasAttribute( $attr ) ) {
                    $val = $this->getAttribute( $attr );
                    $this->ignoreAttribute( $attr );
                } else if( $this->hasAttribute( $altAttr ) ) {
                    $val = $this->getAttribute( $altAttr );
                    $this->ignoreAttribute( $altAttr );
                }

                if( !empty( $val ) ) {

                    $this->addClass( "col-$size-$mode$val" );
                }
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof TableElement )
                $this->setTagName( 'COL' );
        }
        return parent::process();
    }
}