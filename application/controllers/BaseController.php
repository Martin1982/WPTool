<?php

class BaseController extends Zend_Controller_Action
{

    public function init()
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect('/login/');
        }
        $this->_postInit();
    }

    protected function _postInit()
    {

    }


}

