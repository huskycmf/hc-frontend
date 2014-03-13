<?php
return array(
    'routes' => array(
        'hc-frontend' => array(
            'type' => 'literal',
            'options' => array(
                'route' => '/[:lang]',
                'constraints' => array(
                    'lang' => '[a-z]{2}(\-[A-Za-z]{2})?'
                )
            )
        )
    )
);
