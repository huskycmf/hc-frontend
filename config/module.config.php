<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',

    'service_manager' => include __DIR__ . '/module/service_manager.config.php',
    'di' => include __DIR__ . '/module/di.config.php',

    'hc-frontend'=> array(),

    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'HcFrontend' => __DIR__ . '/../public',
            )
        )
    )
);
