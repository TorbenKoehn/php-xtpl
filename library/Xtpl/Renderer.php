<?php

namespace Xtpl;

class Renderer {

    protected $compiler;
    protected $cacheDirectory;
    protected $cacheInterval = 3600;
    protected $baseDirectory;
    protected $vars = array();

    public function __construct( $cacheDirectory = null, Compiler $compiler = null ) {

        $this->cacheDirectory = $cacheDirectory;
        $this->compiler = $compiler ? $compiler : new Compiler;
    }

    public function getCompiler() {

        return $this->compiler;
    }

    public function render( $string, $nice = false ) {

        return $this->compiler->compile( $string )->render( $nice );
    }

    public function renderFile( $path, $nice = false ) {

        return $this->compiler->compileFile( $path )->render( $nice );
    }

    public function renderToFile( $string, $file, $nice = false ) {

        $phtml = $this->render( $string, $nice );

        file_put_contents( $file, $phtml );
    }

    public function renderFileToFile( $path, $file, $nice = false ) {

        $phtml = $this->renderFile( $path, $nice );

        file_put_contents( $file, $phtml );
    }

    public function setCacheDirectory( $directory ) {

        $this->cacheDirectory = $directory;
    }

    public function setCacheInterval( $interval ) {

        $this->cacheInterval = $interval;
    }

    public function setBaseDirectory( $directory ) {

        $this->baseDirectory = $directory;
    }

    public function display( $string, array $vars = array(), $nice = false ) {

        $vars = array_merge( $this->vars, $vars );
        extract( $vars );

        if( !$this->cacheDirectory ) {

            eval( '?>'.$this->render( $string, $nice ) );
            return;
        } else if( !is_writable( $this->cacheDirectory ) )
            throw new \Exception( "Cache directory $this->cacheDirectory is not writable" );

        $key = md5( $string );
        $path = $this->cacheDirectory.DIRECTORY_SEPARATOR.$key.'.phtml';

        if( file_exists( $path ) && time() - filemtime( $path ) < $this->cacheInterval ) {

            include $path;
            return;
        }

        $this->renderToFile( $string, $path, $nice );
        include $path;
    }

    public function displayFile( $file, array $vars = array(), $nice = false ) {

        $vars = array_merge( $this->vars, $vars );
        extract( $vars );

        if( !empty( $this->baseDirectory ) )
            $file = $this->baseDirectory.DIRECTORY_SEPARATOR.$file;

        if( !$this->cacheDirectory ) {

            eval( '?>'.$this->renderFile( $file, $nice ) );
            return;
        } else if( !is_writable( $this->cacheDirectory ) )
            throw new \Exception( "Cache directory $this->cacheDirectory is not writable" );

        $key = md5( $file ).'.'.basename( $file, '.xtpl' );
        $path = $this->cacheDirectory.DIRECTORY_SEPARATOR.$key.'.phtml';

        if( file_exists( $path ) && time() - filemtime( $path ) < $this->cacheInterval ) {

            include $path;
            return;
        }

        $this->renderFileToFile( $file, $path, $nice );
        include $path;
    }

    public function __get( $key ) {

        return $this->vars[ $key ];
    }

    public function __set( $key, $value ) {

        $this->vars[ $key ] = $value;
    }
}