<?php
namespace ElmAdmin\Service;

use ElmAdmin\Model\UsersTable;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Delete;

class UserService
{
	protected $_usersTable;
	protected $_cols;
	
	public function __construct(UsersTable $usersTable)
	{
		$this->_usersTable = $usersTable;
		$this->_cols = $this->_usersTable->getColumnNames();
	}
	
	public function exchangeArray($data)
	{
	    $this->id     = (isset($data['id']))     ? $data['id']     : null;
	    $this->artist = (isset($data['artist'])) ? $data['artist'] : null;
	    $this->title  = (isset($data['title']))  ? $data['title']  : null;
	}
	
	
	/**
	 * Returns an array consisting of database rows
	 * @return array $result 
	 */
	public function getAllUsers()
	{
		$select = new Select();
		$select->from($this->_usersTable->getTableName())->order($this->_cols['email']);
		$result = $this->_usersTable->selectWith($select);
		return $result->toArray();
	}
	
	/**
	 * Returns as single user. 
	 * @param int $id
	 * @return array $result
	 *
	 */
	public function getUser($id)
	{
	    /*
	    $select = new Select();
	    $where = new Where();
	    $where->equalTo($this->_cols['id'], $id);
	    $select->from($this->_usersTable->getTableName())->where($where);
	    $result = $this->_usersTable->selectWith($select);
	    return $result;
	    */
	    
	    $id  = (int) $id;
	    $rowset = $this->_usersTable->getTableName()->select(array('id' => $id));
	    $row = $rowset->current();
	    if (!$row) {
	        throw new \Exception("Could not find row $id");
	    }
	    return $row;
	}

	/**
	 * Returns an array consisting of database rows where status = 1
	 * @return array $result 
	 */
	public function getRegisteredUsers()
	{
		$select = new Select();
		$where = new Where();
		$where->equalTo($this->_cols['status'], 1);
		$select->from($this->_usersTable->getTableName())->where($where)->order($this->_cols['email']);
		$result = $this->_usersTable->selectWith($select);
		return $result->toArray();
	}

	/**
	 * Returns an array consisting of database rows designed to be used with a form "select"
	 * @return array $result = array(email => real_name)
	 */
	public function getSelectUsers()
	{
		return $this->_usersTable->getSelectUsers();
	}

	/**
	 * Adds user to users table if user does not already exist
	 * If user exists, updates instead
	 * @param array $data = array('email' => xxx, 'status' => xxx, 'realName' => xxx, 'password' => xxx[, 'preferences' => array(xxx)])
	 * @return string $message
	 */
	public function addUser($data)
	{
		// check to make sure email field is set
		if (isset($data['email'])) {
			$message = $this->_usersTable->save($data);
		} else {
			$message = 'ERROR: No email address!';
		}
		return $message;
	}

	/**
	 * Deletes a user by email address
	 * @param string $email
	 * @return int rows affected
	 */
	public function deleteUserByEmail($email)
	{
		$delete = new Delete();
		$where = new Where();
		$where->equalTo($this->_cols['email'], $email);
		$delete->from($this->_usersTable->getTableName())->where($where);
		$result = $this->_usersTable->deleteWith($delete);
		return $result;
	}
}
