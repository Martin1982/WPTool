<?php
class Application_Model_WpSite
{

    protected $_siteInfo;
    protected $_isConnected = false;
    protected $_isAuthenticated = false;
    protected $_userObject;
    protected $_authError;

    /**
     * Setup the connected site and
     * do a handshake to confirm it is WPTool compatible
     * @param Zend_Db_Table_Row $site
     */
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

        $responseObj = Zend_Session::namespaceGet('wpsession');

        if ($responseObj) {
            $this->_isAuthenticated = true;
            $this->_userObject = $responseObj;
            return true;
        }

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

        $responseBody = $httpClient->getLastResponse()->getBody();
        $responseObj = json_decode($responseBody);

        if ($responseObj->authenticated === true) {
            $this->_isAuthenticated = true;
            $this->_userObject = $responseObj->response;
            $userSession = new Zend_Session_Namespace('wpsession');
            $userSession->userObject = $this->_userObject;
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
        $httpClient = new Zend_Http_Client($this->_siteInfo->url);
        $httpClient->setMethod(Zend_Http_Client::GET);

        $httpClient->setParameterGet(array(
            'wptoolaction' => 'getupdates'
        ));

        $httpRequest = $httpClient->request();
        if (!$httpRequest->isSuccessful()) {
            return false;
        }
        $responseObj = json_decode($httpClient->getLastResponse()->getBody());
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
}

