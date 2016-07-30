<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file. 10.71.249.2 1524 desapar
 */
return array(
    'db' => array(
        'driver' => 'Mysqli',
        'database' => 'boilerplate',
        'host' => 'localhost'
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            'OracleAdapter' => function($sm) {
                $config = $sm->get('Config');
                return new Zend\Db\Adapter\Adapter($config['oradb']);
            },
        ),
        'aliases' => array(
            'db' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
);
