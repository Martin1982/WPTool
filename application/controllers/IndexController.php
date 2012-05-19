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
        $sitesInfo = array();
        foreach ($sites as $site) {
            $siteModel = new Application_Model_WpSite($site);
            if ($siteModel->isConnected()) {
                $siteModel->authenticate();
            }
            $sitesInfo[] = array(
                'url'               => $site->url,
                'isConnected'       => $siteModel->isConnected(),
                'isAuthenticated'   => $siteModel->isAuthenticated(),
                'numUpdates'        => $siteModel->getNumUpdates()
            );
        }

        $this->view->assign('sites', $sitesInfo);
    }
}