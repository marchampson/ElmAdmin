<?php

namespace ElmAdmin\Service;

use ElmAdmin\Controller\UserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\Adapter\Adapter;

class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $allServices = $services->getServiceLocator();
        $table = $allServices->get('admin-users-table');
        $controller  = new UserController();
        $controller->setUsersTable($table);
        return $controller;
    }
}
