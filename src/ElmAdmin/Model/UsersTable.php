<?php
namespace ElmAdmin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Where;

class UsersTable extends TableGateway
{
	protected $_email;
	protected $_status;
	protected $_realname;
	protected $_password;
	protected $_preferences;
	protected $_tableName = 'users';
	protected $_adapter;
	protected $_cols = array('email' => 'email', 
							 'status' => 'status', 
							 'realName' => 'real_name',
							 'password' => 'password',
							 'preferences' => 'preferences');
	
	public function __construct(Adapter $adapter = NULL)
	{
		$this->_adapter = $adapter;
		return parent::__construct($this->_tableName, $adapter);
	}

	/**
	 * Returns associative array of column names
	 * @return array $_cols
	 */
	public function getColumnNames()
	{
		return $this->_cols;
	}
	
	/**
	 * @return the $_tableName
	 */
	public function getTableName() {
		return $this->_tableName;
	}

	/**
	 * @return the $_email
	 */
	public function getEmail() {
		return $this->_email;
	}

	/**
	 * @return the $_status
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @return the $_realname
	 */
	public function getRealname() {
		return $this->_realname;
	}

	/**
	 * @return the $_password
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * @return string $_preferences
	 */
	public function getPreferences() {
		return $this->_preferences;
	}

	/**
	 * Set $_tableName for testing purposes
	 * @param string $tableName
	 */
	public function setTableName($tableName) {
		$this->_tableName = $tableName;
	}

	/**
	 * @param string $_email
	 */
	public function setEmail($_email) {
		$this->_email = $_email;
	}

	/**
	 * @param int $_status
	 */
	public function setStatus($_status = 0) {
		$this->_status = $_status;
	}

	/**
	 * @param string $_realname
	 */
	public function setRealname($_realname = 'Unknown') {
		$this->_realname = $_realname;
	}

	/**
	 * @param string $_password
	 */
	public function setPassword($_password = '') {
		$this->_password = $_password;
	}

	/**
	 * @param string $_preferences
	 */
	public function setPreferences($_preferences = '') {
		$this->_preferences = $_preferences;
	}

	public function getThisAsArray()
	{
		return array($this->_cols['email'] 		=> $this->getEmail(),
					 $this->_cols['status'] 	=> $this->getStatus(),
					 $this->_cols['realName'] 	=> $this->getRealname(),
					 $this->_cols['password']	=> $this->getPassword(),
					 $this->_cols['preferences']=> $this->getPreferences(),
		);
	}
	
	/**
	 * Adds user from current object properties or optional $details
	 * If user already exists, updates instead
	 * NOTE: preferences are optional; if present, should be in the form of an array
	 * @param array $data = array('email' => xxx, 'status' => xxx, 'realName' => xxx, 'password' => xxx[, 'preferences' => array(xxx)])
	 * @return string $message
	 */
	public function save($data)
	{
		$message = '';
		$this->setEmail($data['email']); 
		$this->setStatus($data['status']);
		$this->setRealName(isset($data['realName']) ? $data['realName'] : $data['real_name']);
		$this->setPassword(md5($data['password']));
		$this->setPreferences($data['preferences']);
		$result = $this->select(array($this->_cols['email'] => $data['email']));
		// check to see if $email already exists
		$row = $result->current(); 
		if ($row) {
			$where = new Where();
			$where->equalTo($this->_cols['email'], $data['email']);
			$update = new Update();
			$update->table($this->getTableName())
				   ->set($this->getThisAsArray())
				   ->where($where);
			// -- *** ZF2 TEAM: the following statement bombs out!!!
			$this->updateWith($update);
			$message = 'UPDATED: already existing user!';
		} else {
			$this->insert($this->getThisAsArray());
			$message = 'SUCCESS: User successfully added!';
		}
		return $message;
	}

	/**
	 * Fetches data based on Zend\Db\Sql\Select object
	 * If null, returns all data
	 * @param Zend\Db\Sql\Select $select
	 * @return array $result
	 */
	public function fetch(Select $select = NULL)
	{
		if ($select) {
			$result = $this->selectWith($select);
		} else {
			$result = $this->select();
		}
		return $result->toArray();
	}
	
	/**
	 * Returns an array consisting of database rows designed to be used with a form "select"
	 * Where 'status' = 1 (i.e. registered users)
	 * @return array $result = array(email => real_name)
	 */
	public function getSelectUsers()
	{
		$formSelect = array();
		$result = $this->select(array('status' => 1));
		$users = $result->toArray();
		foreach ($users as $row) {
			$formSelect[$row[$this->_cols['email']]] = $row[$this->_cols['realName']];
		}
		return $formSelect;
	}
	
}
