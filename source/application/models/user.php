<?php

/**
 * This class handles the model for Feedback
 * @overview
 */
class User extends CI_Model {

    private $helper = null;

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
    * The roles allowed
    */
    private static $roles = array(0 => 'VIEWER', 1 => 'BUYER', 2 => 'DEVELOPER');

    /**
     * Constructor for the User entries
     * @param {array} dataModel
     */
    public function __construct() {
        parent::__construct();

        $this->db = $this->load->database('appDb', true);
    }


    /*
     * Gets the data model
     * @return {Array}
    */
    public function getDataModel() {
        return $this->dataModel;
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


    /*
     * Sets the data model
     * @param {Array} model
    */
    public function setDataModel($model) {
        $this->dataModel = $model;
    }



    /**
     * Gets a User entry by the ID
     * @param {string} $id
     * @return {Object}
     */
    public function getFromId($id) {
        if (!$this->exists($id)) {
            return null;
        }
        $recordSet = $this->db->get_where('tblUsers', array('id' => $id));

        if (!$recordSet) {
            return null;
        }
        $results = $recordSet->result();

        if ($results) {
            $results = $results[0];
        }

        return $results;
    }


    /**
     * Tests if an ID exists.
     * @param $id {!String>} $id
     * @return bool {Boolean}
     */
    private function exists($id) {
        $recordSet = $this->read($id);
        return isset($recordSet);
    }

    /**
     * Reads entries by id.
     * @param $id {!String} $id
     * @return null {?DBEntry}
     */
    public function read($id) {
        $this->db->limit(1);
        
        $recordSet = $this->db->get_where('tblUsers', array('id' => $id));

        $results = $recordSet->result();

        return $recordSet->num_rows ? $results[0] : null;
    }

    /**
     * Gets a User entry by the email address
     * @param {string} $id
     * @return {Array[Objects]}
     */
    public function getFromEmail($email) {
        $recordSet = $this->db->get_where('tblUsers', array('email' => $email));

        if (!$recordSet) {
            return null;
        }
        $results = $recordSet->result();

        return $results ? $results[0] : null;
    }

    /**
     * Gets a User entry by the email address
     * @param {string} $id
     * @return {Array[Objects]}
     */
    public function getFromEmailAndPassword($email, $password) {
        $password = md5($password);
        $recordSet = $this->db->get_where('tblUsers', array('email' => $email, 'password' => $password));

        if (!$recordSet) {
            return null;
        }
        $results = $recordSet->result();

        return $results ? $results[0] : null;
    }

    /**
     * Gets all the User entries
     * @return {Object} the entriees
     */
    public function getAllUserResults() {
        return $this->db->get('tblUsers')->result();
    }

    /**
     * Deletes a User entry with the ID
     * @param {string} $id
     * @return {boolean} result
     */
    public function deleteByID($id) {
        if ($this->exists($id)) {
            $this->db->where('id', $id);
            $result = $this->db->delete('tblUsers');
        } else {
            $result = false;
        }


        return $result;
    }

    /**
     * Deletes a User entry with the ID
     * @param {string} $id
     */
    public function deleteByCourseID($id) {
        $this->db->where('courseId', $id);
        $this->db->delete('tblUsers');
    }


    /**
     * Deletes all User entries
     */
    public function deleteAll() {
        $entries = $this->getAllUserResults();
        foreach ($entries as $entry) {
            $this->db->where('id', $entry->id);
            $this->db->delete('tblUsers');
        }
    }

    /**
     * Creates a User entry
     * @param {Array} $data
     * @return {string} $id
     */
    public function create($data) {
        $id = md5(microtime());
        $columns = $this->dataModel;
        $valid = true;
        // Set active to true if using a local database
        $active = ENVIRONMENT === 'localDatabase';
        $role = 'VIEWER';

        // Set the first entry as a developer and as active regardless
        $entries = $this->getAllUserResults();
        if (empty($entries)) {
            $active = true;
            $role = 'DEVELOPER';
        }

        $createdInfo = array();
        $createdInfo['id'] = $id;
        $createdInfo['creationDate'] = date(DBTIMEFORMAT, now());
        $createdInfo['createdBy'] = USERNAME;
        $createdInfo['active'] = $active;
        $createdInfo['role'] = $this->getRole($role);

        // If the data contains information not present in the table it will throw an error
        foreach ($data as $key => $value) {
            if (!isset($columns[$key])) {
                var_dump('Create failed, the key does not exist in the database: ' . $key);
                $valid = false;
                break;
            }
            $createdInfo[$key] = $value;
        }

        $createdInfo['password'] = md5($data['password']);

        // Verify all required items are being submitted
        foreach ($columns as $key => $value) {
            if ($value['required']) {
                if (!isset($createdInfo[$key])) {
                    var_dump('This key is required to create a new user: ' . $key);
                    $valid = false;
                    break;
                }
            }
        }

        // If the data is valid, then insert it and return the id
        if ($valid) {
            $success = $this->db->insert('tblUsers', $createdInfo);
            if ($success) {
                return $id; 
            }
        }

        return null;
    }


    /**
     * Updates an entry.
     * @param $id {!String} $id
     * @param {!Array<String, String>} $data
     * @return {booolean} did it update?
     */
    public function update($id, $data) {
        if($this->exists($id)) {
            $this->db->where('id', $id);
            $addresses = null;

            $updatedInfo = array();
            $updatedInfo['modificationDate'] = date(DBTIMEFORMAT, now());
            $updatedInfo['modifiedBy'] = USERNAME;
            $updatedInfo['id'] = $id;

            // Update all the information provided in the data
            // If the data contains information not present in the table it will throw an error
            $columns = $this->dataModel;
            foreach ($data as $key => $value) {
                if (!isset($this->dataModel[$key])) {
                    var_dump('Update failed, this key does not exist in the database: ' . $key);
                    return false;
                }
                $updatedInfo[$key] = $value;
            }

            return $this->db->update('tblUsers', $updatedInfo);
        }
        return false;
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

            return $this->db->update('tblUsers', $updatedInfo);
        }
        return false;
    }


    /**
     * Activates an entry.
     * @param $id {!String} $id
     * @return {booolean} did it update?
     */
    public function activate($id) {
        if($this->exists($id)) {
            $this->db->where('id', $id);
            $updatedInfo = array();
            $updatedInfo['active'] = 1;
            return $this->db->update('tblUsers', $updatedInfo);
        }
        return false;
    }


    /**
     * Drops the User table
     */
    public function dropTable() {
        $sql = 'DROP TABLE IF EXISTS `tblUsers`;';
        $this->db->query($sql);
    }

    /**
     * Creates the User table
     */
    public function createTable() {
        $sql = 'CREATE TABLE IF NOT EXISTS `tblUsers` (
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
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $this->db->query($sql);
    }
}

?>