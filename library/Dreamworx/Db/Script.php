<?php

class Dreamworx_Db_Script
{

    /**
     * Run a database script
     *
     * @static
     * @param $script String representation of the script
     * @param $dbAdapter Zend_Db_Adapter_Abstract to run the script against
     */
    static function run($script, Zend_Db_Adapter_Abstract $dbAdapter)
    {
        throw new Exception('Not yet implemented');
        // read the script untill the next ;

        // execute command

       return true;
    }

}