<?php
namespace ElmAdmin\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;

class UserInfoFilter
{
	public function prepareFilters()
	{
		$email = new Input('email');
		$email->getValidatorChain()->addValidator(new Validator\EmailAddress());
		$email->getFilterChain()->attachByName('StripTags');
		
		$status = new Input('status');
		$status->getFilterChain()->attachByName('Int');
		$status->getValidatorChain()->addValidator(new Validator\Between(0,2));
		
		$name = new Input('realName');
		$name->getValidatorChain()->addValidator(new Validator\Regex('/\w/'))
								  ->addValidator(new Validator\StringLength(1, 128));
		$name->getFilterChain()->attachByName('StripTags');
		
		$password = new Input('password');
		$password ->getValidatorChain()->addValidator(new Validator\StringLength(1, 16));
		$password ->getFilterChain()->attachByName('StripTags');
		
		$preferences = new Input('preferences');
		$preferences->getValidatorChain()->addValidator(new Validator\StringLength(1, 254));
		$preferences->getFilterChain()->attachByName('StripTags');
		
		$inputFilter = new InputFilter();
		$inputFilter->add($email)
					->add($status)
					->add($name)
					->add($password)
					->add($preferences);
		
		return $inputFilter;
	}
}