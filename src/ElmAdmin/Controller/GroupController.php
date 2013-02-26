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
use ElmAdmin\Model\Group;
use ElmAdmin\Form\GroupForm;

class GroupController extends AbstractActionController
{

	/**
	 * Represents a Zend\Db\Tablegateway\Tablegateway model
	 * @var ElmAdmin\Model\GroupsTable
	 */
	protected $groupsTable;

	/**
	 * Lists group
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
	public function indexAction()
    {
    	$groups = $this->getGroupsTable()->fetchAll();
    	
    	// Build up the list json
    	$jsonArray = array(
    	    'headers' => array('Type', 'Name', 'Actions')
    	);
        $groupsArray = array();
    	foreach($groups as $group) {
    	    $groupsArray[] = array(
    	            'rowId' => $group->id,
    	            'cells' => array(
    	                        array("value" => $group->type,
    	                              "type" => 'string'),
    	                        array("value" => $group->name,
    	                              'type' => 'string'),
    	                        array('type' => 'actions',
    	                               'actions' => array(
    	                    array('url' => '/elements/admin/group/edit/'.$group->id,
    	                            'type' => 'btn-warning edit',
    	                            'text' => 'Edit'),
    	                    array('url' => '/elements/admin/group/delete/'.$group->id,
    	                            'type' => 'btn-danger delete',
    	                            'text' => 'Delete')
    	                                       )
    	                                )
    	            )
    	     );
    	}
    	$jsonArray['data'] = $groupsArray;
  
    	$view = new ViewModel(array('data' => json_encode($jsonArray)));
    	$view->setTemplate('elm-content/item/list.phtml');
        return $view;
    }
    
    public function addAction()
    {
    	$message = '';
    	$data = '';
    	$form = new GroupForm();
    	$form->get('submit')->setValue('Add');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    	    $group = new Group();
    	    $form->setInputFilter($group->getInputFilter());
    	    $form->setData($request->getPost());
    	
    	    if ($form->isValid()) {
    	        $group->exchangeArray($form->getData());
    	        $this->getGroupsTable()->saveGroup($group);
    	
    	        // Redirect to list of groups
    	        return $this->redirect()->toRoute('admin-group');
    	    }
    	}
    	
        return new ViewModel(array('form' => $form, 'data' => $data, 'message' => $message));
    }
    
    public function editAction()
    {
        $message = '';
        $data = '';
        $request = $this->getRequest();
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('admin-group', array('action'=>'add'));
        }
        $group = $this->getGroupsTable()->getGroup($id);
        $form = new GroupForm();
        $form->bind($group);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($group->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getGroupsTable()->saveGroup($form->getData());

                // Redirect to list of groups
                return $this->redirect()->toRoute('admin-group');
            }
        } else {
            $data = $request->getPost();
        }
        return new ViewModel(array('id' => $id, 'form' => $form, 'data' => $data, 'message' => $message));
    }
    
    public function deleteAction()
    {
    
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('admin-group');
        }
    
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getGroupsTable()->deleteGroup($id);
            }
    
            // Redirect to list of albums
            return $this->redirect()->toRoute('admin-group');
        }
    
        return array(
                'id' => $id,
                'group' => $this->getGroupsTable()->getGroup($id)->getArrayCopy()
        );
    }

    public function getGroupsTable()
    {
        if (!$this->groupsTable) {
            $sm = $this->getServiceLocator();
            $this->groupsTable = $sm->get('ElmAdmin\Model\GroupsTable');
        }
        return $this->groupsTable;
    }
	
}

