<?php

function __autoload( $class ) {

    $path = 'library/'.str_replace( '\\', '/', $class ).'.php';

    if( file_exists( $path ) )
        include $path;

    return class_exists( $class, false );
}


$compiler = new Xtpl\Compiler;

$root = $compiler->compile( 'templates/index/index' );
echo '<pre>';

$compiler->dump( $root );

echo htmlspecialchars( $root->render( true ) );

echo '</pre>';
