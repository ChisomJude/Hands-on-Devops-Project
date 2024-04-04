<?php


class Pixova_Lite_Widget_About extends WP_Widget {

	function __construct() {

		$widget_ops = array(
			'classname' => 'pixova_lite_widget_about',
			'description' => __( 'A widget that displays about text & social media counts. Designed for footer', 'pixova-lite' ),
		);

		$control_ops = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'pixova_lite_widget_about',
		);

		parent::__construct( 'pixova_lite_widget_about', __( '[MT] - About', 'pixova-lite' ), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {
		global $post;

		$title = apply_filters( 'widget_title', $instance['title'] );
		$show_title = $instance['show_title'];

		if ( ! $instance['about_text'] ) {
			$instance['about_text'] = '';
		}

		echo $args['before_widget'];

		echo '<div class="fixed">';

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( '1' == $show_title ) {
			if ( $title ) {
				 echo $args['before_title'] . $title . $args['after_title'];
			}
		}
			echo '<p class="footer-descr">';
				echo esc_textarea( $instance['about_text'] );
			echo '</p>';

		echo '</div>';

		echo $args['after_widget'];
	}


	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']                       = esc_html( $new_instance['title'] );
		$instance['show_title']                  = strip_tags( $new_instance['show_title'] );
		$instance['about_text']                  = esc_html( $new_instance['about_text'] );

		return $instance;
	}


	function form( $instance ) {

		$defaults = array(
			'title' => null,
			'show_title' => null,
			'about_text' => null,
		);

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div class="macho-meta">

		  <p>
			<input id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" value="1" <?php checked( '1', $instance['show_title'] ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show widget title?', 'pixova-lite' ); ?></label>
		  </p>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixova-lite' ); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:100%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'about_text' ); ?>"><?php _e( 'About us', 'pixova-lite' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'about_text' ); ?>" rows="10" cols="10" name="<?php echo $this->get_field_name( 'about_text' ); ?>"><?php echo esc_textarea( $instance['about_text'] ); ?></textarea>
			</p>

		</div>

	<?php
	}
}


// register the shortcode
register_widget( 'pixova_lite_widget_about' );
