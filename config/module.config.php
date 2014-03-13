<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',

    'doctrine' => array(
        'driver' => array(
            'app_driver' => array(
                'paths' => array(__DIR__ . '/../src/HcBackend/Entity')
            ),
            'orm_default' => array('drivers' => array('HcBackend\Entity' => 'app_driver'))
        )
    ),

    'service_manager' => include __DIR__ . '/module/service_manager.config.php',
    'di' => include __DIR__ . '/module/di.config.php',

    'hc-frontend'=> array(

    ),

    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'HcFrontend' => __DIR__ . '/../public',
            )
        )
    )
);
