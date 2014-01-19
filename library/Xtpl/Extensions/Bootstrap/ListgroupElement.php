<?php

namespace Xtpl\Extensions\Bootstrap;

//I'd call it List\GroupElement (list-group), but "list" is a reserved word in PHP
class ListgroupElement extends \Xtpl\Extensions\Bootstrap\ListElement {

    public function __construct( array $attributes = array() ) {
        parent::__construct( $attributes );

        $this->addClass( 'list-group' );
    }
}