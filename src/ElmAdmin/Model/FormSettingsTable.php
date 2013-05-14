<?php
namespace ElmAdmin\Model;

use Zend\Db\TableGateway\TableGateway;

class FormSettingsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($formId)
    {
        $resultSet = $this->tableGateway->select(array('form_id' => $formId));
        return $resultSet;
    }
    
    public function fetch($select)
    {
    	$result = $this->tableGateway->select($select);
    	return $result->toArray();
    }

    public function getFormSetting($formId, $field)
    {
        $formId  = (int) $formId;
        $rowset = $this->tableGateway->select(array('form_id' => $formId, 'field' => $field));
        $row = $rowset->current();
        return $row;
    }

    public function saveFormSetting($formId, $field, $label, $description, $status)
    {
        // Set values to data array
        $data = array(
                'form_id' => $formId,
                'field' => $field,
                'label' => $label,
                'description' => $description,
                'status' => $status
        );

        $row = $this->getFormSetting($formId, $field);
        if ((int) $row['id']) {
            $this->tableGateway->update($data, array('id' => $row['id']));
        } else {
            $this->tableGateway->insert($data);
        }
        
    }    
}