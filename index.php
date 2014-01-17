<?php

error_reporting( E_ALL | E_STRICT );

function __autoload( $class ) {

    $path = __DIR__.'/library/'.str_replace( '\\', '/', $class ).'.php';

    if( file_exists( $path ) )
        include $path;

    return class_exists( $class, false );
}



//Initialize XTPL renderer
$xtpl = new Xtpl\Renderer( __DIR__.'/cache' );

//Just for demonstration, we actually disable caching.
$xtpl->setCacheInterval( 0 );
$xtpl->setBaseDirectory( __DIR__.'/templates' );


$xtpl->menu = array(
    'Features' => array(
        'Readme' => 'index.php?m=features&a=includes',
        'Blocks' => 'index.php?m=features&a=blocks',
        'Includes' => 'index.php?m=features&a=includes',
        'Extending' => 'index.php?m=features&a=extending',
        'Interpolation' => 'index.php?m=features&a=interpolation',
        'Inline PHP' => 'index.php?m=features&a=inline-php',
        'Loops' => 'index.php?m=features&a=loops',
        'Conditions' => 'index.php?m=features&a=conditions',
        'Custom Elements / Plugins' => 'index.php?m=features&a=custom-elements'
    ),
    'Examples' => array(
        'Blog' => 'index.php?m=examples&a=blog'
    )
);


//Load examples
$module = empty( $_GET[ 'm' ] ) ? 'features' : $_GET[ 'm' ];
$action = empty( $_GET[ 'a' ] ) ? 'includes' : $_GET[ 'a' ];

include "examples/$module/$action.php";