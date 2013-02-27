<?php
$config = array(
	/*
	'db' => array(
	        'driver' 	=> 'pdo_mysql',
	        'dbname' 	=> 'zf2widder_work',
	        'host'		=> 'localhost',
	        'username' 	=> 'root',
	        'password' 	=> 'root',
    ),
    */
	
	'controllers' => array(
        'invokables' => array(
            'admin-user' => 'ElmAdmin\Controller\UserController',
            'admin-group' => 'ElmAdmin\Controller\GroupController',
        ),
    ),
        
    'service_manager' => array (
            'invokables' => array (
                    'groupsService' => 'ElmAdmin\Service\GroupsService',
            )
    ),
	'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/elements/admin/user[/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' 	 => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ),
                    'defaults' => array(
                        'controller' => 'admin-index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'admin-user' => array(
                    'type' => 'segment',
                    'options' => array(
                            'route' => '/elements/admin/user[/:action][/:id]',
                            'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                    'controller' => 'admin-user',
                                    'action' => 'index'
                            )
                    )
            ),
            'admin-group' => array(
                    'type' => 'segment',
                    'options' => array(
                            'route' => '/elements/admin/group[/:action][/:id]',
                            'constraints' => array(
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                    'controller' => 'admin-group',
                                    'action' => 'index'
                            )
                    )
            ),
        ),
    ),
    'view_manager' => array(
		//'base_path' => $stringBasePath,		// might need this for the cloud
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
    	'layout'				   => 'layout/layout',
    	'template_map' => array(
            'admin-index/index'   => __DIR__ . '/../view/elm-admin/user/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
return $config;
