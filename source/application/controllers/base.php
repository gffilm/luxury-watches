<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class handles the base controller
 * @overview
 */
class Base_Controller extends CI_Controller {
	
	/**
	 * The data to povide the view
	 * @type {Array}
	 */
	private $viewData = array();

	/**
	 * The name of the view to load
	 * @type {string}
	 */
	private $viewName = '';

	/**
	 * The name of the model to load
	 * @type {string}
	 */
	private $modelName = '';


	/**
	 * Do we require a login to view this page?
	 * @type {boolean}
	 */
	private $requiresLogin = false;


	/**
	 * Sets the parametes for inherited values
	 * @type {boolean}
	 */
	private static $inheriters = array('viewData', 'viewName', 'modelName', 'requiresLogin');

	/*
	 * The userHelper
	 * @type {object}
	*/
	private $userHelper = null;

	/**
	 * The model
	 * @type {Obbject}
	 */
	private $model = null;


	/**
	 * Constructor for the Base controller
	 */
	public function __construct() {
		parent::__construct();

		// Initializes inheritance for the extended controller
		$this->inherit();

		// Load required helpers and libraries
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('html');
		$this->load->library('session');

		// Set if the user is logged in
		$this->login();

		// Create an instance of the model
		if ($this->modelName) {
			$this->model = new $this->modelName();
		}
	}


	// --------------------------------------
	// The following code handles inheritance
	// --------------------------------------

	/**
	 * Initializes variables for inheritance
	 */
	public function inherit() {}

	/**
	 * Gets the inheriters needed for inheritance
	 * @return {Object}
	 */
	public function getInheriters() {
		return self::$inheriters;
	}

	/**
	 * Sets params from the extended class to this one
	 * @param {string} $name of the parameter
	 * @param {*} $value of the parameter
	 */
	public function setInheritance($name, $value) {
		$this->$name = $value;
	}


	// ----------------------------------------------
	// The following code handles getters and setters
	// ----------------------------------------------

	/*
	 * Gets the user helper
	 * @return {object} 
	*/
	public function getuserHelper() {
		return $this->userHelper;
	}


	/*
	 * Gets the model
	 * @return {object} 
	*/
	public function getModel() {
		return $this->model;
	}


	// -------------------------------------------------
	// The following code handles login and view access
	// -------------------------------------------------


	/**
	 * Ensure user is logged in or redirect to the login page if required
	 */
	public function login() {
		$this->userHelper = new User_Helper($this->session->all_userdata());
		if ($this->requiresLogin && !$this->userHelper->isLoggedIn()) {
			redirect('useraccess?return=' . current_url());
		}
	}

	/**
	 * Starting point for the overall application.
	 */
	public function index($viewData) {
		$this->load->view($this->viewName, $viewData);
	}


	// ----------------------------------------------
	// The following code is for DB Crud Application
	// ----------------------------------------------


	/**
	 * Creates the table for the given model
	 */
	public function createTable() {
		if ($this->model && $this->model->createTable()) {
			echo 'Created Table';	
		} else {
			echo 'Failed to Create Table';
		}
	}

	public function dropTable() {
		if ($this->model && $this->model->dropTable()) {
			echo 'Dropped Table';	
		} else {
			echo 'Failed to Drop Table';
		}
	}

	/**
	 * Gets all results from the model
	 * @return {Object} results
	 */
	public function getAll() {
		$results = null;
		if ($this->model && $results = $this->model->getAll()) {}
		return $results;
	}
}
