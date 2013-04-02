<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$auth = Zend_Auth::getInstance();
    	if($auth->hasIdentity()){
    		$this->identity = $auth->getIdentity();
    	}
    }

    public function indexAction()
    {
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
        // action body
        $this->view->username = $this->identity->username;
        //echo $this->identity->username;
        
        //获取最新的note列表
        $Blog = new Application_Model_Blog();
        $result = $Blog->getNewBlogList($this->identity->id);
        //var_dump($result);
        if($result->count()){
        	$this->view->flag = true;
	        $this->view->bloglist = $result;
	        
	        //var_dump($result[0]['blogid']);
	        //获取最新的note文章
	        $newBlog = $Blog->getBlog($result[0]['blogid'], $this->identity->id);
	        $this->view->newblog = $newBlog;
        }
        else{
        	$this->view->flag = false;
        	
        }
    }

    public function listAction()
    {
    	// action body
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
    	
    	$this->view->username = $this->identity->username;
    	$Blog = new Application_Model_Blog();
    	$result = $Blog->getBlogList($this->identity->id);
    	//var_dump($result);
    	$this->view->bloglist = $result;
    }

    public function editAction()
    {
        // action body  创建博客
        
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
    	
    	$this->view->username = $this->identity->username;
    	$this->view->flag = false;
    	$blogid = $this->_request->getParam('blogid');
    	if($blogid){
    		$Blog = new Application_Model_Blog();
    		$result = $Blog->getBlog($blogid, $this->identity->id);
    		$this->view->blogid = $blogid;
    		$this->view->flag = true;
    		$this->view->title = $result['title'];
    		$this->view->content = $result['content'];
    		
    	}
    	
    }

    public function submitHandelAction()
    {
        // action body
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
    	
    	$data['title'] = htmlspecialchars($this->_request->getPost('title'));//特殊字符处理
    	$data['content'] = htmlspecialchars($this->_request->getPost('content'));
    	$data['userid'] = $this->identity->id;
    	
    	$Blog = new Application_Model_Blog();
    	$result = $Blog->createBlog($data);
    	if($result != null){
    		return $this->_redirect('/user/');
    	}
    	else{
    		echo "出错啦！！！！！！！！";
    	}
    }

    public function viewBlogAction()
    {
        // action body
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
    	$this->view->username = $this->identity->username;
    	$blogid = $this->_request->getParam('blogid');
    	
    	$Blog = new Application_Model_Blog();
    	$currentBlog = $Blog->getBlog($blogid,$this->identity->id);
    	
    	if($currentBlog && $currentBlog['userid']==$this->identity->id){
    		$this->view->title = $currentBlog['title'];
    		$this->view->time = $currentBlog['time'];
    		$this->view->content = $currentBlog['content'];
    		$this->view->blogid = $blogid;
    	}else{
    		return $this->_redirect('/user/list');
    	}
    }

    public function updateBlogAction()
    {
        // action body
        
    	//好累，打不动了
    	//我是快乐的程序员
    	
    	//判断是否登录
    	if(!$this->identity->id){
    		return $this->_redirect('/');
    	}
    	
    	$Blog = new Application_Model_Blog();
    	$blogid = $this->_request->getParam('blogid');
    	//要判断这个作者和这篇文章是不是一个人哦
    	if($this->identity->id == $Blog->blogidGetUserid($blogid)){
    	
	    	$data['title'] = htmlspecialchars($this->_request->getPost('title'));
	    	$data['content'] = htmlspecialchars($this->_request->getPost('content'));
	    	$data['userid'] = $this->identity->id;
	    	$data['time'] = date("Y-m-d H:i:s",time());;
	    	
	    	$currentBlog = $Blog->updateBlog($blogid, $data);
	    	if($currentBlog){
	    		return $this->_redirect('/user/view-blog/blogid/'.$currentBlog);
	    	}
	    	else{
	    		return false;
	    	}
    	}
    }


}











