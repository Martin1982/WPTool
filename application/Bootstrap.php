<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_config;

    const APPLICATION_INI = '/configs/application.ini';
    const DB_SETUP_SCRIPT = '/../resources/database/setup_wptools_db.sql';

    /**
     * Save the configuration to the registry
     */
    protected function _initConfig()
    {
        $applicationRegistry = Zend_Registry::getInstance();
        $applicationConfig = new Zend_Config_Ini(APPLICATION_PATH . self::APPLICATION_INI);

        $this->_config = $applicationConfig;
        $applicationRegistry->set('Zend_Config', $applicationConfig);
    }

    /**
     * Initialize the database and check if it is installed
     */
    protected function _initDatabase()
    {
        $database = $this->getPluginResource('db')->init();
        $versionQuery = 'SELECT * FROM version';
        try {
            $tables = $database->fetchAll($versionQuery);
        } catch (Exception $e) {
            $installScript = file_get_contents(APPLICATION_PATH . self::DB_SETUP_SCRIPT);
            Dreamworx_Db_Script::run($installScript, $database);
            $tables = $database->fetchAll($versionQuery);
        }
    }

}