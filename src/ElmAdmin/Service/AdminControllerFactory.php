<?php

namespace Admin\Service;

use Admin\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $allServices = $services->getServiceLocator();
        $adminService = $allServices->get('admin-service');
        $controller  = new IndexController();
        $controller->setAdminService($adminService);
        return $controller;
    }
}
