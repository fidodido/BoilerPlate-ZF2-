<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Navigation' => 'Navigation\Model\NavigationFactory'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'acemenu' => __DIR__ . '/../view/partials/acemenu.phtml',
            'acebreadcrumbs' => __DIR__ . '/../view/partials/acebreadcrumbs.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
