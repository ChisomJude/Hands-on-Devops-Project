<?php
/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */

function pixova_lite_jetpack_setup() {

	add_theme_support( 'infinite-scroll', array(

		'container' => 'main',
		'footer'    => 'page',

	) );

}

add_action( 'after_setup_theme', 'pixova_lite_jetpack_setup' );
