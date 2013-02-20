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
            'admin-index' => 'ElmAdmin\Controller\UserController',
        ),
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
            'admin-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/elements/admin/user',
                    'defaults' => array(
                        'controller' => 'admin-index',
                        'action'     => 'index',
                    ),
                ),
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
