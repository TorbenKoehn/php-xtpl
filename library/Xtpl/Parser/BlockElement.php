<?php

namespace Xtpl\Parser;

class BlockElement extends Element {

    protected $target = false;

    public function __construct( array $attributes = array() ) {
        parent::__construct( 'BLOCK', $attributes );
    }

    public function setAsTarget() {

        $this->target = true;
    }

    public function isTarget() {

        return $this->target;
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        if( $this->hasAttribute( 'NAME' ) ) {

            $name = $this->getAttribute( 'NAME' );
            $mode = $this->hasAttribute( 'MODE' ) ? $this->getAttribute( 'MODE' ) : 'replace';

            foreach( $this->findAll( 'BLOCK', array( 'NAME' => $this->getAttribute( 'NAME' ) ) ) as $result ) {
                if( $result instanceof BlockElement && $result->isTarget() ) {
                    switch( $mode ) {
                        default:
                        case 'replace':

                            $result->setChildren( array( $this ) );
                            break;
                        case 'append':

                            $result->addChild( $this );
                            break;
                        case 'prepend':

                            $result->prependChild( $this );
                            break;
                    }
                }
            }

            if( !( $this->getParent() instanceof self ) )
                $this->setAsTarget();
        }

        return parent::compile( $compiler, $cwd );
    }

    public function getHtml() {

        //Render only the children
        return $this->getChildHtml();
    }
}