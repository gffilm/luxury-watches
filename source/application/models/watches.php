<?php

/**
 * This class handles the base model for crud application
 * @overview
 */
class Watches extends Base {


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


    /**
     * Creates the Third Party table
     */
    public function createTable() {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->tableName . '` (
                    `id` varchar(128) NOT NULL,
                    `creationDate` date DEFAULT NULL,
                    `modificationDate` date DEFAULT NULL,
                    `createdBy` varchar(128) DEFAULT NULL,
                    `modifiedBy` varchar(128) DEFAULT NULL,
                    `name` varchar(30) NOT NULL,
                    `info` text
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $this->db->query($sql);
    }
}

?>