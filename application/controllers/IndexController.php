<?php
require_once ('BaseController.php');
class IndexController extends BaseController
{
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $this->view->assign('username',$auth->getIdentity()->username);
    }
}

