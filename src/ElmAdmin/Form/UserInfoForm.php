<?php
namespace ElmAdmin\Form;

use Zend\Form\Form as Form;
use Zend\Form\Fieldset;
use Zend\Form\Element as Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\InputFilter;


class UserInfoForm extends Form implements InputFilterProviderInterface
{
    protected $groups;
    protected $fieldsetArray;

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
        $this->setAttribute('method', 'post');
        
        /*
	     * Hidden Elements
	     */
	    $id = new Element\Hidden('id');
        
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
		
		$phone = new Element\Text('phone');
		$phone->setLabel('Phone #');
		
		$extension = new Element\Text('extension');
		$extension->setLabel('Extension #');

		$role = new Element\Select('role');
		$role->setLabel('Role')
			   ->setOptions(array('options' => array('account' => 'account', 'user' => 'user', 'admin' => 'admin')));
		
		
		$this->fieldsetArray = array(
		        'Details' => array(
		                'id',
		                'group_id',
		                'first_name',
		                'last_name',
		                'email',
		                'password',
		                'role',
		        ),
		);

		$this->add($group_id)
		     ->add($first_name)
		     ->add($last_name)
		     ->add($email)
		     ->add($password)
			 ->add($role);
	}

	public function getFieldsetArray()
	{
	    return $this->fieldsetArray;
	}
	
	/**
	 * @return array
	 */
	public function getInputFilterSpecification()
	{
	    return array(
	            'group_id' => array(
	                    'required' => false,
	
	            )
	    );
	}
}
