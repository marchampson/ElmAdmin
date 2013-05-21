<?php
namespace ElmAdmin\Form;

use Zend\Form\Form as Form;
use Zend\Form\Fieldset;
use Zend\Form\Element as Element;


class FormSettingsForm extends Form
{
    protected $fields;
    protected $fieldsetArray;

   
   	public function setFields($storedAlias)
   	{
   		//$alias = '\ElmContent\Form\WebpageForm';
   		$aliasForm = new $storedAlias;
   		return $aliasForm;

   	}
    
	public function __construct($name = null, $storedAlias = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        
        // Array of field sets and fields from aliased form
        if($storedAlias != '') {
        	$aliasFormFieldSets = $this->setFields($storedAlias);	
        }
        
        
        // Hidden Elements
	    $id = new Element\Hidden('id');
        
        $name = new Element\Text('name');
        $name->setLabel('Form Name');
        
        $description = new Element\Textarea('description');
        $description->setLabel('Description');
        
		$alias = new Element\Text('alias');
		$alias->setLabel('Alias');
		
		$status = new Element\Select('status');
		$status->setLabel('Form Status');
		$status->setOptions(array('options' => array('Live' => 'Live','Draft' => 'Draft')));

		$this->fieldsetArray = array(
		        'Details' => array(
		                'id',
		                'name',
		                'description',
		                'alias',
		                'status',
		        ),
		);

		$this->add($id)
			 ->add($name)
		     ->add($description)
		     ->add($alias)
		     ->add($status);

		// Set up the settings for the fieldsets
		if($storedAlias != null) {
			$i = 1;
			foreach($aliasFormFieldSets as $k => $v) {
				if($v->getAttribute('type') != 'hidden') {
					//echo $v->getName();
					// Label
					${'fs'.$i.'_field_label'} = new Element\Text('fs<>'.$v->getName().'<>label');
	        		${'fs'.$i.'_field_label'}->setLabel($v->getName(). ' label');
	        		$this->add(${'fs'.$i.'_field_label'});
					
					// Description
					${'fs'.$i.'_field_description'} = new Element\Textarea('fs<>'.$v->getName().'<>description');
	        		${'fs'.$i.'_field_description'}->setLabel($v->getName(). ' description');
	        		$this->add(${'fs'.$i.'_field_description'});
					
					// Active
					${'fs'.$i.'_field_status'} = new Element\Select('fs<>'.$v->getName().'<>status');
	        		${'fs'.$i.'_field_status'}->setLabel($v->getName(). ' status');
	        		${'fs'.$i.'_field_status'}->setOptions(array('options' => array('Live' => 'Live','Draft' => 'Draft')));
	        		$this->add(${'fs'.$i.'_field_status'});
	        		

	        		$this->fieldsetArray[$v->getName()] = array(
	        				'fs<>'.$v->getName().'<>label',
	        				'fs<>'.$v->getName().'<>description',
	        				'fs<>'.$v->getName().'<>status',
	        				
	        			);
	        		$i++;
				}
			}
		} 
	}

	public function getFieldsetArray()
	{
	    return $this->fieldsetArray;
	}
}
