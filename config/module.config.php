<?php
return array(
    'router' => array(
        'routes' => include __DIR__ . '/route.config.php'
    ),

    'spiffycrud' => array(
        'forms'  => array(),
        'models' => array(),
    ),

    'view_manager' => array(
        'template_map' => array(
            'spiffy-crud/crud/index'   => __DIR__ . '/../view/spiffy-crud/crud/index.phtml',
            'spiffy-crud/crud/details' => __DIR__ . '/../view/spiffy-crud/crud/details.phtml'
        )
    )
);