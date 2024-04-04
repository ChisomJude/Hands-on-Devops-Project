<?php

$check_footer_theme_copyright_enable = get_theme_mod( 'pixova_lite_copyright_enable', 1 );
$text_footer_theme_copyright_message = get_theme_mod( 'pixova_lite_copyright', sprintf( '&copy; %s', esc_html__( 'Copyright 20', 'pixova-lite' ) . sprintf( '%s', date( 'y' ) ) . esc_html__( '. All Rights Reserved', 'pixova-lite' ) ) );
$sidebar_args                        = array(
	'before_title' => '<h3 class="widget-title"><span>',
	'after_title'  => '</span></h3>',
);

?>

		</div><!-- #content -->
		<footer id="footer" class="site-footer">
			<div class="container">
				<div class="row">
					<?php

					echo '<section class="pixova-footer-widget col-md-4 clearfix">';
					if ( is_active_sidebar( 'footer-sidebar-1' ) ) {
							dynamic_sidebar( 'footer-sidebar-1' );
					} elseif ( current_user_can( 'edit_theme_options' ) ) {
						the_widget( 'pixova_lite_widget_about', sprintf( 'title=%s', __( 'About', 'pixova-lite' ) ) . '&' . sprintf( 'show_title=1&about_text=%s.', __( 'The many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected true of a humour', 'pixova-lite' ) ), $sidebar_args );
					}
					echo '</section><!--/.pixova-foter-widget.col-md-4.clearfix-->';
					echo '<section class="pixova-footer-widget col-md-4 clearfix">';

					if ( is_active_sidebar( 'footer-sidebar-2' ) ) {

							dynamic_sidebar( 'footer-sidebar-2' );

					} elseif ( current_user_can( 'edit_theme_options' ) ) {
					?>

							<div class="widget">
								<h3 class="widgettitle"><span><?php _e( 'Quick nav', 'pixova-lite' ); ?></span></h3>
									<ul id="menu-pixova-footer-menu" class="menu">
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#about"><?php _e( 'About us', 'pixova-lite' ); ?></a></li>
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#works"><?php _e( 'Recent Works', 'pixova-lite' ); ?></a></li>
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#testimonials"><?php _e( 'Testimonials', 'pixova-lite' ); ?></a></li>
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#news"><?php _e( 'News', 'pixova-lite' ); ?></a></li>
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#team"><?php _e( 'Team', 'pixova-lite' ); ?></a></li>
										<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item"><a href="#contact"><?php _e( 'Contact', 'pixova-lite' ); ?></a></li>
									</ul>
							</div>
							<?php
					}

					echo '</section><!--/.pixova-foter-widget.col-md-4.clearfix-->';
					echo '<section class="pixova-footer-widget col-md-4 clearfix">';

					if ( is_active_sidebar( 'footer-sidebar-3' ) ) {
						dynamic_sidebar( 'footer-sidebar-3' );
					} elseif ( current_user_can( 'edit_theme_options' ) ) {
						the_widget( 'pixova_lite_widget_latest_posts', sprintf( 'title=%s', __( 'Latest Posts', 'pixova-lite' ) ) . '&show_title=1&items=1', $sidebar_args );
					}

					echo '</section><!--/.pixova-foter-widget.col-md-4.clearfix-->';

					?>
				</div> <!-- /.row-->
				<?php
				echo '<div class="row">';
					echo '<section class="pixova-footer-widget col-md-12 clearfix">';
				if ( is_active_sidebar( 'footer-sidebar-4' ) ) {
					dynamic_sidebar( 'footer-sidebar-4' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					the_widget( 'pixova_lite_widget_social_media', sprintf( 'title=%s', __( 'Follow us', 'pixova-lite' ) ) . '&show_title=0&profile_facebook=#&profile_twitter=#&profile_plus=#&profile_pinterest=#&profile_linkedin=#&profile_youtube=#&profile_dribbble=#&profile_tumblr=#&profile_instagram=#&profile_github=#&profile_bitbucket=#&profile_codepen=#.' );
				}
					echo '</section><!--/.pixova-foter-widget.col-md-12.clearfix-->';
				echo '</div><!--/.row-->';
				?>
			</div> <!-- /.container -->

			<div class="fluid-container">
				<div class="footer-copyright-container">
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<p class="footer-copyright">

									<?php

									if ( $check_footer_theme_copyright_enable ) {
									?>

										<span class="pixova-lite-footer-theme-copyright">
										<?php _e( 'Theme:', 'pixova-lite' ); ?> <a href="<?php echo esc_url( 'https://colorlib.com/wp/themes/pixova/' ); ?>" target="_blank" title="<?php _e( 'Free One Page Parallax WordPress Theme', 'pixova-lite' ); ?>"><?php _e( 'Pixova Lite', 'pixova-lite' ); ?></a>
										&middot;
										<?php _e( 'Made with','pixova-lite' ); ?> <span class="footer-heart-icon fa fa-heart"></span> <?php _e( ' by ', 'pixova-lite' ); ?> 
										<a href="https://colorlib.com/" title="Premium Professional Responsive WordPress Themes"><?php _e( 'Colorlib', 'pixova-lite' ); ?></a>
										&middot;
										</span><!--/.pixova-lite-footer-theme-copyright-->
										<?php } ?>

									<span class="pixova-lite-footer-text-copyright">
										<?php echo wp_kses_post( $text_footer_theme_copyright_message ); ?>
									</span><!--/.pixova-lite-footer-text-copyright-->
								</p>
							</div><!--/.text-center-->
						</div><!--/col-lg-12-->
					</div><!--/.row-->
				</div><!--/.footer-copyright-container-->
			</div><!--/.fluid-container-->
		</footer>
		<a href="#" class="pixova-top"><?php _e( 'Top', 'pixova-lite' ); ?></a>
		<?php wp_footer(); ?>
	</body>
</html>
