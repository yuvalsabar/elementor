<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rest API Class
 */
abstract class Rest_Api_Base {
	public $namespace = 'ys/v1';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add actions for Rest API
	 */
	public function add_actions() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register Rest API Routes
	 */
	public function register_routes() {
		// This method is reserved in case of extand
	}
}
