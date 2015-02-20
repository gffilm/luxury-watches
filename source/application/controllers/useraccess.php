<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles user access to the application
 * @overview
 */
class UserAccess extends Base_Controller {

    /**
     * Constructor for the user access view
     * @constructor
     */
    public function __construct() {
        parent::__construct();
    }


    /**
    * Displays log in or redirects to the main page
    */
    public function index() {
        echo 'Login Page Goes Here';
    }
}

