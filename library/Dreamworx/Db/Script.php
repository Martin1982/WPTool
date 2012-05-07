<?php

class Dreamworx_Db_Script
{

    /**
     * Run a database script
     * @todo make a check that the ; is not within a string
     * @todo ignore comments in queries
     *
     * @static
     * @param $script String representation of the script
     * @param $dbAdapter Zend_Db_Adapter_Abstract to run the script against
     */
    static function run($script, Zend_Db_Adapter_Abstract $dbAdapter)
    {
        $queries = explode(';', $script);

        $dbAdapter->query("BEGIN TRANSACTION;");

        // execute commands
        foreach ($queries as $query) {
            try {
                $dbAdapter->query($query);
            } catch (Exception $e) {
                $dbAdapter->query("ROLLBACK TRANSACTION;");
                throw new Exception($e->getMessage() . "Transaction rolled back at: $query.");
            }
        }

        $dbAdapter->query("COMMIT");

       return true;
    }

}