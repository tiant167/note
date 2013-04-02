<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{
	protected $_name = "note_user";
	
	public function createUser($userData){
		$row = $this->createRow();
		if(count($userData) > 0){
			foreach ($userData as $key => $value){
				switch($key){
					case 'password':
						$row->$key = md5($value);
						break;
					case 'Login':
					case 'password2':
						break;
					
					default:
						$row->$key = $value;
				}
			}
			
			$row->save();
			return $row->id;
		}
		else
		{
			return null;
		}
	}
	public function validUser($username){
		$select = $this->select();
		$select->where("username=?",$username);
		$result = $this->fetchRow($select);
		if($result->username == $username){
			return $result->id;
		}
		else{
			return false;
		}
	}
	
	public function getMd5($userid){
		$select = $this->select();
		$select->where("id=?",$userid);
		$result = $this->fetchRow($select);
		if($result){
			return $result->password;
		}
		else{
			return false;
		}
	}

}

