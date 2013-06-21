<?php
namespace ElmAdmin\Model;
use Zend\Db\TableGateway\TableGateway;

class GroupsTable
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
    
    public function getGroup($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
    public function saveGroup(Group $group)
    {
        $data = array(
                'type' => $group->type,
                'name' => $group->name,
                'reference' => $group->reference,
                'address1' => $group->address1,
                'address2' => $group->address2,
                'town' => $group->town,
                'county' => $group->county,
                'postcode' => $group->postcode,
                'country' => $group->country
        );
    
        $id = (int)$group->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGroup($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
    
    public function deleteGroup($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}