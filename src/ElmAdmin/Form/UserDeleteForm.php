<?php
namespace ElmAdmin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserDeleteForm extends Form
{
	public function prepareElements($userList)
	{
		$users = new Element\MultiCheckbox('users');
		$users->setOptions(array('options' => $userList));
				
		$submit = new Element\Submit('submit');
		$submit->setAttributes(array('value' => 'Delete', 'class' => 'form_element_submit'));
		
		$this->add($users)
		     ->add($submit);
	}
}