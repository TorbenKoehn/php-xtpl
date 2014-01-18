<?php

namespace Xtpl;

use Xtpl\Nodes\Node,
    Xtpl\Nodes\Element,
    Xtpl\Nodes\TextNode;

class Parser {

    protected $currentNode;
    protected $elementNamespaces = array( 'Xtpl\\Nodes', 'Xtpl\\Extensions' );

    public function __construct( array $additionalElementNamespaces = null ) {

        if( $additionalElementNamespaces )
            $this->addElementNamespace( $additionalElementNamespaces );
    }

    public function addElementNamespace( $namespace ) {

        if( is_array( $namespace ) ) {
            foreach( $namespace as $ns )
                $this->addElementNamespace( $ns );
            return;
        }

        $this->elementNamespaces[] = $namespace;
    }

    public function parse( $string ) {

        $this->currentNode = null;
        $xp = $this->createXmlParser();
        $success = xml_parse( $xp, $string, true );

        if( !$success ) {

            $code = xml_get_error_code( $xp );
            $msg = xml_error_string( $code );
            $line = xml_get_current_line_number( $xp );
            $col = xml_get_current_column_number( $xp );

            throw new \Exception( "$msg (On line $line:$col)", $code );
        }

        return $this->currentNode;
    }

    public function parseFile( $path ) {

        return $this->parse( file_get_contents( $path ) );
    }

    protected function createXmlParser() {

        $xp = xml_parser_create();
        xml_parser_set_option( $xp, XML_OPTION_CASE_FOLDING, true );
        xml_parser_set_option( $xp, XML_OPTION_SKIP_WHITE, true );

        xml_set_object( $xp, $this );
        xml_set_element_handler( $xp, 'handleElementStart', 'handleElementEnd' );
        xml_set_character_data_handler( $xp, 'handleCharacterData' );

        return $xp;
    }

    protected function handleElementStart( $parser, $tagName, $attributes ) {

        if( !$this->currentNode && $tagName !== 'XTPL' )
            throw new \Exception( "Root element has to be XTPL" );

        $el = null;

        //Load element
        $className = implode( '\\', array_map( function( $el ) {
            return ucfirst( $el );
        }, explode( '-', strtolower( $tagName ) ) ) ).'Element';

        $namespaces = array_reverse( $this->elementNamespaces );
        foreach( $namespaces as $ns ) {

            $nsClassName = "$ns\\$className";
            if( class_exists( $nsClassName ) ) {
                $el = new $nsClassName( $attributes );
            }
        }

        if( !$el )
            $el = new Element( $tagName, $attributes );

        if( $this->currentNode )
            $this->currentNode->addChild( $el );

        $this->currentNode = $el;
    }

    protected function handleElementEnd( $parser, $tagName ) {

        $this->currentNode = $this->currentNode->hasParent() ? $this->currentNode->getParent() : $this->currentNode;
    }

    protected function handleCharacterData( $parser, $cdata ) {

        $cdata = trim( $cdata );

        if( empty( $cdata ) )
            return;

        $this->currentNode->addChild( new TextNode( $cdata ) );
    }

    public static function fromString( $string ) {

        $p = new self;
        return $p->parse( $string );
    }

    public static function fromFile( $path ) {

        $p = new self;
        return $p->parseFile( $path );
    }
}