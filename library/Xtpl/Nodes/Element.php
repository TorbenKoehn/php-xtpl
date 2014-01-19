<?php

namespace Xtpl\Nodes;

class Element extends Node {

    protected $tagName;
    protected $attributes;
    protected $ignoredAttributes = array();

    public function __construct( $tagName, array $attributes = array() ) {

        $this->tagName = $tagName;
        $this->attributes = $attributes;
    }

    public function getTagName() {

        return $this->tagName;
    }

    public function setTagName( $tagName ) {

        $this->tagName = $tagName;
    }

    public function hasAttribute( $key ) {

        return array_key_exists( $key, $this->attributes );
    }

    public function getAttribute( $key ) {

        if( !$this->hasAttribute( $key ) )
            return null;

        return $this->attributes[ $key ];
    }

    public function setAttribute( $key, $value ) {

        $this->attributes[ $key ] = $value;
    }

    public function removeAttribute( $key ) {

        $value = $this->attributes[ $key ];
        unset( $this->attributes[ $key ] );

        return $value;
    }

    public function removeAttributes( $attributes ) {

        $args = func_get_args();

        if( !is_array( $attributes ) )
            $attributes = $args;
        $attrs = array();
        foreach( $attributes as $attr ) {

            if( $this->hasAttribute( $attr ) ) {
                $attrs[ $attr ] = $this->getAttribute( $attr );

                $this->removeAttribute( $attr );
            }
        }

        return $attrs;
    }

    public function getAttributes() {

        return $this->attributes;
    }

    public function ignoreAttribute( $attr ) {

        if( is_array( $attr ) ) {
            foreach( $attr as $att )
                $this->ignoreAttribute( $att );
            return;
        }

        $this->ignoredAttributes[] = $attr;
    }

    public function renderAttributes( $nice = false, $level = 0 ) {

        if( empty( $this->attributes ) )
            return '';

        $attrs = array();
        foreach( $this->attributes as $key => $value )
            if( $value !== null && $value !== false && !in_array( $key, $this->ignoredAttributes ) )
                $attrs[] = strtolower( $key ).'="'.$value.'"';

        return implode( ' ', $attrs );
    }

    public function render( $nice = false, $level = 0 ) {

        $tag = strtolower( $this->tagName );
        $attrHtml = $this->renderAttributes( $nice, $level );
        $childHtml = $this->renderChildren( $nice, $level + 1 );
        $pre = $nice ? "\n".str_repeat( '    ', $level ) : '';

        if( !empty( $attrHtml ) )
            $attrHtml = " $attrHtml";

        //Specific one-liner tags
        if( in_array( $this->tagName, array( 'BR', 'IMG', 'INPUT', 'META', 'LINK', 'COL', 'HR' ) ) )
            return "$pre<$tag$attrHtml>";

        $text = trim( $this->getText() );
        $lastPre = $pre;
        if( !$this->hasChildren() && empty( $text ) ) {
            $pre = substr( $pre, 1 );
            $lastPre = '';
        }

        return "$pre<$tag$attrHtml>$childHtml$pre</$tag>";
    }

    public function find( $tagName, array $attributes = array(), $recursive = true ) {

        $results = array();
        foreach( $this->children as $child ) {

            if( $child instanceof self ) {

                if( $recursive )
                    foreach( $child->find( $tagName, $attributes ) as $result )
                        $results[] = $result;

                if( $child->getTagName() == $tagName ) {
                    if( !empty( $attributes ) )
                        //attributes check
                        foreach( $attributes as $key => $value ) 
                            if( !$child->hasAttribute( $key ) || ( $value !== true && $child->getAttribute( $key ) != $value ) )
                                continue 2;
                           
                    $results[] = $child;
                }
            }
        }

        return $results;
    }

    public function findChild( $tagName, array $attributes = array() ) {

        return $this->find( $tagName, $attributes, false );
    }

    public function findAll( $tagName, array $attributes = array() ) {

        return $this->getRoot()->find( $tagName, $attributes );
    }

    public function findParent( $tagName ) {


        $current = $this->getParent();
        while( $current->hasParent() ) {

            if( $current instanceof self && $current->getTagName() == $tagName )
                return $current;

            $current = $current->getParent();
        }
        
        return null;
    }

    public function getTextNodes() {

        $textNodes = array();
        foreach( $this->children as $child )
            if( $child instanceof TextNode )
                $textNodes[] = $child;

        return $textNodes;
    }

    public function getText() {

        $textNodes = $this->getTextNodes();
        $text = '';
        foreach( $textNodes as $textNode )
            $text .= $textNode->getContent();

        return $text;
    }

    public function prependPhp( $code ) {

        $this->prependChild( new PhpElement() )->setCode( $code );
    }

    public function addPhp( $code ) {

        $this->addChild( new PhpElement() )->setCode( $code );
    }

    public function getClass() {

        return $this->hasAttribute( 'CLASS' ) ? '' : $this->getAttribute( 'CLASS' );
    }

    public function addClass( $class ) {

        $args = func_get_args();
        if( is_array( $class ) )
            $args = $class;

        $class = $this->hasAttribute( 'CLASS' ) ? $this->getAttribute( 'CLASS' ) : '';
        $classes = explode( ' ', $class );
        foreach( $args as $arg )
            if( !in_array( $arg, $classes ) )
                $classes[] = $arg;

        $this->setAttribute( 'CLASS', trim( implode( ' ', $classes ) ) );
    }

    public function removeClass( $class ) {

        $args = func_get_args();
        if( is_array( $class ) )
            $args = $class;

        $class = $this->hasAttribute( 'CLASS' ) ? $this->getAttribute( 'CLASS' ) : '';
        $classes = array_filter( explode( ' ', $class ), function( $value ) use( $args ) {

            return !in_array( $value, $args );
        } );
        
        $this->setAttribute( 'CLASS', trim( implode( ' ', $classes ) ) );
    }

    public function hasClass( $class ) {

        $args = func_get_args();
        if( is_array( $class ) )
            $args = $class;

        $result = array_filter( explode( ' ', $this->getAttribute( 'CLASS' ) ), function( $value ) use( $args ) {

            return in_array( $value, $args );
        } );

        return count( $result );
    }

    public function addCss( $css, array $properties = null ) {

        $head = $this->findAll( 'HEAD' );

        if( empty( $head ) )
            throw new \Exception( "Cant automatically add CSS: Head-element not found" );

        $style = $head[ 0 ]->find( 'STYLE' );

        if( empty( $style ) ) {
            $style = new Element( 'STYLE' );
            $head[ 0 ]->addChild( $style );
        } else
            $style = $style[ 0 ];

        if( $properties ) {
            //Assume $css is a selector
            $css = "$css {";
            foreach( $properties as $name => $value )
                $css .= "$name: $value;";
            $css .= '}';
        }

        $style->addChild( new TextNode( $css ) );

        return $style;
    }

    public function addJs( $js ) {

        $body = $this->findAll( 'BODY' );

        if( empty( $body ) )
            throw new \Exception( "Cant automatically add JavaScript: Body-element not found" );

        $script = $body[ 0 ]->find( 'SCRIPT' );

        if( empty( $script ) || $script[ 0 ]->hasAttribute( 'SRC' ) ) {
            $script = new Element( 'SCRIPT' );
            $body[ 0 ]->addChild( $script );
        } else
            $script = $script[ 0 ];

        $script->addChild( new TextNode( $js ) );

        return $script;
    }
}