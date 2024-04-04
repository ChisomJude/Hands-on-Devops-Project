<?php

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside><!--/#secondary.widget-area-->
