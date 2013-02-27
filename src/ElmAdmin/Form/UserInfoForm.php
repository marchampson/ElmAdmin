<?php
namespace ElmAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserInfoForm extends Form
{
    protected $groups;

    public function setGroupsService(\ElmAdmin\Service\GroupsService $service)
    {
        $this->groups = $service;
        $optionsArray = array('' => 'Select one');
        foreach($this->groups->getGroups() as $key => $val) {
            $optionsArray[$key] = $val;
        }
        $this->get('group_id')->setOptions(array('options' => $optionsArray, 'description' => 'Select a user group if applicable.'));
    }
    
	public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        
        $this->add(array(
                'name' => 'id',
                'attributes' => array(
                        'type'  => 'hidden',
                ),
        ));
        
        $group_id = new Element\Select('group_id');
        $group_id->setLabel('User group');
        
        $first_name = new Element\Text('first_name');
        $first_name->setLabel('First Name');
        
        $last_name = new Element\Text('last_name');
        $last_name->setLabel('Last Name');
        
		$email = new Element\Text('email');
		$email->setLabel('Email');
		
		$password = new Element\Password('password');
		$password->setLabel('Password')
		->setAttributes(array('maxlength' => 128, 'size' => 40));

		$role = new Element\Select('role');
		$role->setLabel('Role')
			   ->setOptions(array('options' => array('user' => 'user', 'admin' => 'admin')));
		
		
		$password = new Element\Password('password');
		$password->setLabel('Password')
				 ->setAttributes(array('maxlength' => 128, 'size' => 40));
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Edit');

		$this->add($group_id)
		     ->add($first_name)
		     ->add($last_name)
		     ->add($email)
		     ->add($password)
			 ->add($role)
			 ->add($submit);
	}
}