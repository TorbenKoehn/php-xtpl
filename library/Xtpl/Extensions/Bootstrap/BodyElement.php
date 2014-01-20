<?php

namespace Xtpl\Extensions\Bootstrap;

class BodyElement extends Element {

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'BODY', $attributes );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( !$this->isCompiled() ) {

            if( $this->getParent() instanceof PanelElement ) {

                $this->setTagName( 'DIV' );
                $this->addClass( 'panel-body' );

                //Check if this is an accordion
                if( $this->getParent( 2 ) instanceof AccordionElement )
                    $this->wrap( new Panel\CollapseElement() );
            }
        }

        return parent::compile( $compiler, $cwd );
    }

    public function process() {

        if( !$this->isProcessed() ) {

            if( $this->getParent() instanceof MediaElement ) {

                $this->setTagName( 'DIV' );
                $this->addClass( 'media-body' );
            }

            if( $this->getParent()->hasClass( 'modal-content' ) ) {

                $this->setTagName( 'DIV' );
                $this->addClass( 'modal-body' );
            }

            if( $this->getParent() instanceof TabElement ) {

                $tabs = $this->findParent( 'UL' );

                $this->setTagName( 'DIV' );
                if( $tabs instanceof TabsElement ) {

                    $id = 'xtpl-boostrap-tab-'.$this->getParent()->getAttribute( 'NAME' );
                    $this->setAttribute( 'ID', $id );
                    $this->addClass( 'tab-pane' );
                    if( $this->getParent()->hasClass( 'active' ) ) {
                        $this->addClass( 'active' );
                    }
                    if( $tabs->hasClass( 'fade' ) ) {
                        $this->addClass( 'fade' );
                        if( $this->hasClass( 'active' ) ) {
                            $this->addClass( 'in' );
                        }
                    }

                    $ce = $tabs->getContentElement();
                    $ce->addChild( $this );
                    
                    
                }
            }
        }

        return parent::process();
    }
}