<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $Form = new Application_Form_Login();
        $Form->removeElement('password2');
        
        if ($this->getRequest()->isPost()){
        	if($Form->isValid($_POST)){
        		$data = $Form->getValues();
        		
        		//在这里对传过来的RSA加密过的密码进行解密
        		$txt_en = $data['password'];
        		$txt_en = base64_encode(pack("H*", $txt_en));
        		$file = 'ssl/server.key';
        		$txt_de = $this->privatekey_decodeing($txt_en, $file, TRUE);
        		//var_dump($txt_de);
        		
        		//取得默认数据库适配器
        		$db = Zend_Db_Table::getDefaultAdapter();
        		//实例化一个Auth适配器
        		$authAdapter = new Zend_Auth_Adapter_DbTable($db,'note_user','username','password');
        		//设置认证用户名和密码
        		$authAdapter->setIdentity($data['username']);
        		$authAdapter->setCredential(md5($txt_de)); //这里对密码进行md5加密！！！
        		//实现authenticate方法
        		$result = $authAdapter->authenticate();//执行认证
        		if($result->isValid()){
        			//获得getInstance实例
        			$auth = Zend_Auth::getInstance();
        			//存储用户信息
        			$storage = $auth->getStorage();//获得一个会话存储对象
        			$storage->write($authAdapter->getResultRowObject(array('id','username')));//write是写入storage，里面那个函数是取出id,username,role三个值
        			$id = $auth->getIdentity()->id;//获取用户id
        			
        			 
        			return $this->_redirect('/user/');
        			 
        		}
        		else{
        			$this->view->loginMessage = "对不起，用户名或密码错误";
        		}
        		
        	}
        }
        
        
        $this->view->form = $Form;
        
        
    }

    /**
     * 公钥加密
     *
     * @param string 明文
     * @param string 证书文件（.crt）
     * @return string 密文（base64编码）
     *
     */
    private function publickey_encodeing($sourcestr, $fileName)
    {
    	$key_content = file_get_contents($fileName);
    	$pubkeyid    = openssl_get_publickey($key_content);
    
    	if (openssl_public_encrypt($sourcestr, $crypttext, $pubkeyid))
    	{
    		return base64_encode("".$crypttext);
    	}
    }

    /**
     * 私钥解密
     *
     * @param string 密文（二进制格式且base64编码）
     * @param string 密钥文件（.pem / .key）
     * @param string 密文是否来源于JS的RSA加密
     * @return string 明文
     *
     */
    private function privatekey_decodeing($crypttext, $fileName, $fromjs = false)
    {
    	$key_content = file_get_contents($fileName);
    	$prikeyid    = openssl_get_privatekey($key_content);
    	$crypttext   = base64_decode($crypttext);
    	$padding = $fromjs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;
    	if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, $padding))
    	{
    		return $fromjs ? rtrim(strrev($sourcestr), "/0") : "".$sourcestr;
    	}
    	return ;
    }

    public function registAction()
    {
        // action body
        $Form = new Application_Form_Login();
        $Form->removeElement('Regist');
 		$Form->getElement('Login')->setLabel('Regist');
 		
 		if ($this->getRequest()->isPost()){
 			if($Form->isValid($_POST)){
 				$data = $Form->getValues();
 				$txt_en = $data['password'];
 				$txt_en = base64_encode(pack("H*", $txt_en));
 				$file = 'ssl/server.key';
 				$data['password'] = $this->privatekey_decodeing($txt_en, $file, TRUE);
 				
 				//实例化用户模型
 				$modelUser = new Application_Model_User();
 				$validUser = $modelUser->validUser($Form->getValue('username'));
 				if($validUser == false){
 					$newUser = $modelUser->createUser($data);
 					if($newUser){
 						$this->_redirect('/user/');
 						 
 					}
 				}
 				else{
 					$this->view->message = "对不起，已存在同名用户";
 				}
 			}
 		}
 		
        $this->view->form = $Form;
    }


}



