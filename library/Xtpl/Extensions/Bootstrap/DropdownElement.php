<?php

namespace Xtpl\Extensions\Bootstrap;

class DropdownElement extends UlElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->ignoreAttribute( 'TYPE' );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            $this->addClass( 'dropdown-menu' );
            $this->setAttribute( 'ROLE', 'menu' );
            $subject = $this->getParent();
            $subjectParent = $subject->getParent();
            $types = explode( ' ', $this->hasAttribute( 'TYPE' ) ? $this->getAttribute( 'TYPE' ) : '' );

            $subject->setAttribute( 'DATA-TOGGLE', 'dropdown' );
            $subject->addClass( 'dropdown-toggle' );


            if( $subjectParent instanceof Button\GroupElement ) {

                $btnGroup = new Button\GroupElement( array( 'SIZE' => $subjectParent->getAttribute( 'SIZE' ) ) );
                $subjectParent->insertBefore( $subject, $btnGroup );
                $btnGroup->addChild( $subject );
                $btnGroup->addChild( $this );
                if( in_array( 'dropup', $types ) )
                    $subjectParent->addClass( 'dropup' );

            } else if( $subjectParent->hasClass( 'btn-group', 'input-group-btn', 'dropdown' ) > 0
                    || $subjectParent->getTagName() == 'LI' ) {

                if( !$subjectParent->hasClass( 'dropdown' ) && !$subjectParent->hasClass( 'btn-group' ) && !$subjectParent->hasClass( 'input-group-btn' ) )
                    $subjectParent->addClass( 'dropdown' );

                $subjectParent->insertAfter( $subject, $this );
                if( in_array( 'dropup', $types ) )
                    $subjectParent->addClass( 'dropup' );
            } else {

                $div = new DivElement;
                $subjectParent->insertBefore( $subject, $div );
                $div->addChild( $subject );
                $div->addChild( $this );
                $div->addClass( 'dropdown' );

                if( in_array( 'dropup', $types ) )
                    $div->addClass( 'dropup' );
            }
            
        }

        return parent::process();
    }
}