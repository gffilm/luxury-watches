<?php

/**
 * This class handles the base model for crud application
 * @overview
 */
class Base_Model extends CI_Model {

	/*
	 * The Data model
	 * @type {Array}
	*/
	private $dataModel = array();

	/*
	 * The table name
	 * @type {string}
	*/
	private $tableName = '';

    /*
     * The create table query
     * @type {string}
    */
    private $createTableQuery = '';

	/**
	 * Sets the parametes for inherited values
	 * @type {boolean}
	 */
	private static $inheriters = array('dataModel', 'tableName', 'createTableQuery');

	/**
	 * Constructor for the entries
	 */
	public function __construct() {
		parent::__construct();

		// Initializes inheritance for the extended controller
		$this->inherit();

		// Load the Database
		$this->db = $this->load->database('appDb', true);
	}


	/**
	 * Gets the inheriters needed for inheritance
	 * @return {Object}
	 */
	public function getInheriters() {
		return self::$inheriters;
	}

	/**
	 * Initializes variables for inheritance
	 */
	public function inherit() {}


	/**
	 * Sets params from the extended class to this one
	 * @param {string} $name of the parameter
	 * @param {*} $value of the parameter
	 */
	public function setInheritance($name, $value) {
		$this->$name = $value;
	}

	/**
	 * Gets the data model
	 * @return {Object}
	 */
	public function getDataModel() {
		return $this->dataModel;
	}

	/**
	 * Sets the data model
	 * @param {Object}
	 */
	public function setDataModel($model) {
		$this->dataModel = $model;
	}

	/**
	 * Determines if an ID exists.
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
	public function getById($id) {
		$this->db->limit(1);
		
		$recordSet = $this->db->get_where($this->tableName, array('id' => $id));

		$results = $recordSet->result();

		return $recordSet->num_rows ? $results[0] : null;
	}

	/**
	 * Gets a entry by the name
	 * @param {string} $key
	 * @param {string} $value
	 * @return {Array[Objects]}
	 */
	public function getByKeyValue($key, $value) {
		$recordSet = $this->db->get_where($this->tableName, array($key => $value));

		if (!$recordSet) {
			return null;
		}
		$results = $recordSet->result();

		return $results;
	}

	/**
	 * Gets all the entries
	 * @return {Object} the entriees
	 */
	public function getAll() {
		return $this->db->get($this->tableName)->result();
	}


	/**
	 * Deletes an entry with the ID
	 * @param {string} $id
	 */
	public function deleteByID($id) {
		$this->db->where('courseId', $id);
		$this->db->delete($this->tableName);
	}


	/**
	 * Deletes all entries
	 */
	public function deleteAll() {
		$entries = $this->getAll();
		foreach ($entries as $entry) {
			$this->db->where('id', $entry->id);
			$this->db->delete($this->tableName);
		}
	}

	/**
	 * Creates a entry
	 * @param {Array} $data
	 * @return {string} $id
	 */
	public function create($data) {
		$id = md5(microtime());
		$columns = $this->dataModel;
		$valid = true;

		$createdInfo = array();
		$createdInfo['id'] = $id;
		$createdInfo['createdBy'] = USERNAME;
		$createdInfo['creationDate'] = date(DBTIMEFORMAT, now());

		// If the data contains information not present in the table it will throw an error
		foreach ($data as $key => $value) {
			if (!isset($columns[$key])) {
				$this->addError('Create failed, the key does not exist in the database: ' . $key);
				$valid = false;
				break;
			}
			$createdInfo[$key] = $value;
		}

		// Verify all required items are being submitted
		foreach ($columns as $key => $value) {
			if ($value['required']) {
				if (!isset($createdInfo[$key])) {
					$this->addError('This key is required to create a new profile: ' . $key);
					$valid = false;
					break;
				}
			}
		}

		// If the data is valid, then insert it and return the id
		if ($valid) {
			$success = $this->db->insert($this->tableName, $createdInfo);
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
			$updatedInfo = array();
			$updatedInfo['modificationDate'] = date(DBTIMEFORMAT, now());
			$updatedInfo['modifiedBy'] = USERNAME;
			unset($data['creationDate']);
			unset($data['createdBy']);
			unset($data['id']);

			// Update all the information provided in the data
			// If the data contains information not present in the table it will throw an error
			$columns = $this->dataModel;
			foreach ($data as $key => $value) {
				//var_dump($this->dataModel[$key]);
				if (!isset($this->dataModel[$key])) {
					$this->addError('Update failed, this key does not exist in the database: ' . $key);
					break;
				}
				$updatedInfo[$key] = $value;
			}
			return $this->db->update($this->tableName, $updatedInfo);
		}
		return false;
	}


	/**
	 * Drops the table
	 * @param {boolean} success?
	 */
	public function dropTable() {
		$sql = 'DROP TABLE IF EXISTS `' . $this->tableName . '`;';
		return $this->db->query($sql);
	}


	/**
	 * Creates the table
	 * @param {boolean} success?
	 */
	public function createTable() {
		return $this->db->query($this->createTableQuery);
	}

	/**
	 * Test
	 */
	public function test() {
		echo $this->tableName;
	}
}

?>