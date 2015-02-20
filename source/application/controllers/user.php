<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles user access to the application
 * @overview
 */
class User extends Base_Controller {


    private $viewName = 'User';

    private $requiresLogin = false;

    private $viewData = array('class' => 'User');

    private $modelName = 'User_Model';

    /**
     * Constructor for the User page
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

    /**
    * Determines if user is logged in
    * @return {boolean}
    */
    private function isLoggedIn() {
        $helper = $this->getuserHelper();
        return $helper->isLoggedIn();
    }
}

