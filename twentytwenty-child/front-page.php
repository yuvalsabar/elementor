<?php get_header(); ?>

<div class="container">
	<?php
	get_template_part( 'partials/products' );
	echo do_shortcode( '[product_box product_id="51" bg_color="#fff"]' );
	?>
</div>

<?php
get_footer();
