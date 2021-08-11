<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Metabox class to generate metaboxes
 */
class Metabox {

	/**
	 * Field generator
	 *
	 * @param WP_POST $post
	 * @param array $fields
	 */
	public static function field_generator( $post, $fields ) {
		$output = '';

		foreach ( $fields as $field ) {
			$label      = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $field['id'], true );

			if ( empty( $meta_value ) ) {
				if ( isset( $field['default'] ) ) {
					$meta_value = $field['default'];
				}
			}

			switch ( $field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id=" %s" name="%s" type="checkbox" value="1">',
						'1' === $meta_value ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;

				case 'media':
					$meta_url = '';
					if ( $meta_value ) {
						if ( 'url' === $field['returnvalue'] ) {
							$meta_url = $meta_value;
						} else {
							$meta_url = wp_get_attachment_url( $meta_value );
						}
					}
					$input = sprintf(
						'<input style="display:none;" id="%s" name="%s" type="text" value="%s" data-return="%s"><div class="preview-image preview-%s" style="background-image:url(%s);"></div><input class="button new-media" id="%s_button" name="%s_button" type="button" value="Select" /><input class="button remove-media" id="%s_buttonremove" name="%s_buttonremove" type="button" value="Delete" />',
						$field['id'],
						$field['id'],
						$meta_value,
						$field['returnvalue'],
						$field['id'],
						$meta_url,
						$field['id'],
						$field['id'],
						$field['id'],
						$field['id']
					);
					break;

				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						'color' !== $field['type'] ? 'style="width: 100%"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$meta_value
					);
			}

			$output .= self::format_rows( $label, $input );
		}

		// phpcs:ignore
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Format fields rows
	 *
	 * @param string $label
	 * @param string $input
	 *
	 * @return string row HTML
	 */
	public static function format_rows( $label, $input ) {
		return '<div class="field-row"><div class="field-label"><strong>' . $label . '</strong></div><div class="field-input">' . $input . '</div></div>';
	}

	/**
	 * Save fields
	 *
	 * @param int $post_id
	 * @param array $fields
	 * @param string $fields_nonce
	 */
	public static function save_fields( $post_id, $fields, $fields_nonce ) {

		if ( ! isset( $_POST['meta_fields_nonce'] ) ) {
			return $post_id;
		}

		$nonce = sanitize_text_field( $_POST['meta_fields_nonce'] );

		if ( ! wp_verify_nonce( $nonce, $fields_nonce ) ) {
			return $post_id;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}

				update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
			} elseif ( 'checkbox' === $field['type'] ) {
				update_post_meta( $post_id, $field['id'], '0' );
			}
		}

	}

	/**
	 * Meta box callback
	 *
	 * @param WP_POST $post
	 * @param array $callback_args
	 */
	public static function meta_box_callback( $post, $callback_args ) {
		wp_nonce_field( "{$callback_args['id']}_nonce", 'meta_fields_nonce' );

		self::field_generator( $post, $callback_args['args']['fields'] );
	}

}

