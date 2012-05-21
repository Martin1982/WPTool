<?php
class Application_Model_WpSite
{

    protected $_siteInfo;
    protected $_isConnected = false;
    protected $_isAuthenticated = false;
    protected $_userObject;
    protected $_authError;
    protected $_httpClient;

    /**
     * Setup the connected site and
     * do a handshake to confirm it is WPTool compatible
     * @param Zend_Db_Table_Row $site
     */
    public function __construct(Zend_Db_Table_Row $site)
    {
        $this->_siteInfo = $site;
        $this->_httpClient = new Zend_Http_Client($this->_siteInfo->url);
        $this->_httpClient->setCookieJar();
        $this->_httpClient->setMethod(Zend_Http_Client::GET);
        $this->handshake();
    }

    /**
     * Do the handshake to see if a connection can be made
     * @return bool
     */
    public function handshake()
    {
        $httpClient = $this->_httpClient;
        $httpClient->setParameterGet(array('wptoolaction' => 'handshake'));

        $httpRequest = $httpClient->request();
        if (!$httpRequest->isSuccessful()) {
            return false;
        }

        $responseContent = $this->_getJsonResponse();
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

        $httpClient = $this->_httpClient;
        $httpClient->setParameterGet(array(
            'username' => $username,
            'password' => $password,
            'wptoolaction' => 'login'
        ));

        $httpRequest = $httpClient->request();
        if (!$httpRequest->isSuccessful()) {
            return false;
        }

        $responseObj = $this->_getJsonResponse();
        if ($responseObj->authenticated === true) {
            $this->_isAuthenticated = true;
            $this->_userObject = $responseObj->response;
            return true;
        }

        $this->_authError = $responseObj->response;
        return false;
    }

    /**
     * Check the number of updates available for the site
     * @return string
     */
    public function getNumUpdates()
    {
        if (!$this->isConnected() || !$this->isAuthenticated()) {
            throw new Exception('No connection or authentication');
        }

        $httpClient = $this->_httpClient;
        $httpClient->setParameterGet(array(
            'wptoolaction' => 'getupdates'
        ));

        $httpRequest = $httpClient->request();
        if (!$httpRequest->isSuccessful()) {
            return false;
        }
        $responseObj = $this->_getJsonResponse();
        return $responseObj->counts->total;
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
        return $this->_isAuthenticated;
    }

    /**
     * Get the authentication error
     * @return string
     */
    public function getAuthError()
    {
        return $this->_authError;
    }

    /**
     * Get the json decoded response from a http request
     * @return mixed
     * @throws Exception
     */
    protected function _getJsonResponse()
    {
        $lastResponse = $this->_httpClient->getLastResponse();
        if (!$lastResponse) {
            throw new Exception('No response available');
        }
        return json_decode($lastResponse->getBody());
    }
}

