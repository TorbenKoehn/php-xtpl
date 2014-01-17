<?php

namespace Xtpl;

use Xtpl\Nodes\Node,
    Xtpl\Nodes\Element;

class Compiler {

    protected $parser;

    public function __construct( Parser $parser = null ) {

        $this->parser = $parser ? $parser : new Parser;
    }

    public function getParser() {

        return $this->parser;
    }

    public function compile( $string ) {

        $xtpl = $this->parse( $string );

        $compiledRoot = $xtpl->compile( $this, __DIR__ )->getRoot();

        return $compiledRoot;
    }

    public function compileFile( $path ) {

        $xtpl = $this->parseFile( $path );

        $compiledRoot = $xtpl->compile( $this, dirname( $path ) )->getRoot();

        return $compiledRoot;
    }

    public function parse( $string ) {

        return $this->parser->parse( $string );
    }

    public function parseFile( $path ) {

        if( !preg_match( '/\.xtpl$/Usi', $path ) )
            $path .= '.xtpl';

        $realPath = realpath( $path );
        if( !$realPath )
            throw new \Exception( "Xtpl file not found: $path" );

        return $this->parser->parseFile( $realPath );
    }

    public function dump( Node $node, $deep = true, $level = 0, $index = 0 ) {

        if( !$level )
            echo '<pre>';

        $pre = str_repeat( '|   ', $level );

        echo '<font color="blue">'.$pre.'|<font color="red"><u>'.$index.'</u></font>|';
        if( $node instanceof Element ) {
            echo $node->getTagName().':';
        }
        echo basename( str_replace( '\\', '/', get_class( $node ) ) ).'</font>';

        echo '<font color="darkgreen">['.( $node->hasParent() 
            ? ( $node->getParent() instanceof Element ? $node->getParent()->getTagName().':' : ''
            ).basename( str_replace( '\\', '/', get_class( $node->getParent() ) ) ) : 'NULL' ).']</font>';
        
        if( $node instanceof Element ) {
            echo '(<font color="darkred">'.trim( $node->renderAttributes() ).'</font>)';
        }

        if( !$deep ) {
            echo '</pre>';
            return;
        }

        echo '<br>';
        foreach( $node->getChildren() as $i => $child )
            $this->dump( $child, $deep, $level + 1, $i );

        echo '<font color="blue">'.$pre.'|<font color="red">'.str_repeat( '_', strlen( strval( $index ) ) ).'</font>|/';
        if( $node instanceof Element ) {
            echo $node->getTagName().':';
        }
        echo basename( str_replace( '\\', '/', get_class( $node ) ) ).'</font>';

        echo '<font color="darkgreen">['.( $node->hasParent() 
            ? ( $node->getParent() instanceof Element ? $node->getParent()->getTagName().':' : ''
            ).basename( str_replace( '\\', '/', get_class( $node->getParent() ) ) ) : 'NULL' ).']</font>';
        
        if( $node instanceof Element ) {
            echo '(<font color="darkred">'.trim( $node->renderAttributes() ).'</font>)';
        }

        echo '<br>';

        if( !$level )
            echo '</pre>';
    }
}