<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->
	<div class="entry-meta">
		<?php
		printf(

			// Translators: 1 is the post author, 2 is the category list.
			__( '<span class="post-meta-separator"><i class="fa fa-user"></i>%1$s</span><span class="post-meta-separator"><i class="fa fa-calendar"></i>%2$s</span><span class="post-meta-separator"><i class="fa fa-comment"></i>%3$s</span><span class="post-meta-separator"><i class="fa fa-folder"></i>%4$s</span>', 'pixova-lite' ), get_the_author_link(),
			// Translators: Post time
			get_the_date( get_option( 'date_format' ), $post->ID ),
			// Translators: Number of com,ments
			pixova_lite_get_number_of_comments( $post->ID ),
			// Translators: tag list
			get_the_tag_list( 'Tags: ', ', ', '' )
		);
		?>
	</div><!--/.entry-meta-->
	<?php if ( has_post_thumbnail() ) { ?>
		<aside class="entry-featured-image">
			<?php echo get_the_post_thumbnail( $post->ID, 'pixova-lite-featured-blog-image' ); ?>
		</aside><!--/.entry-featured-image-->
	<?php } ?>

	<div class="entry-content">
		<?php

		echo the_excerpt();

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
