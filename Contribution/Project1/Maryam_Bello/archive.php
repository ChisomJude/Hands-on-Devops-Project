<?php get_header(); ?>

	<div class="container">
		<div class="row">

				<div class="has-padding">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<?php
						if ( have_posts() ) {

							while ( have_posts() ) {
								the_post();
								get_template_part( 'template-parts/content', get_post_format() );
							}
						}
						?>
					</div><!--/.col-lg-8-->

					<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs pull-right">
						<aside class="pixova-blog-sidebar">
							<?php
							if ( is_active_sidebar( 'blog-sidebar' ) ) {
								dynamic_sidebar( 'blog-sidebar' );
							} else {
								the_widget( 'WP_Widget_Search', sprintf( 'title=%', __( 'Search', 'pixova-lite' ) ) );
								the_widget( 'WP_Widget_Calendar', sprintf( 'title=%s', __( 'Calendar', 'pixova-lite' ) ) );
							}
							?>
						</aside> <!--/.pixova-blog-sidebar-->
					</div><!--/.col-md-3-->


				</div><!--/.has-padding-->

		</div> <!-- /.row-->

		<div class="row">
			<div class="pixova-custom-pagination col-lg-12">
				<?php the_posts_pagination(); ?>
			</div>
		</div>

	</div><!--/.container-->

<?php get_footer(); ?>
