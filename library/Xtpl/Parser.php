<?php

namespace Xtpl;

use Xtpl\Parser\Node,
    Xtpl\Parser\Element,
    Xtpl\Parser\TextNode;

class Parser {

    protected $currentRoot;
    protected $currentNode;

    public function parse( $string ) {

        $this->currentRoot = null;
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

        return $this->currentRoot;
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

        if( !$this->currentRoot && $tagName !== 'XTPL' )
            throw new \Exception( "Root element has to be XTPL" );

        if( !$this->currentRoot ) {

            $this->currentRoot = Element::create( $tagName, $attributes );
            //Enhance our root with some useful information
            $this->currentNode = $this->currentRoot;
        } else {

            $el = Element::create( $tagName, $attributes );
            $el->setParent( $this->currentNode );

            $this->currentNode->addChild( $el );
            $this->currentNode = $el;
        }
    }

    protected function handleElementEnd( $parser, $tagName ) {

        $this->currentNode = $this->currentNode->hasParent() ? $this->currentNode->getParent() : $this->currentRoot;
    }

    protected function handleCharacterData( $parser, $cdata ) {

        $cdata = trim( $cdata );

        if( empty( $cdata ) )
            return;

        $this->currentNode->addChild( new TextNode( $cdata ) );
    }

    public static function fromString( $string, $encoding = 'UTF-8' ) {

        $p = new self( $encoding );
        return $p->parse( $string );
    }

    public static function fromFile( $path, $encoding = 'UTF-8' ) {

        $p = new self( $encoding );
        return $p->parseFile( $path );
    }
}