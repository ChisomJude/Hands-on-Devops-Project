<?php

get_header();

?>

<?php

if ( 'posts' == get_option( 'show_on_front' ) ) {
?>

	<div class="container">
		<div class="row">
			<section class="has-padding">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
					<?php
					if ( have_posts() ) {

						while ( have_posts() ) {
							the_post();
							?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="pixova-date"></div><!--/.pixova-date-->
								<header class="entry-header">
									<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								</header><!-- .entry-header -->

								<?php if ( has_post_thumbnail() ) { ?>
									<aside class="entry-featured-image">
										<?php echo get_the_post_thumbnail( $post->ID, 'pixova-lite-featured-blog-image' ); ?>
									</aside><!--/.entry-featured-image-->
								<?php } ?>
								<div class="entry-meta">
									<?php
									printf(
										// Translators: 1 is the post author, 2 is the category list.
										__( '<span class="post-meta-separator"><i class="fa fa-user"></i>%1$s</span><span class="post-meta-separator"><i class="fa fa-calendar"></i>%2$s</span><span class="post-meta-separator"><i class="fa fa-comment"></i>%3$s</span><span class="post-meta-separator"><i class="fa fa-folder"></i>%4$s</span>', 'pixova-lite' ),
										get_the_author_link(),
										// Translators: Post time
										get_the_date( get_option( 'date_format' ), $post->ID ),
										// Translators: Number of com,ments
										pixova_lite_get_number_of_comments( $post->ID ),
										// Translators: tag list
										get_the_tag_list( 'Tags: ',', ','' )
									);
									?>
								</div><!--/.entry-meta-->
								<div class="entry-content">
									<?php
										echo apply_filters( 'the_content', substr( get_the_content(), 0, 200 ) );

										wp_link_pages(
											array(
												'before' => '<div class="page-links">' . __( 'Pages:', 'pixova-lite' ),
												'after'  => '</div>',
											)
										);
									?>
								</div><!-- .entry-content -->
								<div class="clearfix"></div><!--/.clearfix-->
							</article><!-- #post-## -->
						<?php
						}// End while().
						?>
					<?php
					}// End if().
					?>
				</div><!--/.col-lg-8-->

				<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs pull-right">
					<aside class="pixova-blog-sidebar">
						<?php
						if ( is_active_sidebar( 'blog-sidebar' ) ) {
							dynamic_sidebar( 'blog-sidebar' );
						} else {
							the_widget( 'WP_Widget_Search', sprintf( 'title=%s', __( 'Search', 'pixova-lite' ) ) );
							the_widget( 'WP_Widget_Calendar', sprintf( 'title=%s', __( 'Calendar', 'pixova-lite' ) ) );
						}
						?>
					</aside> <!--/.pixova-blog-sidebar-->
				</div><!--/.col-lg-3-->

				<div class="pixova-custom-pagination col-lg-12">
					<?php the_posts_pagination(); ?>
				</div><!--/.pixova-custom-pagination-->
			</section><!--/section-->
		</div><!--/.row-->
	</div><!--/.container-->

<?php
} // End if().
else {


	$sections      = pixova_get_sections_position();
	$sections_args = array(
		'pixova_lite_panel_intro'        => array(
			'check'    => 'pixova_lite_intro_visibility',
			'template' => 'intro',
		),
		'pixova_lite_panel_about'        => array(
			'check'    => 'pixova_lite_about_visibility',
			'template' => 'about',
		),
		'pixova_lite_panel_works'        => array(
			'check'    => 'pixova_lite_works_visibility',
			'template' => 'works',
		),
		'pixova_lite_panel_testimonials' => array(
			'check'    => 'pixova_lite_testimonials_visibility',
			'template' => 'testimonials',
		),
		'pixova_lite_panel_news'         => array(
			'check'    => 'pixova_lite_news_visibility',
			'template' => 'news',
		),
		'pixova_lite_panel_team'         => array(
			'check'    => 'pixova_lite_team_visibility',
			'template' => 'team',
		),
		'pixova_lite_panel_contact'      => array(
			'check'    => 'pixova_lite_contact_visibility',
			'template' => 'contact',
		),
	);

	foreach ( $sections as $section ) {

		if ( get_theme_mod( $sections_args[ $section ]['check'], 1 ) ) {
			get_template_part( 'sections/section', $sections_args[ $section ]['template'] );
		}
	}
} // else
?>

<?php get_footer(); ?>
