<?php
namespace ElmAdmin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Forms implements InputFilterAwareInterface
{
	public $id;
	public $name;
	public $description;
	public $alias;
	public $status;
	protected $inputFilter;
	
	public function exchangeArray($data)
	{
	    $this->id     = (isset($data['id']))     ? $data['id'] : null;
	    $this->name = (isset($data['name'])) ? $data['name'] : null;
	    $this->description  = (isset($data['description']))  ? $data['description']  : null;
	    $this->alias  = (isset($data['alias']))  ? $data['alias']  : null;
	    $this->status  = (isset($data['status']))  ? $data['status']  : null;
	}
	
	public function getArrayCopy()
	{
	    return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
	    throw new \Exception("Not used");
	}
	
	public function getInputFilter()
	{
	    if (!$this->inputFilter) {
	        $inputFilter = new InputFilter();
	        $factory     = new InputFactory();
	
	        $inputFilter->add($factory->createInput(array(
	                'name'     => 'id',
	                'required' => true,
	                'filters'  => array(
	                        array('name' => 'Int'),
	                ),
	        )));
	        
	        $this->inputFilter = $inputFilter;
	    }
	
	    return $this->inputFilter;
	}
}
