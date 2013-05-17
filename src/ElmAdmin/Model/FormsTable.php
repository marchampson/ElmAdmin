<?php
namespace ElmAdmin\Model;
use Zend\Db\TableGateway\TableGateway;

class FormsTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getForm($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getFormByAlias($alias)
    {
        $rowset = $this->tableGateway->select(array('alias' => $alias));
        $row = $rowset->current();
        return $row;
    }

    public function getFormByName($name)
    {
        $rowset = $this->tableGateway->select(array('name' => $name));
        $row = $rowset->current();
        return $row;
    }
    
    public function saveForm(Forms $form)
    {
        $data = array(
                'name' => $form->name,
                'description' => $form->description,
                'alias' => $form->alias,
                'status' => $form->status,
        );
    
        $id = (int)$form->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getForm($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

        return $id;
    }
    
    public function deleteForm($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}