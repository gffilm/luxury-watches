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
	private $viewName = 'base';

	/**
	 * The name of the model to load
	 * @type {string}
	 */
	private $modelName = 'Base';

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
	 * Constructor for the Base controller
	 */
	public function __construct() {
		parent::__construct();

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
	 * Ensure user is logged in or redirect to the login page if required
	 */
	public function login() {
		$this->userValidator = new UserValidator($this->session->all_userdata());

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

	/**
	 * Sets the modelname
	 * @param {string}
	 */
	public function setModelName($name) {
		$this->modelName = $name;
	}

	/**
	 * Sets the modelname
	 * @param {string}
	 */
	public function setViewName($name) {
		$this->viewName = $name;
	}

	/**
	 * Set if we this page requires a login
	 * @param {boolean}
	 */
	public function setRequiresLogin($required) {
		$this->requiresLogin = $required;
	}
}
