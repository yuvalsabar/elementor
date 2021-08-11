<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Proudct handler class
 */
class Product_Handler {
	/**
	 * Post Type
	 *
	 * Holds the name of the post type.
	 *
	 * @access public
	 *
	 * @var string
	 */
	private $post_type = 'product';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 */
	public function add_actions() {
		add_action( 'init', [ $this, 'register_product_post_type' ], 0 );
		add_action( 'init', [ $this, 'register_product_cat_taxonomy' ], 0 );
		add_action( 'add_meta_boxes', [ $this, 'add_product_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_fields' ] );
	}

	/**
	 * Register Product post type
	 */
	public function register_product_post_type() {
		$single_name = esc_html__( 'Product', 'twentytwentychild' );
		$plural_name = esc_html__( 'Products', 'twentytwentychild' );

		$args = [
			'label'         => $single_name,
			'description'   => $single_name,
			'labels'        => [
				'name'           => $plural_name,
				'singular_name'  => $single_name,
				'menu_name'      => $plural_name,
				'name_admin_bar' => $plural_name,
			],
			'supports'      => [ 'title', 'thumbnail' ],
			'menu_position' => 5,
			'show_ui'       => true,
			'menu_icon'     => 'dashicons-cart',
			'public'        => true,
		];

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register product_cat taxonomy
	 */
	public function register_product_cat_taxonomy() {
		$single_name = esc_html__( 'Product Category', 'twentytwentychild' );
		$plural_name = esc_html__( 'Product Categories', 'twentytwentychild' );

		$labels = [
			'name'          => $single_name,
			'singular_name' => $single_name,
			'menu_name'     => $plural_name,
		];
		$args   = [
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		];

		register_taxonomy( 'product_cat', [ $this->post_type ], $args );
	}

	public function add_product_meta_boxes() {
		add_meta_box(
			'product_settings',
			esc_html__( 'Product Settings', 'twentytwentychild' ),
			[ 'Metabox', 'meta_box_callback' ],
			$this->post_type,
			'normal',
			'default',
			[ 'fields' => $this->meta_fields() ]
		);
	}

	public function meta_fields() {
		$meta_fields = [
			[
				'label' => esc_html__( 'Description', 'twentytwentychild' ),
				'id'    => 'description',
				'type'  => 'text',
			],
			[
				'label' => esc_html__( 'Price', 'twentytwentychild' ),
				'id'    => 'price',
				'type'  => 'number',
			],
			[
				'label' => esc_html__( 'Sale Price', 'twentytwentychild' ),
				'id'    => 'sale_price',
				'type'  => 'number',
			],
			[
				'label' => esc_html__( 'On Sale', 'twentytwentychild' ),
				'id'    => 'on_sale',
				'type'  => 'checkbox',
			],
			[
				'label' => esc_html__( 'YouTube Video ID', 'twentytwentychild' ),
				'id'    => 'youtube_video_id',
				'type'  => 'text',
			],
		];

		for ( $i = 1; $i < 7; $i++ ) {
			$meta_fields[] = [
				// translators: image number
				'label'       => sprintf( esc_html__( 'Image %s', 'ystheme' ), $i ),
				'id'          => "image_{$i}",
				'type'        => 'media',
				'returnvalue' => 'id',
			];
		}

		return $meta_fields;
	}

	public function save_fields() {
		$metabox = new Metabox();

		$metabox->save_fields( get_the_ID(), $this->meta_fields(), "{$this->post_type}_settings_nonce" );
	}
}

new Product_Handler();
