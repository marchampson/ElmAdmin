<?php

namespace ElmAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use ElmAdmin\Controller;
use ElmAdmin\Model\User;
use ElmAdmin\Model\UsersTable;
use ElmAdmin\Model\Group;
use ElmAdmin\Model\GroupsTable;
use ElmAdmin\Model\Forms;
use ElmAdmin\Model\FormsTable;
use ElmAdmin\Model\FormSettingsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
        return array(
                'factories' => array(
                        'ElmAdmin\Model\UsersTable' =>  function($sm) {
                            $tableGateway = $sm->get('UsersTableGateway');
                            $table = new UsersTable($tableGateway);
                            return $table;
                        },
                        'UsersTableGateway' => function ($sm) {
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new User());
                            return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                        },
                        'ElmAdmin\Model\GroupsTable' =>  function($sm) {
                            $tableGateway = $sm->get('GroupsTableGateway');
                            $table = new GroupsTable($tableGateway);
                            return $table;
                        },
                        'GroupsTableGateway' => function ($sm) {
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new Group());
                            return new TableGateway('groups', $dbAdapter, null, $resultSetPrototype);
                        },
                        'ElmAdmin\Form\UserInfoForm' => function ($sm) {
                            $groupsService = $sm->get('groupsService');
                            $form    = new Form\UserInfoForm;
                            $form->setGroupsService($groupsService);
                        
                        
                            return $form;
                        },
                        'ElmAdmin\Model\FormsTable' =>  function($sm) {
                            $tableGateway = $sm->get('FormsTableGateway');
                            $table = new FormsTable($tableGateway);
                            return $table;
                        },
                        'FormsTableGateway' => function ($sm) {
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new Forms());
                            return new TableGateway('forms', $dbAdapter, null, $resultSetPrototype);
                        },
                        'ElmAdmin\Model\FormSettingsTable' =>  function($sm) {
                            $tableGateway = $sm->get('FormSettingsTableGateway');
                            $table = new FormSettingsTable($tableGateway);
                            return $table;
                        },
                        'FormSettingsTableGateway' => function ($sm) {
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            return new TableGateway('form_settings', $dbAdapter, null);
                        },
                ),
        );
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
