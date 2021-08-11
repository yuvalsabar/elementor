<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme loader Class
 */
class Theme_Loader {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add actions
	 */
	public function add_actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Enqueue styles on front-end
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'parent-style', PARENT_THEME_URI . '/style.css', null, THEME_VER );
	}

}

new Theme_Loader();
