<?php
/**
 * Template part for the support tab in welcome screen
 *
 * @package Epsilon Framework
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div class="feature-section two-col">
	<div class="col">
		<h3><i class="dashicons dashicons-sos"></i><?php esc_html_e( 'Contact Support', 'epsilon-framework' ); ?></h3>
		<p>
			<i><?php esc_html_e( 'We offer excellent support through our advanced ticketing system. Make sure to register your purchase before contacting support!', 'epsilon-framework' ); ?></i>
		</p>
		<p><a target="_blank"  class="button button-primary" href="<?php echo esc_url( 'https://colorlib.com/wp/forums/' ); ?>"><?php esc_html_e( 'Contact Support', 'epsilon-framework' ); ?></a>
		</p>
	</div><!--/.col-->

	<div class="col">
		<h3><i class="dashicons dashicons-book-alt"></i><?php esc_html_e( 'Documentation', 'epsilon-framework' ); ?></h3>
		<p>
			<i><?php esc_html_e( 'This is the place to go to reference different aspects of the theme. Our online documentation is an incredible resource for learning the ins and outs of using Pixova.', 'epsilon-framework' ); ?></i>
		</p>
		<p>
			<a target="_blank" href="<?php echo esc_url( 'https://colorlib.com/wp/support/pixova/' ); ?>"><?php esc_html_e( 'See our full documentation', 'epsilon-framework' ); ?></a>
		</p>
	</div><!--/.col-->
</div><!--/.feature-section-->
