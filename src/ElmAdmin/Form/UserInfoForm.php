<?php
namespace ElmAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserInfoForm extends Form
{
	public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        
		$email = new Element\Text('email');
		$email->setLabel('Email');

		$role = new Element\Select('role');
		$role->setLabel('Role')
			   ->setOptions(array('options' => array('user' => 'user', 'admin' => 'admin')));
		
		
		$password = new Element\Password('password');
		$password->setLabel('Password')
				 ->setAttributes(array('maxlength' => 128, 'size' => 40));
		
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Edit');

		$this->add($email)
			 ->add($role)
			 ->add($password)
			 ->add($submit);
	}
}