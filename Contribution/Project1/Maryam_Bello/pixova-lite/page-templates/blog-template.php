<?php ;/* Template Name: Blog Template */ ?>

<?php get_header(); ?>

<div class="container">
	<div class="row">
		<section class="has-padding">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<?php
					$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$query_args = array(
						'post_type' => 'post',
						'showposts' => get_option( 'posts_per_page' ),
						'paged'     => $paged,
					);
					$wp_query   = new WP_Query( $query_args );

					if ( $wp_query->have_posts() ) :
						while ( $wp_query->have_posts() ) :
							$wp_query->the_post();
							get_template_part( 'template-parts/content', get_post_format() );
						endwhile;
					endif;
					wp_reset_postdata();
					?>
				</div><!--/.col-lg-8-->

				<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs pull-right">
					<div class="pixova-blog-sidebar">
						<?php
						if ( is_active_sidebar( 'blog-sidebar' ) ) {
							dynamic_sidebar( 'blog-sidebar' );
						} else {
							the_widget( 'WP_Widget_Search', sprintf( 'title=%s', __( 'Search', 'pixova-lite' ) ) );
							the_widget( 'WP_Widget_Calendar', sprintf( 'title=%s', __( 'Calendar', 'pixova-lite' ) ) );
						}
						?>
					</div> <!--/.pixova-blog-sidebar-->
				</div><!--/.col-lg-3-->

				<div class="pixova-custom-pagination col-lg-12">
					<?php the_posts_pagination(); ?>
				</div><!--/.pixova-custom-pagination-->

		</section><!--/section-->
	</div><!--/.row-->
</div><!--/.container-->
<?php get_footer(); ?>
