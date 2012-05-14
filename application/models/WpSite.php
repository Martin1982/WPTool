<?php
class Application_Model_WpSite
{

    protected $_siteInfo;
    protected $_isConnected = false;
    protected $_isAuthenticated = false;
    protected $_authToken;

    public function __construct(Zend_Db_Table_Row $site)
    {
        $this->_siteInfo = $site;
        $this->handshake();
    }

    /**
     * Do the handshake to see if a connection can be made
     * @return bool
     */
    public function handshake()
    {
        $httpClient = new Zend_Http_Client($this->_siteInfo->url);
        $httpClient->setMethod(Zend_Http_Client::GET);
        $httpClient->setParameterGet(array('wptoolaction' => 'handshake'));

        $httpRequest = $httpClient->request();

        if (!$httpRequest->isSuccessful()) {
            return false;
        }

        $response = $httpClient->getLastResponse();
        $responseContent = json_decode($response->getBody());
        if ($responseContent !== 'wptool present') {
            return false;
        }

        $this->_isConnected = true;
        return true;
    }

    /**
     * Authenticate to the website
     * @return bool
     */
    public function authenticate()
    {
        $username = $this->_siteInfo->username;
        $password = $this->_siteInfo->password;

        $httpClient = new Zend_Http_Client($this->_siteInfo->url);
        $httpClient->setMethod(Zend_Http_Client::GET);

        $httpClient->setParameterGet(array(
            'username' => $username,
            'password' => $password,
            'wptoolaction' => 'login'
        ));

        $httpRequest = $httpClient->request();
        if (!$httpRequest->isSuccessful()) {
            return false;
        }

        $response = $httpClient->getLastResponse();
        Zend_Debug::dump($response->getBody());
    }

    /**
     * Check if this instance is connected
     * @return bool
     */
    public function isConnected()
    {
        return $this->_isConnected;
    }

    /**
     * Check if this instance is authenticated
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->_isAuthenticated();
    }
}

