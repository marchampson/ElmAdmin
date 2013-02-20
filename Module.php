<?php

namespace ElmAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use ElmAdmin\Controller;

class Module implements AutoloaderProviderInterface
{
	protected $_config;
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
		$this->_config = include __DIR__ . '/config/module.config.php';
        return $this->_config;
    }

	/**
     * This method provides configuration for the main application service
     * manager. We're providing a factory for retrieving the MessagesTable.
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array();
    }

    /**
     * This method returns configuration for the ControllerManager.
     *
     * We're using it to define the IndexController for this module, and to
     * ensure it gets configured with the MessagesTable.
     *
     * @return array
     */
    public function getControllerConfig()
    {
        return array();
    }

}
