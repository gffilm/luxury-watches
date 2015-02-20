<?php

/**
 * This class handles the base model for crud application
 * @overview
 */
class Watch_Model extends Base_Model {


    /*
     * The Data model
     * @type {Array}
    */
    private $dataModel = array();

    /*
     * The table name
     * @type {string}
    */
    private $tableName = 'watches';

    /**
     * Constructor for the Third Party entries
     */
    public function __construct() {
        parent::__construct();
    }

    /*
     * Gets the table query
    */
    private function getTableQuery() {
        return 'CREATE TABLE IF NOT EXISTS `' . $this->tableName . '` (
                `id` varchar(128) NOT NULL,
                `creationDate` date DEFAULT NULL,
                `modificationDate` date DEFAULT NULL,
                `createdBy` varchar(128) DEFAULT NULL,
                `modifiedBy` varchar(128) DEFAULT NULL,
                `firstName` varchar(30) NOT NULL,
                `lastName` varchar(30) NOT NULL,
                `password` varchar(128) DEFAULT NULL,
                `email` varchar(30) NOT NULL,
                `phone` varchar(50) DEFAULT NULL,
                `active` varchar(50) DEFAULT NULL,
                `role` varchar(50) DEFAULT NULL,
                `misc` text
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
    }
}

?>