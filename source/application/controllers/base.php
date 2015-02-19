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

	/**
	 * Constructor for the Base controller
	 */
	public function __construct() {
		parent::__construct();

		// Load Helpers
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('html');

		// Create an instance of the model
		$this->model = new $this->modelName();
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
}
