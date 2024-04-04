<?php

if ( function_exists( 'register_sidebar' ) ) {
	if ( ! function_exists( 'pixova_lite_register_sidebars' ) ) {
		function pixova_lite_register_sidebars() {

			#
			#    Register sidebars
			#

			register_sidebar( array(
				'id' => 'blog-sidebar',
				'name' => __( '[Blog] Sidebar #1', 'pixova-lite' ),
				'description' => __( 'In blog archive, right side', 'pixova-lite' ),
				'before_title' => '<h3 class="widget-title"><span>',
				'after_title' => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			) );

			register_sidebar( array(
				'id' => 'footer-sidebar-1',
				'name' => __( '[Footer] Sidebar #1', 'pixova-lite' ),
				'description' => __( 'In the footer, first column', 'pixova-lite' ),
				'before_title' => '<h3 class="widget-title"><span>',
				'after_title' => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			) );

			register_sidebar( array(
				'id' => 'footer-sidebar-2',
				'name' => __( '[Footer] Sidebar #2', 'pixova-lite' ),
				'description' => __( 'In the footer, 2nd column', 'pixova-lite' ),
				'before_title' => '<h3 class="widget-title"><span>',
				'after_title' => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			) );

			register_sidebar( array(
				'id' => 'footer-sidebar-3',
				'name' => __( '[Footer] Sidebar #3', 'pixova-lite' ),
				'description' => __( 'In the footer, 3rd column', 'pixova-lite' ),
				'before_title' => '<h3 class="widget-title"><span>',
				'after_title' => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			) );

			register_sidebar( array(
				'id' => 'footer-sidebar-4',
				'name' => __( '[Footer] Sidebar Full Width', 'pixova-lite' ),
				'description' => __( 'In the footer, displayed as full width. Below the first 3 widgets.', 'pixova-lite' ),
				'before_title' => '<h3 class="widget-title"><span>',
				'after_title' => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
			) );

			if ( class_exists( 'WooCommerce' ) ) {
				register_sidebar( array(
					'id'            => 'woocommerce-sidebar',
					'name'          => __( '[WooCommerce] Sidebar', 'pixova-lite' ),
					'description'   => __( 'In WooCommerce, Shop Page.', 'pixova-lite' ),
					'before_title'  => '<h3 class="widget-title"><span>',
					'after_title'   => '</span></h3>',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
				) );
			}

		} // function pixova_lite_register_sidebars end

		add_action( 'widgets_init', 'pixova_lite_register_sidebars' );

	} // End if().
} // End if().
