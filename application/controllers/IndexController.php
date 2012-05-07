<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect('/login/');
        }
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $this->view->assign('username',$auth->getIdentity()->username);
    }
}

