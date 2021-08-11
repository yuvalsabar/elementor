<div class="products">
	<?php
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => -1,
	);

	$query = new WP_Query( $args );

	while ( $query->have_posts() ) {
		$query->the_post();

		get_template_part( 'partials/loop', 'product' );
	}

	wp_reset_postdata();
	?>
</div>
