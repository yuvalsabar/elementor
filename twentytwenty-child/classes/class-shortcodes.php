<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shortcodes class.
 */
class Shortcodes {

	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = [
			'product_box' => __CLASS__ . '::product_box',
		];

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( $shortcode, $function );
		}
	}

	/**
	 * Shortcode Wrapper.
	 *
	 * @param string   $shortcode Shortcode name.
	 * @param string   $function  Callback function.
	 * @param array    $atts      Attributes. Default to empty array.
	 * @param array    $wrapper   Customer wrapper data.
	 *
	 * @return string
	 */
	public static function shortcode_wrapper( $shortcode, $function, $atts = [], $wrapper = [
		'class'  => 'ys-widget',
		'before' => null,
		'after'  => null,
	] ) {
		ob_start();

		// phpcs:disable
		echo empty( $wrapper['before'] ) ? '<div class="' . esc_attr( $wrapper['class'] ) . '">' : $wrapper['before'];
		call_user_func( $function, $atts );
		echo empty( $wrapper['after'] ) ? '</div>' : $wrapper['after'];
		// phpcs:enable

		$shortcode = apply_filters( "{$shortcode}_shortcode_filter", ob_get_clean(), $atts );

		return $shortcode;
	}

	public static function print_product_box_template( $atts ) {
		$args = [
			'post_type' => 'product',
			'p'         => $atts['product_id'],
		];

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {

				$query->the_post();

				self::get_product_box_template( $atts );
			}

			wp_reset_postdata();

		}
	}

	/**
	 * Display a single product.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public static function product_box( $atts ) {
		return self::shortcode_wrapper( 'product_box', [ 'Shortcodes', 'print_product_box_template' ], $atts );
	}

	/**
	 * Get product box template
	 */
	public static function get_product_box_template( $atts ) {
		$product = get_product();

		$bg_color = isset( $atts['bg_color'] ) ? sanitize_text_field( $atts['bg_color'] ) : '#eee';

		ob_start();
		?>

		<div class="product" style="background-color:<?php echo esc_html( $bg_color ); ?>">
			<figure class="product__image">
				<?php echo wp_get_attachment_image( $product->get_image_id(), 'medium' ); ?>
			</figure>

			<h3 class="product__title">
				<?php echo esc_html( $product->get_title() ); ?>
			</h3>

			<div class="product__price">
				<?php
				/* translators: product price */
				echo sprintf( esc_html__( 'Price: %s$', 'ydtheme' ), esc_html( $product->get_price() ) );
				?>
			</div>
		</div>

		<?php

		// phpcs:ignore
		echo ob_get_clean();
	}

}

$shortcodes = new Shortcodes();
