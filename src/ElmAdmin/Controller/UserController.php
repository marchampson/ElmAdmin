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
use ElmAdmin\Model\User;
use ElmAdmin\Form\UserInfoForm;
use ElmAdmin;
use Zend\Mail\Message as Message;
use Zend\Mail\Transport\Sendmail;

class UserController extends AbstractActionController
{

	/**
	 * Represents a Zend\Db\Tablegateway\Tablegateway model
	 * @var ElmAdmin\Model\UsersTable
	 */
	protected $usersTable;

	/**
	 * Lists users
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction()
    {
    	$users = $this->getUsersTable()->fetchAll();
    	
    	// Build up the list json
    	$jsonArray = array(
    	    'headers' => array('Name', 'Email', 'Company', 'Role', 'Actions')
    	);
        $usersArray = array();
    	foreach($users as $user) {
    	    $usersArray[] = array(
    	            'rowId' => $user->id,
                    'heading' => array(
                            array('value' => $user->first_name . ' ' . $user->last_name, 'type' => 'string', 'span' => 2),
                            array('value' => $user->email, 'type' => 'string', 'span' => 2),
                            array('value' => $user->group_id, 'type' => 'string', 'span' => 1),
                            array('value' => $user->role, 'type' => 'string', 'span' => 2),
                            array('type' => 'actions',
                                    'span' => 3,
                                    'actions' => array(
                                            array('url' => '/elements/admin/user/edit/'.$user->id,
                                                    'type' => 'edit',
                                                    'text' => 'Edit'),
                                            array('url' => '/elements/admin/user/delete/'.$user->id,
                                                    'type' => 'delete',
                                                    'text' => 'Delete')
                                    ),
        
                            )
                    ),
    	     );
    	}

  
    	$view = new ViewModel(array('data' => json_encode($usersArray),
                                    'bData' => array('url' => '/elements/admin/user/add', 'text' => 'Add User', 'namespace' => 'user')));
    	$view->setTemplate('elm-content/webpage/list.phtml');
        return $view;
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
    	$form = $this->getServiceLocator()->get('ElmAdmin\Form\UserInfoForm');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    	    $user = new User();
    	    $form->setInputFilter($user->getInputFilter());
    	    $form->setData($request->getPost());
    	
    	    if ($form->isValid()) {
    	        $user->exchangeArray($form->getData());
    	        $this->getUsersTable()->saveUser($user);
    	        
    	        if($user->role != 'account') {
    	            // Send new user an email:
    	            $message = new Message();
    	            $link = 'http://'.$_SERVER['HTTP_HOST'] . '/elements/login';
    	            $message->setBody("You are receiving this email because a user has been set up to access Elements. Your login details are:\n\nEmail: {$user->email}\n\nPassword: {$user->password}\n\nPlease go to:\n\n $link\n\n to log in\n\n");
    	            $message->setFrom('noreply@elements-cms.com', 'Elements CMS');
    	            $message->addTo($user->email);
    	            $message->setSubject('New user account on Elements CMS');
    	            $transport = new Sendmail();
    	            $transport->send($message);    	            
    	             
    	        } else {
    	            
    	            // Send new user an email:
    	            $message = new Message();
    	            $link = 'http://'.$_SERVER['HTTP_HOST'];
    	            $message->setBody("You are receiving this email because an account has been set up for you to log in to:\n\n http://".$_SERVER['HTTP_HOST'].".\n\n Your login details are:\n\nEmail: {$user->email}\n\nPassword: {$user->password}\n\nPlease go to:\n\n $link\n\n to log in\n\n");
    	            $message->setFrom('noreply@elements-cms.com', $_SERVER['HTTP_HOST'] . ' Admin');
    	            $message->addTo($user->email);
    	            $message->setSubject($_SERVER['HTTP_HOST'] . ' Account Access Details');
    	            $transport = new Sendmail();
    	            $transport->send($message);
    	             
    	        }
    	        
    	
    	        // Redirect to list of users
    	        return $this->redirect()->toRoute('admin-user');
    	    }
    	}
        $this->layout('layout/forms');
    	$view = new ViewModel(array('form' => $form, 'data' => $data, 'message' => $message)); 
        $view->setTemplate('elm-content/webpage/add');
        return $view;
    }
    
    public function editAction()
    {
        $message = '';
        $data = '';
        $request = $this->getRequest();
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('admin', array('action'=>'add'));
        }
        $user = $this->getUsersTable()->getUser($id);
        $form = $this->getServiceLocator()->get('ElmAdmin\Form\UserInfoForm');
        $form->bind($user);
        // Passwords are md5 encrypted so remove from the edit field
        // Changes are handled by the user in a different process.
        $form->remove('password');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUsersTable()->saveUser($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('admin-user');
            }
        } else {
            $data = $request->getPost();
        }
        $view = new ViewModel(array('id' => $id, 'form' => $form, 'data' => $data, 'message' => $message));
        $this->layout('layout/forms');
        $view->setTemplate('elm-content/webpage/add');
        return $view;
    }

    public function getUsersTable()
    {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('ElmAdmin\Model\UsersTable');
        }
        return $this->usersTable;
    }
	
}

