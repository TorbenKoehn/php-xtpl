<?php

namespace Xtpl\Extensions\Bootstrap;

class Element extends \Xtpl\Nodes\Element {

    public function __construct( $tagName, array $attributes = array() ) {
        parent::__construct( $tagName, $attributes );

        $this->ignoreAttribute( array( 'PULL', 'VISIBLE', 'HIDDEN', 'TEXT-ALIGN', 'TEXT-THEME' ) );

        //Responsive utilities
        if( $this->hasAttribute( 'VISIBLE' ) ) {
            $visible = explode( ' ', $this->getAttribute( 'VISIBLE' ) );

            foreach( $visible as $v )
                switch( $v ) {
                    case 'xs':
                    case 'phone':
                        $this->addClass( 'visible-xs' );
                        break;
                    case 'sm':
                    case 'tablet':
                        $this->addClass( 'visible-sm' );
                        break;
                    case 'md':
                    case 'desktop':
                        $this->addClass( 'visible-md' );
                        break;
                    case 'lg':
                    case 'tv':
                        $this->addClass( 'visible-lg' );
                        break;
                    case 'p':
                    case 'print':
                        $this->addClass( 'visible-print' );
                        break;
                }
        }

        if( $this->hasAttribute( 'HIDDEN' ) ) {
            $hidden = explode( ' ', $this->getAttribute( 'HIDDEN' ) );

            foreach( $hidden as $h )
                switch( $h ) {
                    case 'xs':
                    case 'phone':
                        $this->addClass( 'hidden-xs' );
                        break;
                    case 'sm':
                    case 'tablet':
                        $this->addClass( 'hidden-sm' );
                        break;
                    case 'md':
                    case 'desktop':
                        $this->addClass( 'hidden-md' );
                        break;
                    case 'lg':
                    case 'tv':
                        $this->addClass( 'hidden-lg' );
                        break;
                    case 'p':
                    case 'print':
                        $this->addClass( 'hidden-print' );
                        break;
                }
        }

        //Text style manipulation
        if( $this->hasAttribute( 'TEXT-ALIGN' ) ) {
            switch( $this->getAttribute( 'TEXT-ALIGN' ) ) {
                case 'left':
                    $this->addClass( 'text-left' );
                    break;
                case 'center':
                    $this->addClass( 'text-center' );
                    break;
                case 'right':
                    $this->addClass( 'text-right' );
                    break;
            }
        }

        if( $this->hasAttribute( 'TEXT-THEME' ) ) {
            switch( $this->getAttribute( 'TEXT-THEME' ) ) {
                case 'muted':
                    $this->addClass( 'text-muted' );
                    break;
                case 'primary':
                    $this->addClass( 'text-primary' );
                    break;
                case 'success':
                    $this->addClass( 'text-success' );
                    break;
                case 'info':
                    $this->addClass( 'text-info' );
                    break;
                case 'warning':
                    $this->addClass( 'text-warning' );
                    break;
                case 'danger':
                    $this->addClass( 'text-danger' );
                    break;
            }
        }
    }

    public function process() {

        if( !$this->isProcessed() ) {

            //Some things need to be done here, since the DOM is loaded completely at this point.
            //Pulling
            if( $this->hasAttribute( 'PULL' ) ) {
                switch( $this->getAttribute( 'PULL' ) ) {
                    case 'left':
                        $this->addClass( 'pull-left' );
                        $this->getParent()->addClass( 'clearfix' );
                        break;
                    case 'right':
                        $this->addClass( 'pull-right' );
                        $this->getParent()->addClass( 'clearfix' );
                        break;
                    case 'center':
                        $this->addClass( 'center-block' );
                        break;
                }
            }

            $this->loadScriptsAndStyles();
        }

        return parent::process();
    }

    protected function loadScriptsAndStyles() {

        $jQueryId = 'xtpl-jquery-js';
        $scriptId = 'xtpl-bootstrap-js';
        $libraryId = 'xtpl-bootstrap-library-js';
        $styleId = 'xtpl-bootstrap-css';

        $jQuery = $this->findAll( 'SCRIPT', array( 'ID' => $jQueryId ) );
        $script = $this->findAll( 'SCRIPT', array( 'ID' => $scriptId ) );
        $library = $this->findAll( 'SCRIPT', array( 'ID' => $libraryId ) );
        $style = $this->findAll( 'LINK', array( 'ID' => $styleId ) );
    
        if( empty( $jQuery ) ) {

            $body = $this->findAll( 'BODY' );

            if( empty( $body ) )
                throw new \Exception( "Bootstrap extension requires a body element in your document" );

            //Find the last script element in the body
            $scripts = $body[ 0 ]->find( 'SCRIPT', array(), false );

            $jQuery[ 0 ] = new \Xtpl\Nodes\Element( 'SCRIPT', array(
                'ID' => $jQueryId,
                'SRC' => '//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'
            ) );

            if( empty( $scripts ) )
                $body[ 0 ]->addChild( $jQuery[ 0 ] );
            else
                $body[ 0 ]->insertBefore( $scripts[ 0 ], $jQuery[ 0 ] );
        }

        if( empty( $script ) ) {

            $script = new \Xtpl\Nodes\Element( 'SCRIPT', array(
                'ID' => $scriptId,
                'SRC' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'
            ) );

            $jQuery[ 0 ]->getParent()->insertAfter( $jQuery[ 0 ], $script );
        }

        if( empty( $library ) ) {

            $library = new \Xtpl\Nodes\Element( 'SCRIPT', array( 'ID' => $libraryId ) );
            $library->addChild( new \Xtpl\Nodes\TextNode( $this->getLibraryJs() ) );

            $script->getParent()->insertAfter( $script, $library );
        }

        if( empty( $style ) ) {

            $head = $this->findAll( 'HEAD' );
        
            if( empty( $head ) )
                throw new \Exception( "Bootstrap extension requires a head element in your document" );

            $styles = $head[ 0 ]->find( 'LINK', array( 'REL' => 'stylesheet' ), false );

            $style = new \Xtpl\Nodes\Element( 'LINK', array(
                'ID' => $styleId,
                'REL' => 'stylesheet',
                'HREF' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css'
            ) );

            if( empty( $styles ) )
                $head[ 0 ]->addChild( $style );
            else
                $head[ 0 ]->insertBefore( $styles[ 0 ], $style );
        }
    }

    protected function getLibraryJs() {


        return <<<JS

( function( \$, undefined ) {

    \$.fn.disable = function() {

        return \$( this ).each( function() {

            \$el = \$( this ),
            \$el.addClass( 'disabled' )
               .attr( 'disabled', 'disabled' )
               .children( 'input, select, button, a, textarea, li' )
                  .disable();   

        } );
    };


    \$.fn.enable = function() {

        return \$( this ).each( function() {

            \$el = $( this ),
            \$el.removeClass( 'disabled' )
               .removeAttr( 'disabled' )
               .children( 'input, select, button, a, textarea, li' )
                  .enable();

        } );
    };

} )( jQuery );

JS;
    }
}