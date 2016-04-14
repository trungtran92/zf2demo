<?php
namespace Backend\Model;
class User{
	public $id;
	public $username;
	public $password;
	public $email;
	public $level;
	public $name;
	public function exchangeArray($data){
		if(isset($data['id'])){
			$this->id=$data['id'];
		}
		if(isset($data['username'])){
			$this->username=$data['username'];
		}
		if(isset($data['email'])){
			$this->email=$data['email'];
		}
		if(isset($data['level'])){
			$this->level=$data['level'];
		}
		if(isset($data['name'])){
			$this->name=$data['name'];
		}
		if(isset($data['password'])){
			$this->setPassword($data['password']);
		}
	}
	public function setPassword($pass){
		$this->password=md5($pass);
	}
}
?>