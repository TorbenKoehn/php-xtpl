<?php

namespace Xtpl\Extensions\Bootstrap\Progress;

use \Xtpl\Extensions\Bootstrap\ProgressElement;

class BarElement extends \Xtpl\Extensions\Bootstrap\DivElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->ignoreAttribute( array( 'MIN', 'MAX', 'VALUE', 'THEME' ) );

        $this->setAttribute( 'ROLE', 'progressbar' );
        $this->addClass( 'progress-bar' );

        $value =  $this->hasAttribute( 'VALUE' ) ? $this->getAttribute( 'VALUE' ) : 0;
        $min = $this->hasAttribute( 'MIN' ) ? intval( $this->getAttribute( 'MIN' ) ) : 0;
        $max = $this->hasAttribute( 'MAX' ) ? intval( $this->getAttribute( 'MAX' ) ) : 100;
        $delta = $max - $min;

        $this->setAttribute( 'ARIA-VALUEMIN', $min );
        $this->setAttribute( 'ARIA-VALUEMAX', $max );
        $this->setAttribute( 'ARIA-VALUENOW', $value );

        $per = floor( ( 100 / $delta )  * $value );
        $this->setAttribute( 'STYLE', "width: $per%;" );

        if( $this->hasAttribute( 'THEME' ) ) {

            switch( $this->getAttribute( 'THEME' ) ) {
                case 'success':
                    $this->addClass( 'progress-bar-success' );
                    break;
                case 'warning':
                    $this->addClass( 'progress-bar-warning' );
                    break;
                case 'danger':
                    $this->addClass( 'progress-bar-danger' );
                    break;
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( !( $this->getParent() instanceof ProgressElement ) ) {
                $pe = new ProgressElement;
                $this->getParent()->insertBefore( $this, $pe );
                $pe->addChild( $this );
            }
        }

        return parent::process();
    }
}