<form method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'pixova-lite' ); ?></span>
		<input type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'pixova-lite' ); ?>" placeholder="<?php esc_attr_e( 'Search...', 'pixova-lite' ); ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'pixova-lite' ); ?>" />
</form>
