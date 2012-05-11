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

        $this->_redirect('/sites');
    }

    public function editAction()
    {
        $form = new Application_Form_AddSite();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $this->_editSite($request);
            }
        }

        $siteId = $this->_getSiteId($this->_request);
        $sitesTable = new Application_Model_DbTable_WpSites();

        $site = $sitesTable->fetchRow(array('id' => $siteId));
        $form->getElement('url')->setValue($site->url);
        $form->getElement('username')->setValue($site->username);
        $form->getElement('siteid')->setValue($site->id);

        $this->view->form = $form;
    }

    protected function _editSite(Zend_Controller_Request_Abstract $request)
    {
        $sitesTable = new Application_Model_DbTable_WpSites();
        $sitesTable->update(array(
            'url'       => $request->url,
            'username'  => $request->username,
            'password'  => $request->password
        ), array(
            'id = ?' => $this->_getSiteId($request)
        ));

        $this->_redirect('/sites');
    }

    public function deleteAction()
    {
        $siteId = $this->_getSiteId($this->_request);
        $sitesTable = new Application_Model_DbTable_WpSites();

        $sitesTable->delete(array('id = ?' => $siteId));
        $this->_redirect('/sites');
    }

    protected function _getSiteId(Zend_Controller_Request_Abstract $request)
    {
        $siteId = $request->getParam('siteid', false);

        if (!$siteId) {
            throw new Exception('No siteid given');
        }

        return (int) $siteId;
    }


}







