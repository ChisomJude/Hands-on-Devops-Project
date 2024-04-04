<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php

				global $post;
				$breadcrumbs_enabled = get_theme_mod( 'pixova_lite_enable_post_breadcrumbs', 'breadcrumbs_enabled' );
				if ( 'breadcrumbs_enabled' == $breadcrumbs_enabled ) {
					pixova_lite_breadcrumbs();
				}

				?>
			</div>
		</div>
	</div>
</div>

<div class="container">
		<div class="row">
			<div class="has-padding single-content">
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php if ( has_post_thumbnail() ) { ?>
						<aside class="entry-featured-image">
							<?php echo get_the_post_thumbnail( $post->ID, 'pixova-lite-featured-blog-image' ); ?>
						</aside><!--/.entry-featured-image-->
					<?php } else { ?>
						<aside class="entry-featured-image">
							<?php echo '<img src="' . get_template_directory_uri() . '/layout/images/post-image-placeholder.jpg' . '" />'; ?>
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
						the_content();

						wp_link_pages(
							array(
								'before' => '<nav class="page-links">' . __( 'Pages:', 'pixova-lite' ),
								'after'  => '</nav>',
							)
						);
						?>
					</div><!-- .entry-content -->
					<div class="clearfix"></div><!--/.clearfix-->
				</div>
		</div><!--.col-lg-8.col-xs-12.col-sm-12-->

			<aside class="col-lg-3 col-md-3 col-sm-3 hidden-xs pull-right">
				<div class="pixova-blog-sidebar">
					<?php
					if ( is_active_sidebar( 'blog-sidebar' ) ) {
						dynamic_sidebar( 'blog-sidebar' );
					}
					?>
				</div> <!--/.pixova-blog-sidebar-->
			</aside><!--/.col-lg-3-->
			<div class="clearfix"></div><!--/.clearfix-->
			<?php
			$show_prev_next = get_theme_mod( 'pixova_lite_enable_content_navigation', 1 );

			if ( $show_prev_next ) {

			?>
			<nav class="pixova-post-nav">
			<?php pixova_lite_content_nav( 'pixova-post-nav' ); ?>
			</nav><!--/.pixova-post-nav-->
			<?php } ?>

				<?php
				$show_author_box = get_theme_mod( 'pixova_lite_enable_author_box', 1 );
				if ( $show_author_box ) {

				?>
				<div class="row pixova-author-area">
					<div class="col-lg-1">
						<a class="pixova-author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 110 ); ?>
						</a>
					</div>

					<div class="col-lg-11">
						<h3> <?php _e( 'About the author: ', 'pixova-lite' ); ?> <a class="pixova-author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a></h3>
						<div class="pixova-author-info">
							<?php the_author_meta( 'description' ); ?>
						</div>
					</div><!--/.col-lg-9-->
				</div>

				<?php } ?>

				<div class="clearfix"></div>

				<?php do_action( 'mtl_single_after_article' ); ?>

		<?php comments_template(); ?>
			</div><!--/section-->
		</div> <!--/.row-->
</div><!--/.container-->
