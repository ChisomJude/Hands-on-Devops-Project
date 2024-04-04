<?php

if ( ! function_exists( 'pixova_lite_search_form_modify' ) ) {
	/**
	 * Add a `screen-reader-text` class to the search form's submit button.
	 *
	 * @since Pixova Lite 1.16
	 *
	 * @param string $html Search form HTML.
	 * @return string Modified search form HTML.
	 */
	function pixova_lite_search_form_modify( $html ) {
		return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
	}

	add_filter( 'get_search_form', 'pixova_lite_search_form_modify' );
}
