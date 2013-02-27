<?php
/*
 * Use this file to set up any dependencies for the Item Controller
 * 
 */
namespace ElmAdmin\Service;
//use ElmContent\Entity\Pages;
//use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GroupsService implements ServiceLocatorAwareInterface
{
	
	protected $serviceLocator;
	protected $groupsTable;
	

	public function getServiceLocator ()
	{
		return $this->serviceLocator;
	}
	
	public function setServiceLocator (ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}
	
    public function getGroupsTable()
    {
        if (!$this->groupsTable) {
            $sm = $this->getServiceLocator();
            $this->groupsTable = $sm->get('ElmAdmin\Model\GroupsTable');
        }
        return $this->groupsTable;
    }
	
	public function getGroups()
	{
		
		$groups = $this->getGroupsTable()->fetchAll();
		
		$groupsArray = array(); // instantiate
		
		if(count($groups) > 0) {
			foreach($groups as $group) {
				$groupsArray[$group->id] = $group->name;						
			}	
		}
		return $groupsArray;	
	}
	
}