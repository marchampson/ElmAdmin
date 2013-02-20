<?php
namespace ElmAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserInfoForm extends Form
{
	public function prepareElements()
	{
		$email = new Element\Text('email');
		$email->setLabel('Email');

		$status = new Element\Select('status');
		$status->setLabel('Status')
			   ->setOptions(array('options' => array('0' => 'Unconfirmed', '1' => 'Normal', '2' => 'Admin')));
		
		$realName = new Element\Text('realName');
		$realName->setLabel('Real Name')
				 ->setAttributes(array('maxlength' => 128, 'size' => 40));
		
		$password = new Element\Password('password');
		$password->setLabel('Password')
				 ->setAttributes(array('maxlength' => 128, 'size' => 40));
		
		$preferences = new Element\Text('preferences');
		$preferences->setLabel('Preferences')
					->setAttributes(array('title' 		=> 'Separate multiple preferences with a ";"',
            							  'maxlength' 	=> 254,
            							  'size'		=> 40,));
		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Add/Update');

		$this->add($email)
			 ->add($status)
			 ->add($realName)
			 ->add($password)
			 ->add($preferences)
			 ->add($submit);
	}
}