<?php get_header(); ?>

<div class="has-padding">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
			while ( have_posts() ) :
				the_post();
?>
				<div class="container">
					<div class="row">
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
							</div><!-- #post-## -->
						<?php comments_template(); ?>
					</div><!--/.row-->
				</div><!--/.container-->
			<?php
			endwhile; // end of the loop.
			?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>
