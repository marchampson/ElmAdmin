<?php
/**
 * Performs admin functions: add / edit / delete users
 * @author db
 *
 */
namespace ElmAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form;
use ElmAdmin\Service\UserService;
use ElmAdmin\Form\UserInfoForm;
use ElmAdmin\Form\UserInfoFilter;
use ElmAdmin\Form\UserDeleteForm;
use ElmAdmin\Form\UserDeleteFilter;
use ElmAdmin\Model\UsersTable;

class UserController extends AbstractActionController
{

	/**
	 * Represents a Zend\Db\Tablegateway\Tablegateway model
	 * @var ElmAdmin\Model\UsersTable
	 */
	protected $_usersTable;

	/**
	 * Lists users
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction()
    {
    	$userService = new UserService($this->_usersTable);
    	$users = $userService->getAllUsers();
        return new ViewModel(array('users' => $users));
    }

    /**
     * Lists users and allows admin to delete
     * @return \Zend\View\Model\ViewModel
     */
	public function deleteAction()
    {
    	$message = '';
    	$data = '';
    	$count = 0;
    	$request = $this->getRequest();
    	$userService = new UserService($this->_usersTable);
    	$users = $userService->getAllUsers();
    	// Build form elements
    	$form = new UserDeleteForm();
    	$userList = array();
    	foreach ($users as $user) {
    		$userList[$user['email']] = $user['email'];
    	}
    	$form->prepareElements($userList);
       	if ($request->isPost()) {
    		$filter = new UserDeleteFilter();
    		$inputFilter = $filter->prepareFilters($userList);
    		$inputFilter->setData($request->getPost());
    		if ($inputFilter->isValid()) {
    			// ???works???
    			$data = $inputFilter->getRawValue('users');
//				$data = $inputFilter->getValue('users');
    			foreach ($data as $item) {
    				$count += $userService->deleteUserByEmail($item);
    			}
    			$message .= $count . ' user(s) deleted!';
    		} else {
    			$data = $request->getPost();
    		}
    	}
    	return new ViewModel(array('form' => $form, 'data' => $data, 'message' => $message));
    }
    
    public function addAction()
    {
    	$message = '';
    	$data = '';
    	$request = $this->getRequest();
    	$form = new UserInfoForm();
    	$form->prepareElements();
    	if ($request->isPost()) {
    		$filter = new UserInfoFilter();
    		$inputFilter = $filter->prepareFilters();
    		$form->setInputFilter($inputFilter);
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$userService = new UserService($this->_usersTable);
    			$data = $inputFilter->getValues();
    			$message = $userService->addUser($data);
    		} else {
    			$data = $request->getPost();
    		}
    	}
        return new ViewModel(array('form' => $form, 'data' => $data, 'message' => $message));
    }

    /**
     * Called via DI from module.config.php
     * @param \ElmAdmin\Model\UsersTable $usersTable
     * @return \ElmAdmin\Controller\IndexController
     */
	public function setUsersTable(UsersTable $usersTable)
	{
		$this->_usersTable = $usersTable;
		return $this;
	}
	
}

