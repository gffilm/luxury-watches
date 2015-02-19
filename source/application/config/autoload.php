	<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
		/**
		 * AUTO-LOADER
		 * This file specifies which systems should be loaded by default.
		 *
		 * In order to keep the framework as light-weight as possible only the
		 * absolute minimal resources are loaded by default. For example,
		 * the database is not connected to automatically since no assumption
		 * is made regarding whether you intend to use it.  This file lets
		 * you globally define which systems you would like loaded with every
		 * request.
		 *
		 * -------------------------------------------------------------------
		 * Instructions
		 * -------------------------------------------------------------------
		 * These are the things you can load automatically:
		 * 1. Packages
		 * 2. Libraries
		 * 3. Helper files
		 * 4. Custom config files
		 * 5. Language files
		 * 6. Models
		 * -------------------------------------------------------------------
		 *
		 * @package autoload
		 */

		/**
		 * Example: <code>
		 *  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
		 * </code>
		 *
		 * @var array $autoload['packages']
		 */
		$autoload['packages'] = array();


		/**
		 * Auto-load Libraries
		 * -------------------------------------------------------------------
		 *
		 * These are the classes located in the system/libraries folder
		 * or in your application/libraries folder.
		 *
		 * $autoload['libraries'] = array('database', 'session', 'xmlrpc');
		 *
		 */
		$autoload['libraries'] = array(
				'database'
			);

		/**
		 * Auto-load Helper Files
		 * -------------------------------------------------------------------
		 *
		 * $autoload['helper'] = array('url', 'file');
		 */
		$autoload['helper'] = array(
			'watches'
		);


		/**
		 * Auto-load Models
		 * -------------------------------------------------------------------
		 * $autoload['model'] = array('model1', 'model2');
		 */
		$autoload['model'] = array(
			'base',
			'watches'
		);


		/**
		 * Auto-load Config Files
		 * -------------------------------------------------------------------
		 * NOTE: This item is intended for use ONLY if you have created custom
		 * config files.  Otherwise, leave it blank.
		 *
		 * $autoload['config'] = array('config1', 'config2');
		 */
		$autoload['config'] = array('');

		/**
		 * Auto-load Language files
		 * -------------------------------------------------------------------
		 * NOTE: Do not include the "_lang" part of your file.  For example
		 * "codeigniter_lang.php" would be referenced as array('codeigniter');
		 *
		 * $autoload['language'] = array('lang1', 'lang2');
		 */
		$autoload['language'] = array();


		/* End of file autoload.php */
		/* Location: ./application/config/autoload.php */