<?php

/**
 * This class handles the base model for crud application
 * @overview
 */
class Base extends CI_Model {


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

	/**
	 * Constructor for the Third Party entries
	 */
	public function __construct() {
		parent::__construct();

		$this->db = $this->load->database('appDb', true);
	}


	/**
	 * Gets the data model
	 * @return {Object}
	 */
	public function getDataModel() {
		return $this->dataModel;
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
	 * Gets a Third Party entry by the name
	 * @param {string} $id
	 * @return {Array[Objects]}
	 */
	public function getByName($name) {
		$recordSet = $this->db->get_where($this->tableName, array('name' => $name));

		if (!$recordSet) {
			return null;
		}
		$results = $recordSet->result();

		return $results;
	}

	/**
	 * Gets all the Third Party entries
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
	 * Deletes all Third Party entries
	 */
	public function deleteAll() {
		$entries = $this->getAllThirdPartyResults();
		foreach ($entries as $entry) {
			$this->db->where('id', $entry->id);
			$this->db->delete($this->tableName);
		}
	}

	/**
	 * Creates a Third Party entry
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
					$this->helper->addError('Update failed, this key does not exist in the database: ' . $key);
					break;
				}
				$updatedInfo[$key] = $value;
			}
			return $this->db->update($this->tableName, $updatedInfo);
		}
		return false;
	}


	/**
	 * Drops the Third Party table
	 */
	public function dropTable() {
		$sql = 'DROP TABLE IF EXISTS `' . $this->tableName . '`;';
		$this->db->query($sql);
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