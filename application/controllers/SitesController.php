<?php
require_once ('BaseController.php');
class SitesController extends BaseController
{

    public function indexAction()
    {
        $sitesTable = new Application_Model_DbTable_WpSites();
        $sites = $sitesTable->fetchAll();
        $this->view->sites = $sites;
    }

    public function addAction()
    {
        $form = new Application_Form_AddSite();
        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $this->_saveSite($request);
            }
        }
        $this->view->form = $form;
    }

    protected function _saveSite(Zend_Controller_Request_Abstract $request)
    {
        $sitesTable = new Application_Model_DbTable_WpSites();
        $sitesTable->insert(array(
            'url'       => $request->url,
            'username'  => $request->username,
            'password'  => $request->password
        ));
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }


}







