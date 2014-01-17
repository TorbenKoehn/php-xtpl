<?php

$xtpl->displayFile( 'features/conditions', array(
    'title' => 'Feature: Conditions',
    'variables' => array(
        'testVar1' => '',
        'testVar2' => 'Test string',
        'testVar3' => 25,
        'testVar4' => array(
            'someKey' => 'someValue',
            'someOtherKey' => 243
        ),
        'testVar5' => (object)array(
            'someKey' => 'someValue',
            'someOtherKey' => 243
        )
    )
), true );