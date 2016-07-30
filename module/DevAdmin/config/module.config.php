<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'devadmin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/config',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevAdmin\Controller',
                        'controller' => 'Config',
                        'action' => 'global',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
    ),
    'controllers' => array(
        'invokables' => array(
            'DevAdmin\Controller\Config' => 'DevAdmin\Controller\ConfigController',
            'DevAdmin\Controller\Navigation' => 'DevAdmin\Controller\NavigationController',
            'DevAdmin\Controller\Roles' => 'DevAdmin\Controller\RolesController',
            'DevAdmin\Controller\Permission' => 'DevAdmin\Controller\PermissionController',
            'DevAdmin\Controller\Users' => 'DevAdmin\Controller\UsersController'
        ),
    ),
);
