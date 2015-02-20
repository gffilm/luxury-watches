<?php

/**
 * This class handles the model for Feedback
 * @overview
 */
class User_Model extends Base_Model {

    /*
    * The datamodel
    */
    private $dataModel = array(         
        'id' => array('required' => false, 'type' => 'auto'),
        'creationDate' => array('required' => false, 'type' => 'auto'),
        'modificationDate' => array('required' => false, 'type' => 'auto'),
        'createdBy' => array('required' => false, 'type' => 'auto'),
        'modifiedBy' => array('required' => false, 'type' => 'auto'),
        'firstName' => array('required' => true, 'type' => 'input'),
        'lastName' => array('required' => true, 'type' => 'input'),
        'password' => array('required' => true, 'type' => 'input'),
        'phone' => array('required' => false, 'type' => 'input'),
        'email' => array('required' => true, 'type' => 'input'),
        'active' => array('required' => false, 'type' => 'input'),
        'role' => array('required' => false, 'type' => 'auto'),
        'email' => array('required' => true, 'type' => 'input'));



    /*
     * The table name
     * @type {string}
    */
    private $tableName = 'tblUsers';


    /*
     * The create table query
     * @type {string}
    */
    private $createTableQuery = 'CREATE TABLE IF NOT EXISTS `tblUsers` (
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

    /*
    * The roles allowed
    */
    private static $roles = array(0 => 'VIEWER', 1 => 'BUYER', 2 => 'DEVELOPER');

    /**
     * Constructor for the User entries
     * @param {array} dataModel
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


    /*
    * Gets the roles available
    * @return {Array}
    */
    public function getRoles() {
        return self::$roles;
    }

    /*
    * Gets the role number based on a role name
    * @param {string}
    * @return {number}
    */
    public function getRole($roleName) {
        $roles = self::$roles;

        foreach ($roles as $key => $value) {
            if ($value === $roleName) {
                return $key;
            }
        }
        return null;
    }


    /**
     * Changes a password
     * @param $id {!String} $id
     * @param {!Array<String, String>} $data
     * @return {booolean} did it update?
     */
    public function changePassword($id, $data) {
        if($this->exists($id)) {
            $this->db->where('id', $id);
            $updatedInfo = array();
            $updatedInfo['modificationDate'] = date(DBTIMEFORMAT, now());
            $updatedInfo['modifiedBy'] = USERNAME;

            // Update all the information provided in the data
            // If the data contains information not present in the table it will throw an error
            $columns = $this->dataModel;
            foreach ($data as $key => $value) {
                //var_dump($this->dataModel[$key]);
                if (!isset($this->dataModel[$key])) {
                    var_dump('Update failed, this key does not exist in the database: ' . $key);
                    break;
                }
                $updatedInfo[$key] = $value;
            }

            $updatedInfo['password'] = md5($data['password']);

            return $this->db->update($this->tableName, $updatedInfo);
        }
        return false;
    }


    /**
     * Activates an entry.
     * @param $id {!String} $id
     * @return {booolean} did it update?
     */
    public function activateUser($id) {
        if($this->exists($id)) {
            $this->db->where('id', $id);
            $updatedInfo = array();
            $updatedInfo['active'] = 1;
            return $this->db->update($this->tableName, $updatedInfo);
        }
        return false;
    }
}

?>