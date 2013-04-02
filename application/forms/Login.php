<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	 
    	//用户名
    	$userName = $this->createElement('text', 'username');
    	$userName->setLabel('用户名：');
    	$userName->setAttribs(array('placeholder'=>'用户名','maxlength'=>'30','id'=>'id_username','class'=>'line'));
    	$userName->setRequired(true);
    	$userName->addValidator('stringLength',false,array(5,20));
    	$userName->addErrorMessage('用户名要求英文5-20个字母或2-6个汉字。');
    	$this->addElement($userName);
    	 
    	//密码
    	$password = $this->createElement('password', 'password');
    	$password->setLabel('密码：');
    	$password->setAttribs(array('placeholder'=>'请输入密码','id'=>'id_password','class'=>'line'));
    	$password->setRequired(true);
    	$password->addValidator('stringLength',false,array(6));
    	$password->addErrorMessage('密码至少有六个字符');
    	$this->addElement($password);
    	
    	//确认密码
    	$password2 = $this->createElement('password', 'password2');
    	$password2->setLabel('确认密码：');
    	$password2->setAttribs(array('placeholder'=>'请再次输入密码','id'=>'id_password2','class'=>'line'));
    	$password2->setRequired(TRUE);
    	$password2->addValidator('identical',false,array('token'=>'password'));//验证两次密码是否一样
    	$password2->addErrorMessage('两次输入的密码不相同');
    	$this->addElement($password2);
    	
    	//提交按钮
    	$submit = $this->createElement('submit', 'Login');
    	$submit->setAttribs(array('class'=>'btn'));
    	$this->addElement($submit);
    	
    	//注册
    	$regist = $this->createElement('button', 'Regist');
    	$regist->setAttribs(array('class'=>'btn'));

    	$this->addElement($regist);
    	
    	
    }


}

