<?php

namespace Xtpl\Extensions\Menu;

use \Xtpl\Parser\Node,
    \Xtpl\Parser\TextNode,
    \Xtpl\Parser\Element,
    \Xtpl\Extensions\MenuElement;

class ItemElement extends Element {
    
    protected $anchor;
    protected $subMenu;

    public function __construct( array $attributes = array() ) {

        parent::__construct( 'LI', $attributes );

        $this->ignoreAttribute( 'HREF' );
    }

    public function addChild( Node $node ) {

        if( $node instanceof MenuElement ) {
            $this->subMenu = $node;
            parent::addChild( $node );
            return;
        }

        if( !$this->anchor ) {
            $this->anchor = $node instanceof Element && $node->getTagName() == 'A' ? $node : new Element( 'A' );

            if( $this->hasAttribute( 'HREF' ) )
                $this->anchor->setAttribute( 'HREF', $this->getAttribute( 'HREF' ) );

            parent::addChild( $this->anchor );
        }

        //Put all other stuff into the anchor node
        $this->anchor->addChild( $node );
    }
}