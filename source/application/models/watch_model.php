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
    private $tableName = 'tblWatches';

    /*
     * The create table query
     * @type {string}
    */
    private $createTableQuery = 'CREATE TABLE IF NOT EXISTS `tblWatches` (
                `id` varchar(128) NOT NULL,
                `creationDate` date DEFAULT NULL,
                `watchName` date DEFAULT NULL,
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

    /**
     * Constructor for the Third Party entries
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Sets up values for inheritance
     * @param {Object} $data
     */
    public function inherit() {
        $inheriters = $this->getInheriters();
        foreach ($inheriters as $parameter) {
            $this->setInheritance($parameter, $this->$parameter);
        }
    }
}

?>