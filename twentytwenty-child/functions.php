<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Defines
 */
define( 'PARENT_THEME_URI', get_template_directory_uri() );
define( 'CHILD_THEME_PATH', get_stylesheet_directory() );
define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'CHILD_ASSETS_JS', CHILD_THEME_URI . '/assets/js/' );
define( 'CHILD_ASSETS_CSS', CHILD_THEME_URI . '/assets/css/' );
define( 'THEME_VER', wp_get_theme()->get( 'Version' ) );

/**
 * Theme loader - initializes child theme
 */
require_once CHILD_THEME_PATH . '/classes/class-theme-loader.php';
