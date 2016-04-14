<?php
namespace Backend\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
class UserTable{
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway){
		$this->tableGateway=$tableGateway;
	}
	public function fetchAll(){
		return $this->tableGateway->select();
	}
	public function saveUser(User $user){
		$data=array(
			'username' => $user->username,
			'password'	=> $user->password,
			'level'		=> $user->level,
			'email' 	=> $user->email,
			);
		$this->tableGateway->insert($data);
	}
}
?>