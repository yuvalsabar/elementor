<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme loader class
 */
class Theme_Loader {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->load_classes();
		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * Load all theme classes
	 */
	public function load_classes() {
		$classes_map = [
			'/classes/class-metabox.php',
			'/classes/class-product-handler.php',
			'/classes/class-product.php',
			'/classes/class-shortcodes.php',
		];
		foreach ( $classes_map as $class ) {
			require CHILD_THEME_PATH . $class;
		}
	}

	/**
	 * Add actions
	 */
	public function add_actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ], 100 );
		add_action( 'init', [ 'Shortcodes', 'init' ] );
		add_action( 'wp_head', [ $this, 'mobile_address_bar_color' ] );
	}

	/**
	 * Add filters
	 */
	public function add_filters() {
		add_filter( 'product_box_shortcode_filter', [ $this, 'filter_product_box_shortcode' ], 10, 2 );
		add_filter( 'show_admin_bar', [ $this, 'remove_user_admin_bar' ] );
	}

	/**
	 * Enqueue styles on front-end
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'parent-style', PARENT_THEME_URI . '/style.css', null, THEME_VER );
	}

	/**
	 * Enqueue scripts on the admin dashboard
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'meta-boxes', CHILD_ASSETS_JS . 'meta-boxes.js', [], THEME_VER, true );
	}

	/**
	 * Enqueue styles on the admin dashboard
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( 'admin-style', CHILD_ASSETS_CSS . 'admin.css', [], THEME_VER );
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

	/**
	 * Change mobile address bar color
	 */
	public function mobile_address_bar_color() {
		echo '<meta name="theme-color" content="#007bff" />';
	}

	/**
	 * Filter producr box shortcode (for this example, I will override post id of number 41)
	 *
	 * @param string $shortcode Shortcode tag
	 * @param array $atts Shortcode attributes
	 * @return void
	 */
	public function filter_product_box_shortcode( $shortcode, $atts ) {
		if ( 41 === (int) $atts['product_id'] ) {
			$shortcode = "Product ID is {$atts['product_id']}";
		}

		return $shortcode;
	}

}

new Theme_Loader();
