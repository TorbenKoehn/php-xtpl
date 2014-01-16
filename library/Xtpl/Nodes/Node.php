<?php

namespace Xtpl\Nodes;

class Node {

    protected static $uniqueIdCounter = 0;

    protected $children = array();
    protected $parent = null;
    protected $compiled = false;
    protected $uniqueId;

    public function hasParent() {

        return $this->parent instanceof Node;
    }

    public function setParent( Node $parent = null ) {

        $this->parent = $parent;
    }

    public function getParent() {

        return $this->parent;
    }

    public function isCompiled() {

        return $this->compiled;
    }

    public function getRoot() {

        if( !$this->hasParent() )
            return $this;

        $current = $this->getParent();

        while( $current->hasParent() )
            $current = $current->getParent();

        return $current;
    }

    public function indexOf( Node $child ) {

        return array_search( $child, $this->children, true );
    }

    public function getChild( $offset ) {

        if( $offset < 0 )
            $offset = count( $this->children ) - $offset;

        return $this->children[ $offset ];
    }

    public function hasChild( $child ) {

        if( is_int( $child ) )
            return array_key_exists( $child, $this->children );
        
        return $this->indexOf( $child ) !== false ? true : false;
    }

    public function getFirstChild() {

        return !$this->hasChildren() ? null : $this->getChild( 0 );
    }

    public function getLastChild() {

        return !$this->hasChildren() ? null : $this->getChild( -1 );
    }

    public function prependChild( Node $child ) {

        if( !$this->hasChildren() )
            $this->addChild( $child );
        else
            $this->insertBefore( 0, $child );
    }

    public function addChild( Node $child ) {

        //Avoid recursion
        if( $child === $this )
            return;

        if( $child->hasParent() )
            $child->getParent()->removeChild( $child );

        $child->setParent( $this );
        $this->children[] = $child;
    }

    public function removeChild( Node $child ) {

        $this->children = array_values( array_filter( $this->children, function( $currentChild ) use( $child ) {

            return $currentChild !== $child;
        } ) );
        $child->setParent( null );
    }

    public function hasChildren() {

        return !empty( $this->children );
    }

    public function getChildren() {

        return $this->children;
    }

    public function addChildren( array $children ) {
        
        foreach( $children as $child )
            $this->addChild( $child );
    }

    public function prependChildren( array $children ) {

        if( !$this->hasChildren() )
            $this->addChildren( $children );
        else
            $this->insertAfter( -1, $children );
    }

    public function setChildren( array $children ) {

        $this->clear();
        $this->addChildren( $children );
    }

    public function clear() {

        foreach( $this->children as $child )
            $this->removeChild( $child );

        $this->children = array();
    }

    public function insertBefore( $child, $newChildren ) {

        if( is_numeric( $child ) && $i < 0 )
            $i = count( $this->children ) - $child;
        else if( $child instanceof Node )
            $i = $this->indexOf( $child );
    

        if( is_array( $newChildren ) )
            foreach( $newChildren as $child )
                $child->setParent( $this );
        else
            $newChildren->setParent( $this );

        array_splice( $this->children, intval( $i ), 0, $newChildren );
    }

    public function insertAfter( Node $child, $newChildren ) {

        if( is_numeric( $child ) && $i < 0 )
            $i = count( $this->children ) - 1;
        else if( $child instanceof Node )
            $i = $this->indexOf( $child );

        if( is_array( $newChildren ) )
            foreach( $newChildren as $child )
                $child->setParent( $this );
        else
            $newChildren->setParent( $this );

        array_splice( $this->children, intval( $i + 1 ), 0, $newChildren );
    }

    public function renderChildren( $nice = false, $level = 0 ) {

        $html = '';
        foreach( $this->children as $child )
            $html .= $child->render( $nice, $level );

        return $html;
    }

    public function render( $nice = false, $level = 0 ) {

        //Nodes only render their children, not themself
        return $this->renderChildren( $nice, $level );
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        foreach( $this->children as $child )
            $child->compile( $compiler, $cwd );

        $this->compiled = true;
        return $this;
    }

    public function __toString() {

        return htmlspecialchars( $this->render() );
    }

    public function getUniqueId() {

        if( !$this->uniqueId )
            $this->uniqueId = 'node-'.( self::$uniqueIdCounter++ );

        return $this->uniqueId;
    }
}