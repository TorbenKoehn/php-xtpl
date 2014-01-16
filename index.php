<?php

function __autoload( $class ) {

    $path = 'library/'.str_replace( '\\', '/', $class ).'.php';

    if( file_exists( $path ) )
        include $path;

    return class_exists( $class, false );
}


$xtpl = new Xtpl\Compiler;

echo( $xtpl->compile( 'templates/index/index' ) );