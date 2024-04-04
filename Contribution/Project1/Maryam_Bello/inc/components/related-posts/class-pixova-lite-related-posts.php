<?php

/**
 * Class MTL_Related_Posts_Output
 *
 * This file does the social sharing handling for the Muscle Core Lite Framework
 *
 * @author      Colorlib
 * @copyright   (c) Copyright by Colorlib
 * @link        https://colorlib.com/
 * @package     Colorlib
 * @since       Version 1.0.0
 */

// @todo : more effects for hover images
// @todo: pull in more than post title & date


if ( ! function_exists( 'mtl_call_related_posts_class' ) ) {
	/**
	 *
	 * Gets called only if the "display related posts" option is checked
	 * in the back-end
	 *
	 * @since   1.0.0
	 *
	 */
	function mtl_call_related_posts_class() {
		$display_related_blog_posts = get_theme_mod( 'pixova_lite_enable_related_blog_posts', 1 );

		if ( 1 == $display_related_blog_posts ) {

			// instantiate the class & load everything else
			Pixova_Lite_Related_Posts::get_instance();
		}
	}

	add_action( 'wp_loaded', 'mtl_call_related_posts_class' );
}


if ( ! class_exists( 'MT_Related_Posts' ) ) {

	/**
	 * Class MT_Related_Posts
	 */
	class Pixova_Lite_Related_Posts {

		/**
		 * @var Singleton The reference to *Singleton* instance of this class
		 */
		private static $instance;

		/**
		 *
		 */
		protected function __construct() {

			if ( get_theme_mod( 'pixova_lite_related_posts_enabled', 'pixova_lite_related_posts_enable' ) == 'pixova_lite_related_posts_enable' ) {
				add_action( 'mtl_single_after_article', array( $this, 'output_related_posts' ), 2 );
			}

		}

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Singleton The *Singleton* instance.
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Singleton* instance.
		 *
		 * @return void
		 */
		private function __clone() {
		}

		/**
		 * Private unserialize method to prevent unserializing of the *Singleton*
		 * instance.
		 *
		 * @return void
		 */
		private function __wakeup() {
		}


		/**
		 * Get related posts by category
		 *
		 * @param  integer $post_id current post id
		 * @param  integer $number_posts number of posts to fetch
		 *
		 * @return object                  object with posts info
		 */
		public function get_related_posts( $post_id, $number_posts = - 1 ) {

			$related_postsuery = new WP_Query();
			$args              = '';

			if ( 0 == $number_posts ) {
				return $related_postsuery;
			}

			$args = wp_parse_args( $args, array(
				'category__in'        => wp_get_post_categories( $post_id ),
				'ignore_sticky_posts' => 0,
				'posts_per_page'      => $number_posts,
				'post__not_in'        => array( $post_id ),
				'meta_key'            => '_thumbnail_id',
			) );

			$related_postsuery = new WP_Query( $args );

			// reset post query
			wp_reset_postdata();
			wp_reset_query();

			return $related_postsuery;
		}

		/**
		 * Render related posts carousel
		 *
		 * @return string                    HTML markup to display related posts
		 **/
		function output_related_posts() {

			echo '<div class="pixova-related-posts">';

			// Check if related posts should be shown
			$related_posts = $this->get_related_posts( get_the_ID(), get_option( 'posts_per_page' ) );

			// Number of posts to show / view
			$limit      = get_theme_mod( 'pixova_lite_howmany_blog_posts', 3 );
			$show_title = get_theme_mod( 'pixova_lite_enable_related_title_blog_posts', 1 );
			$show_date  = get_theme_mod( 'pixova_lite_enable_related_date_blog_posts', 1 );
			$auto_play  = get_theme_mod( 'pixova_lite_autoplay_blog_posts', 1 );
			$pagination = get_theme_mod( 'pixova_lite_pagination_blog_posts', 1 );

			echo '<div class="row pixova-padded">';

			/*
			 * Heading
			 */
			echo '<div class="col-sm-11 col-xs-12">';
			echo '<h3>' . __( 'Related posts: ', 'pixova-lite' ) . '</h3>';
			echo '</div>';

			/*
			 * Arrows
			 */
			echo '<div class="col-sm-1 hidden-xs text-right">';
			echo '<ul class="pixova-carousel-arrows clearfix">';
			echo '<li class="pull-right"><a href="#" class="pixova-owl-next fa fa-angle-right"></a></li>';
			echo '<li class="pull-left"><a href="#" class="pixova-owl-prev fa fa-angle-left"></a></li>';
			echo '</ul>';
			echo '</div>';
			echo '</div><!--/.row-->';

			echo sprintf( '<div class="owlCarousel" data-slider-id="%s" id="owlCarousel-%s" data-slider-items="%s" data-slider-speed="400" data-slider-auto-play="%s" data-slider-navigation="false" data-slider-pagination="%s">', get_the_ID(), get_the_ID(), $limit, $auto_play, $pagination );

			// Loop through related posts
			while ( $related_posts->have_posts() ) {
				$related_posts->the_post();

				echo '<div class="item">';
				echo '<div class="col-sm-12">';

				if ( has_post_thumbnail( $related_posts->post->ID ) ) {
					echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_post_thumbnail( $related_posts->post->ID, 'pixova-lite-related-posts' ) . '</a>';
				}

				if ( $show_title ) {
					echo '<div class="pixova-related-posts-title">';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a>';
					echo '</div>';
				}
				if ( $show_date ) {
					echo '<div class="pixova-related-posts-date">';
					echo get_the_date();
					echo '</div>';
				}

				echo '</div> <!--/.col-sm-6.col-md-4-->';
				echo '</div><!--/.item-->';
			}

			echo '</div><!--/.owlCarousel-->';
			echo '</div><!--/.pixova-related-posts-->';

			wp_reset_query();
			wp_reset_postdata();
		}
	}
}// End if().
