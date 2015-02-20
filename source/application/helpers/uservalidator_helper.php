<?php

class UserValidator {
    

    /**
     * All users
     * @var {Array}
     */
    private $users = array();

    /**
     * Current User
     * @var {object}
     */
    private $user = null;


    /**
     * The session data
     * @var {Array}
     */
    private $session = array();

    /**
     * The model
     * @var {Object}
     */
    private $model = null;

    /*
    * Set the developer to false by default
    * @var Boolean
    */
    private $developer = false;


    /*
    * Is the user logged in
    * @var Boolean
    */
    private $loggedIn = false;


    /*
     * Constructs the login helper
     * @param {Array} $session
    */
    public function __construct($session) {
        if (!$session || !@$session['id']) {
            $this->defineEmptyCredentials();
            return;
        }
        $this->session = $session;
        if ($this->validate()) {
            $this->defineCredentials();
        } else {
            $this->defineEmptyCredentials();
        }
    }

    /*
    * Validate user if they are not logged in
    * @return {boolean} is the user valid?
    */
    public function validate() {
        $this->id = $this->session['id'];
        $this->model = new UserModel();
        $this->user = $this->model->read($this->id);
        $this->loggedIn = $this->isActive();        
        return $this->loggedIn;
    }


    /*
    * Ensures the user is active
    */
    public function isActive() {
        return $this->user ? $this->user->active : false;
    }


    /*
     * Gets an error message
     * @return {string}
    */
    public function getError() {
        return $this->error;
    }


    /*
    * Determine if the user is logged in
    * @return {boolean} is the user logged in?
    */
    public function isLoggedIn() {
        return $this->loggedIn;
    }


    /**
     * Define empty credentials
     */
    private function defineEmptyCredentials() {
        if (!defined('DEVELOPER')) {
            define('DEVELOPER', false);
            define('PACKAGER', false);
            define('USERNAME', false);
            define('LOGGEDIN', false);
        }
    }

    /**
     * Define credentials
     * @param {Array} users 
     */
    private function defineCredentials() {
        $email = $this->user->email;
        $role = $this->user->role;
        $roles = UserConfig::getRoles();
        $developer = false;
        $packager = false;

        if ($roles[$role] == 'DEVELOPER')  {
            $developer = true;
            $packager = true;
        } else if ($roles[$role] == 'PACKAGER')  {
            $packager = true;
        }

        if (!defined('DEVELOPER')) {
            define('DEVELOPER', $developer);
            define('PACKAGER', $packager);
            define('USERNAME', $email);
            define('LOGGEDIN', true);
        }
    }
}

    

