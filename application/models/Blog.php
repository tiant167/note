<?php

class Application_Model_Blog extends Zend_Db_Table_Abstract
{
	protected $_name = "note_blog";
	
	/*
	 * 实现AES加密
	* $str : 要加密的字符串
	* $keys : 加密密钥
	* $iv : 加密向量
	* $cipher_alg : 加密方式
	*/
	private function ecryptdString($str,$keys,$iv="8105547186756005",$cipher_alg=MCRYPT_RIJNDAEL_128){
		$encrypted_string = bin2hex(mcrypt_encrypt($cipher_alg, $keys, $str, MCRYPT_MODE_CBC,$iv));
		return $encrypted_string;
	}
	/*
	 * 实现AES解密
	* $str : 要解密的字符串
	* $keys : 加密密钥
	* $iv : 加密向量
	* $cipher_alg : 加密方式
	*/
	private function decryptStrin($str,$keys,$iv="8105547186756005",$cipher_alg=MCRYPT_RIJNDAEL_128){
		$decrypted_string = mcrypt_decrypt($cipher_alg, $keys, pack("H*",$str),MCRYPT_MODE_CBC, $iv);
		return $decrypted_string;
	}
	
	public function createBlog($data){
		$User = new Application_Model_User();
		$password = $User->getMd5($data['userid']);
		
		$row = $this->createRow();
		if(count($data) > 0){
			foreach ($data as $key => $value){
				switch($key){
					case 'content':
						$row->$key = $this->ecryptdString($value,$password);
						break;
					default:
						$row->$key = $value;
				}
			}
			$row->save();
			return $row->blogid;
		}
		else
		{
			return null;
		}
	}
	
	public function getBlog($blogid,$userid){
		$select = $this->select();
		$select->where("blogid=?",$blogid);
		$result = $this->fetchRow($select);
		if($result){
			$User = new Application_Model_User();
			$password = $User->getMd5($userid);
			$result['content'] = $this->decryptStrin($result['content'],$password);
			return $result;
		}
		else{
			return false;
		}
	}
	
	public function updateBlog($blogid,$data){
		$row = $this->find($blogid)->current();
		$User = new Application_Model_User();
		$password = $User->getMd5($data['userid']);
		if($row){
			if(count($data)>0){
				foreach ($data as $key=>$value){
					switch($key){
						case 'content':
							$row->$key = $this->ecryptdString($value,$password);
							break;
						default:
							$row->$key = $value;
					}
					
				}
				$row->save();
				return $row->blogid;
			}
			else{
				return false;
			}
		
		}
	}
	
	public function blogidGetUserid($blogid){
		$select = $this->select();
		$select->where("blogid=?",$blogid);
		$result = $this->fetchRow($select);
		if($result){
			return $result->userid;
		}
		else{
			return false;
		}
	}
	
	public function getBlogList($userid){
		$select = $this->select();
		$select->where("userid=?",$userid);
		$select->from('note_blog',array('blogid','title'));
		$select->order('time DESC');
		$result = $this->fetchAll($select);
		if($result){
			return $result;
		}
		else{
			return false;
		}
	}
}

