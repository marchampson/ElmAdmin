<?php
namespace ElmAdmin\Controller;
/**
 *
 * @author marchampson
 *
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\Adapter as Adapter;
use Zend\View\Model\ViewModel;
use ElmAdmin\Model\Forms;
use ElmContent\Utilities\Text;

class FormController extends AbstractActionController
{
    protected $formsTable;
    protected $formSettingsTable;
    
    public function getFormsTable()
    {
        if(!$this->formsTable) {
            $sm = $this->getServiceLocator();
            $this->formsTable = $sm->get('ElmAdmin\Model\FormsTable');
        }
        return $this->formsTable;
    }
    
    public function getFormSettingsTable()
    {
        if(!$this->formSettingsTable) {
            $sm = $this->getServiceLocator();
            $this->formSettingsTable = $sm->get('ElmAdmin\Model\FormSettingsTable');
        }
        return $this->formSettingsTable;
    }
    
    public function listAction ()
    {
        $config = $this->getServiceLocator()->get('Config');
    
        $forms = $this->getFormsTable()->fetchAll(); 
    
        $formsArray = array();
        
        foreach($forms as $form) {
            $formsArray[] = array(
                    'rowId' => $form->id,
                    'heading' => array(
                            array('type' => 'state',
                                    'state' => array(
                                            array('value'=>strtolower($form->status),
                                                    'type' => 'select',
                                                    'options' => array('draft', 'live', 'private')
                                            ),
                                            array('value' => '', 'type' => 'status')
                                            
                                    ),
                                    'span' => 2
        
                            ),
                            array('value' => $form->name, 'type' => 'string', 'span' => 5),
                            array('type' => 'actions',
                                    'span' => 3,
                                    'actions' => array(
                                            array('url' => '/elements/admin/form/edit/'.$form->id,
                                                    'type' => 'edit',
                                                    'text' => 'Edit'),
                                            array('url' => '/elements/category/form/delete'.$form->id,
                                                    'type' => 'delete',
                                                    'text' => 'Delete')
                                    ),
        
                            )
                     
                    ),
    
            );
        }
        
        $view = new ViewModel(
                array('data'=> json_encode($formsArray),
                      'bData' => array('url' => '/elements/admin/form/add', 'text' => 'Add Form', 'namespace' => 'form')
                ));
    
        
        $view->setTemplate('elm-content/webpage/list.phtml');
        return $view;
    }
    
    public function addAction()
    {
        // Get config settings
        $config = $this->getServiceLocator()->get('Config');
        
        $data = ''; // initialise
        
        //$form = $this->getServiceLocator()->get('ElmAdmin\Form\FormSettingsForm');
        $form = new \ElmAdmin\Form\FormSettingsForm;

        $request = $this->getRequest();
        if ($request->isPost()) {

            $page = new Forms();

            // Set InputFilters
            $form->setInputFilter($page->getInputFilter());
        
            // Send form data to filter
            $form->setData($request->getPost());
            
            //print_r($request->getPost());
        
            // Check valid
            if ($form->isValid()) {
                
                $data = $form->getData();
                
                $page->exchangeArray($data);
        
                $id = $this->getFormsTable()->saveForm($page);
                
                $fieldArray = array();
                foreach($request->getPost() as $k => $v) {
                    if(substr($k,0,4)=='fs<>') {
                        $fieldName = explode('<>',$k);
                        if(!in_array($fieldName[1],$fieldArray)) {
                            $this->getFormSettingsTable()->saveFormSetting($id, $fieldName[1], $request->getPost('fs<>'.$fieldName[1].'<>label'), $request->getPost('fs<>'.$fieldName[1].'<>description'), $request->getPost('fs<>'.$fieldName[1].'<>status'));
                            $fieldArray[] = $fieldName[1];    
                        }
                    } 
                } 
                
                // Reroute back to list
                return $this->redirect()->toRoute('admin-form-settings');
            } else {
                $message = '1.21 Gigawatts - what was I thinking?!?';
            }
            $data = $form->getData();
            //$data = '';
        }
        
        $this->layout('layout/forms');
        
        $view = new ViewModel(array(
                'form' => $form,
                'data' => $data,
        ));
        $view->setTemplate('elm-content/webpage/add.phtml');
        return $view;
    }
    
    public function editAction()
    {
        // Get config settings
        $config = $this->getServiceLocator()->get('Config');
        
        $data = ''; // initialise
        
        // Edit params
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        
        if(! $id) {
            return $this->redirect()->toRoute('admin-form-settings');
        }
        
        // We can bind the main page data to the form
        // but fields have to be individually populated
        // due to the db structure
        $page = $this->getFormsTable()->getForm($id);
        
        $form = new \ElmAdmin\Form\FormSettingsForm;
        
        $form->bind($page);
        
        // Set the fields
        
        $formSettings = $this->getFormSettingsTable()->fetchAll($id);
        foreach($formSettings as $setting) {
            
            if($form->get('fs<>'.$setting->field.'<>label')) {
                $form->get('fs<>'.$setting->field.'<>label')->setValue($setting->label);
            }

            if($form->get('fs<>'.$setting->field.'<>description')) {
                $form->get('fs<>'.$setting->field.'<>description')->setValue($setting->description);
            }

            if($form->get('fs<>'.$setting->field.'<>status')) {
                $form->get('fs<>'.$setting->field.'<>status')->setValue($setting->status);
            }
            
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Set InputFilters
            $form->setInputFilter($page->getInputFilter());
        
            // Send form data to filter
            $form->setData($request->getPost());
        
            // Check valid
            if ($form->isValid()) {
                
                $data = $form->getData();
                
                $this->getFormsTable()->saveForm($data);

                // fields
                $fieldArray = array();
                foreach($request->getPost() as $k => $v) {
                    if(substr($k,0,4)=='fs<>') {
                        $fieldName = explode('<>',$k);
                        if(!in_array($fieldName[1],$fieldArray)) {
                            $this->getFormSettingsTable()->saveFormSetting($id, $fieldName[1], $request->getPost('fs<>'.$fieldName[1].'<>label'), $request->getPost('fs<>'.$fieldName[1].'<>description'), $request->getPost('fs<>'.$fieldName[1].'<>status'));
                            $fieldArray[] = $fieldName[1];    
                        }
                    } 
                } 

                // Reroute back to list
                return $this->redirect()->toRoute('admin-form-settings');
            } else {
                $message = '1.21 Gigawatts - what was I thinking?!?';
            }
            $data = $form->getData();
            //$data = '';
        }
        
        $this->layout('layout/forms');
        
        $view = new ViewModel(array(
                'id' => $id,
                'form' => $form,
                'data' => $data,
        ));
        $view->setTemplate('elm-content/webpage/add.phtml');
        return $view;
    }
    
    public function deleteAction()
    {
        // Turned off for now
        return $this->redirect ()->toRoute ( 'admin-form-settings' );
        /*
        $id = ( int ) $this->getEvent ()->getRouteMatch ()->getParam ( 'id' );
        if (! $id) {
            return $this->redirect ()->toRoute ( 'banner-cms' );
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost('id');
                // remove all associations
                $this->getCategoryAssociationsTable()->deleteByPageId($id, 'banner');
                 
                // Content nodes
                $sql = "delete from content_nodes where page_id = $id";
                $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
                $result = $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
                 
                // Delete the page
                $this->getPagesTable()->deletePage($id);
                 
               
            }
        
            // Redirect to page list
            return $this->redirect()->toRoute('banner-cms');
        }
        
        return array(
                'id' => $id,
                'page' => $this->getPagesTable()->getPage($id)
        );
        */
    }
}