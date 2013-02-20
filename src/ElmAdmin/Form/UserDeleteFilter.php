<?php
namespace ElmAdmin\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;

class UserDeleteFilter
{
	public function prepareFilters($userList)
	{
		$users = new Input('users');
		$users->getFilterChain()->attachByName('StripTags');
		$users->getValidatorChain()->addValidator(new Validator\InArray($userList))
		$users->setRequired(FALSE);
		$users->allowEmpty(TRUE);
		
		$inputFilter = new InputFilter();
		$inputFilter->add($users);
		
		return $inputFilter;
	}
}