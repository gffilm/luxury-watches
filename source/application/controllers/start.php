<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles the base controller
 * @overview
 */
class Start extends Base_Controller {

	private $viewName = 'Start';

	private $requiresLogin = false;

	private $viewData = array('class' => 'Start');

	private $modelName = '';

	/**
	 * Constructor for the Start page
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
