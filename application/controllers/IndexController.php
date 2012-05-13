<?php
require_once ('BaseController.php');
class IndexController extends BaseController
{
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $this->view->assign('username',$auth->getIdentity()->username);

        $sitesTable = new Application_Model_DbTable_WpSites();
        $sites = $sitesTable->fetchAll();
        foreach ($sites as $site) {
            $site = new Application_Model_WpSite($site);
        }

    }
}