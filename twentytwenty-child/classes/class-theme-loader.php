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
		$this->add_filters();
	}

	/**
	 * Add actions
	 */
	public function add_actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	/**
	 * Add filters
	 */
	public function add_filters() {
		add_filter( 'show_admin_bar', [ $this, 'remove_user_admin_bar' ] );
	}

	/**
	 * Enqueue styles on front-end
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'parent-style', PARENT_THEME_URI . '/style.css', null, THEME_VER );
	}

	/**
	 * Remove admin bar
	 *
	 * @param boolean $show Whether to allow the admin bar to show.
	 *
	 * @return boolean
	 */
	public function remove_user_admin_bar( $show ) {
		if ( is_user_logged_in() ) {
			$user = wp_get_current_user();

			if ( 'wp-test' === $user->user_login ) {
				$show = false;
			}
		}

		return $show;
	}

}

new Theme_Loader();
