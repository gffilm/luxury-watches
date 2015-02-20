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
	private $viewName = 'Base';

	/**
	 * The name of the model to load
	 * @type {string}
	 */
	private $modelName = 'Base_Model';

	/*
	 * The uservalidator
	 * @type {object}
	*/
	private $userValidator = null;


	/**
	 * Do we require a login to view this page?
	 * @type {boolean}
	 */
	private $requiresLogin = false;


	/**
	 * Sets the functions and parametes for inherited values
	 * @type {boolean}
	 */
	private static $inheriters = array('viewName', 'modelName', 'requiresLogin');

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
		$this->model = new $this->modelName();
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
	 * Ensure user is logged in or redirect to the login page if required
	 */
	public function login() {
		$this->userValidator = new User_Helper($this->session->all_userdata());

		if ($this->requiresLogin && !$this->userValidator->isLoggedIn()) {
			redirect('useraccess?return=' . current_url());
		}
	}

	/**
	 * Starting point for the overall application.
	 */
	public function index() {
		$this->load->view($this->viewName, $this->viewData);
	}
}
