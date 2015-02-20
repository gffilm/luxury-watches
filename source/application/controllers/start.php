<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles the base controller
 * @overview
 */
class Start extends Base_Controller {

	private $viewName = 'start';

	private $requiresLogin = true;

	private $viewData = array('test' => 'meow', 'test1' => 'ruff');

	private $modelName = 'Watches';

	/**
	 * Constructor for the Start page
	 */
	public function __construct() {
		$this->setModelName($this->modelName);
		$this->setViewName($this->viewName);
		$this->setRequiresLogin($this->requiresLogin);
		parent::__construct();
	}

	/**
	 * Starting point for the overall application.
	 */
	public function index() {
		$this->load->view($this->viewName, $this->viewData);
	}
}
