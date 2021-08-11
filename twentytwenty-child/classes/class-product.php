<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product class
 */
class Product {
	/**
	 * Product ID.
	 *
	 * Holds the product ID.
	 *
	 * @access public
	 *
	 * @var int
	 */
	public $id;

	/**
	 * Constructor
	 *
	 * @param int $name
	 */
	public function __construct( int $id = 0 ) {
		$this->id = ! empty( $id ) ? $id : get_the_ID();
	}

	/**
	 * Get product ID
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get product title
	 *
	 * @return string
	 */
	public function get_title() {
		return get_the_title( $this->id );
	}

	/**
	 * Get product description
	 *
	 * @return string
	 */
	public function get_description() {
		return get_post_meta( $this->id, 'description', true );
	}

	/**
	 * Get product product price
	 *
	 * @return string
	 */
	public function get_price() {
		return get_post_meta( $this->id, 'price', true );
	}

	/**
	 * Get product sale price
	 *
	 * @return string
	 */
	public function get_sale_price() {
		return get_post_meta( $this->id, 'sale_price', true );
	}

	/**
	 * Check if product is on sale
	 *
	 * @return boolean
	 */
	public function is_on_sale() {
		return get_post_meta( $this->id, 'on_sale', true );
	}

	/**
	 * Get product video URL
	 *
	 * @return string
	 */
	public function get_video_url() {
		return get_post_meta( $this->id, 'video_url', true );
	}

	/**
	 * Get Image attachment ID
	 *
	 * @return int
	 */
	public function get_image_id() {
		return get_post_thumbnail_id( $this->ID );
	}

	/**
	 * Get featured image URL
	 *
	 * @param string $size
	 */
	public function get_image_url( $size = 'full' ) {
		$attachment_id = $this->get_image_id();

		return wp_get_attachment_image_url( $attachment_id, $size );
	}
}

/**
 * Get product
 *
 * @param integer $id
 *
 * @return object Product
 */
function get_product( $id = 0 ) {
	return new Product( $id );
}
