<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/base' . EXT);

/**
 * This class handles user access to the application
 * @overview
 */
class Watch extends Base_Controller {


    private $viewName = 'Watch';

    private $requiresLogin = false;

    private $viewData = array('watches' => null);

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

    /**
     * Get all original non-archived watches by brand
     */
    public function inventory() {
        $watches = $this->getModel()->getNonArchived();
        $brands = array();
        $differentWatches = array();

        // Look for only different brands
        foreach ($watches as $watch) {
            if (!in_array($watch->brand, $brands)) {
                array_push($brands, $watch->brand);
                array_push($differentWatches, $watch);
            }
        }

        // Compares the orddr for the usort
        function compare($a, $b) {
            return strcmp($a->brand, $b->brand);
        }
        
        usort($differentWatches, 'compare');

        $this->viewData['watches'] = $differentWatches;
        $this->index($this->viewData);
    }
}

