<?php get_header(); ?>

	<div class="container">
		<div class="row">

			<div class="has-padding">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<div class="row pixova-author-area">
						<div class="col-lg-2">
							<a class="pixova-author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), 110 ); ?>
							</a>
						</div>

						<div class="col-lg-10">
							<h3> <?php echo __( 'Written by: ', 'pixova-lite' ) . get_the_author(); ?></h3>
							<div class="pixova-author-info">
								<?php the_author_meta( 'description' ); ?>
							</div>
						</div><!--/.col-lg-9-->
					</div>

					<div class="clearfix"></div>

					<?php
					if ( have_posts() ) {

						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content', get_post_format() );
						}
					}
					?>

				</div><!--/.col-lg-8-->

				<aside class="col-lg-3 col-md-3 col-sm-3 hidden-xs pull-right">
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
				</aside><!--/.col-md-3-->

			</div><!--/.has-padding-->

			<div class="row">
				<div class="pixova-custom-pagination col-lg-12">
					<?php the_posts_pagination(); ?>
				</div>
			</div>
		</div><!--/.row-->
	</div><!--/.container-->

<?php get_footer(); ?>
