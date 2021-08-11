<?php $product = get_product(); ?>

<div class="product">
	<div class="product__in">
		<a href="<?php the_permalink(); ?>">
			<figure class="product__image">
				<?php echo wp_get_attachment_image( $product->get_image_id(), 'medium' ); ?>
			</figure>

			<h3 class="product__title">
				<?php echo esc_html( $product->get_title() ); ?>
			</h3>

			<div class="product__description">
				<?php echo esc_html( $product->get_description() ); ?>
			</div>

			<?php if ( $product->is_on_sale() ) : ?>

				<div class="on-sale">
					<?php esc_html_e( 'On Sale', 'twentytwentychild' ); ?>
				</div>

			<?php endif; ?>
		</a>
	</div>
</div>
