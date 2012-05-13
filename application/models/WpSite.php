<?php

class Application_Model_WpSite
{

    protected $_siteInfo;

    public function __construct(Zend_Db_Table_Row $site)
    {
        $this->_siteInfo = $site;
        $this->connect();
    }

    public function connect()
    {
        $httpClient = new Zend_Http_Client($this->_siteInfo->url);
        $httpClient->setMethod(Zend_Http_Client::GET);
        $httpClient->setParameterGet(array('wptoolaction' => 'version'));

        $httpRequest = $httpClient->request();
        if ($httpRequest->isSuccessful()) {
            $response = $httpClient->getLastResponse();
            Zend_Debug::dump($response->getBody());
        }
    }
}

