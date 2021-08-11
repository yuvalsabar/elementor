<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Rest API Class
 */
class Product_Rest_Api extends Rest_Api_Base {

	/**
	 * Add actions for Rest API
	 */
	public function register_routes() {
		$this->register_product_cat_route();
	}

	/**
	 * Register product_cat rest API route
	 */
	public function register_product_cat_route() {
		register_rest_route(
			$this->namespace,
			'/product_cat/(?P<id>\d+)',
			[
				'methods'  => WP_REST_SERVER::READABLE,
				'callback' => [ $this, 'product_cat_route_callback' ],
			]
		);
	}

	/**
	 * Product category route callback function
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return WP_REST_Response
	 */
	public function product_cat_route_callback( $request ) {
		$id = (int) $request['id'];

		$data = [];

		$args = [
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => [
				[
					'taxonomy' => 'product_cat',
					'terms'    => $id,
				],
			],
		];

		$query = new WP_Query( $args );

		while ( $query->have_posts() ) {
			$query->the_post();

			$product = get_product();

			$data[] = [
				'id'          => (int) $product->get_id(),
				'title'       => sanitize_text_field( $product->get_title() ),
				'description' => sanitize_text_field( $product->get_description() ),
				'image_url'   => esc_url_raw( $product->get_image_url() ),
				'price'       => (int) $product->get_price(),
				'is_on_sale'  => (bool) $product->is_on_sale(),
				'sale_price'  => (int) $product->get_sale_price(),
			];
		}

		wp_reset_postdata();

		return rest_ensure_response( $data );
	}
}
