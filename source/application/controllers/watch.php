<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles user access to the application
 * @overview
 */
class Watch extends Base_Controller {


    private $viewName = 'Watch';

    private $requiresLogin = false;

    private $viewData = array('class' => 'Watch');

    private $modelName = 'Watch_Model';


    /**
     * Constructor for the Watches page
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

