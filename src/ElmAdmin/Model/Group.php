<?php
namespace ElmAdmin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Group implements InputFilterAwareInterface
{
	public $id;
	public $type;
	public $name;
	public $reference;
	public $address1;
	public $address2;
	public $town;
	public $county;
	public $postcode;
	public $country;
	
	protected $inputFilter;
	
	public function exchangeArray($data)
	{
	    $this->id     = (isset($data['id']))     ? $data['id']     : null;
	    $this->type = (isset($data['type'])) ? $data['type'] : null;
	    $this->name  = (isset($data['name']))  ? $data['name']  : null;
	    $this->reference  = (isset($data['reference']))  ? $data['reference']  : null;
	    $this->address1  = (isset($data['address1']))  ? $data['address1']  : null;
	    $this->address2  = (isset($data['address2']))  ? $data['address2']  : null;
	    $this->town  = (isset($data['town']))  ? $data['town']  : null;
	    $this->county  = (isset($data['county']))  ? $data['county']  : null;
	    $this->postcode  = (isset($data['postcode']))  ? $data['postcode']  : null;
	    $this->country  = (isset($data['country']))  ? $data['country']  : null;
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
	
            /*
             * @todo can we inject current email addresses and then check new email doesn't match?
             */
	        
	        $this->inputFilter = $inputFilter;
	    }
	
	    return $this->inputFilter;
	}
}
