<?php

namespace Xtpl\Nodes;

abstract class Node {

    protected static $uniqueIdCounter = 0;

    protected $children = array();
    protected $parent = null;
    protected $compiled = false;
    protected $processed = false;
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

    public function isProcessed() {

        return $this->processed;
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

        return $child;
    }

    public function addChild( Node $child ) {

        //Avoid recursion
        if( $child === $this )
            return;

        if( $child->hasParent() )
            $child->getParent()->removeChild( $child );

        $child->setParent( $this );
        $this->children[] = $child;

        return $child;
    }

    public function removeChild( Node $child ) {

        $this->children = array_values( array_filter( $this->children, function( $currentChild ) use( $child ) {

            return $currentChild !== $child;
        } ) );
        $child->setParent( null );

        return $child;
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

        $i = 0;
        if( is_numeric( $child ) && $child < 0 )
            $i = count( $this->children ) - $child;
        else if( $child instanceof Node )
            $i = $this->indexOf( $child );

        if( !is_array( $newChildren ) )
            $newChildren = array( $newChildren );

        foreach( $newChildren as $child ) {
            if( $child->hasParent() )
                $child->getParent()->removeChild( $child );
            $child->setParent( $this );
        }

        array_splice( $this->children, intval( $i ), 0, is_array( $newChildren ) ? $newChildren : array( $newChildren ) );
    }

    public function insertAfter( $child, $newChildren ) {

        $i = count( $this->children ) - 1;
        if( is_numeric( $child ) && $child < 0 )
            $i = count( $this->children ) - 1;
        else if( $child instanceof Node )
            $i = $this->indexOf( $child );

        if( !is_array( $newChildren ) )
            $newChildren = array( $newChildren );

        foreach( $newChildren as $child ) {
            if( $child->hasParent() )
                $child->getParent()->removeChild( $child );
            $child->setParent( $this );
        }

        array_splice( $this->children, intval( $i + 1 ), 0, is_array( $newChildren ) ? $newChildren : array( $newChildren ) );
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

    public function process() {

        foreach( $this->children as $child )
            $child->process();

        $this->processed = true;
        return $this;
    }

    public function compile( \Xtpl\Compiler $compiler, $cwd ) {

        foreach( $this->children as $child )
            $child->compile( $compiler, $cwd );

        //Handle variable expressions ({{my.var.name:callback:Class.staticCallback:callback}})
        //All callbacks will receive the variable value as the first argument
        //the return value will printed in the end

        if( !$this->compiled ) {

            $this->compileVarExpressions();

            $this->compiled = true;
        }

        return $this;
    }

    protected function compileVarExpressions() {

        if( $this instanceof Element ) {
            foreach( $this->getAttributes() as $key => $val ) {

                $this->setAttribute( $key, $this->parseVarExpressions( $val, $key ) );
            }
        }

        if( $this instanceof TextNode ) {

            $this->setContent( $this->parseVarExpressions( $this->getContent() ) );
        }
    }

    protected function parseVarExpressions( $string ) {

        return preg_replace_callback( '/\{\{(?<var>[_a-z][a-z0-9\._]*)(\((?<default>[^\)]*)\))?(:(?<callbacks>[a-z][a-z0-9\.:_]+))?\}\}/si', function( $matches ) {

            $var = '$'.str_replace( '.', '->', $matches[ 'var' ] );
            $default = array_key_exists( 'default', $matches ) ? $matches[ 'default' ] : '';

            $php = '';

            if( !empty( $matches[ 'callbacks' ] ) ) {

                $callbacks = explode( ':', $matches[ 'callbacks' ] );
                foreach( $callbacks as $i => $cb )
                    if( ( $last = strrpos( $cb, '.' ) ) !== false ) {

                        $cb[ $last ] = ':';
                        $cb = str_replace( '.', '\\', $cb );

                        $callbacks[ $i ] = explode( ':', $cb );
                    }

                $php = '<?php $_xtplResult = isset( '.$var.' ) ? '.$var.' : \''.$default.'\'; $_xtplCallbacks = '.str_replace( "\n", '', var_export( $callbacks, true ) ).'; foreach( $_xtplCallbacks as $cb ) $_xtplResult = call_user_func( $cb, $_xtplResult ); echo $_xtplResult; ?>';
            } else {

                $php = '<?php echo isset( '.$var.' ) ? '.$var.' : \''.$default.'\'; ?>';
            }

            return $php;
        }, $string );
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