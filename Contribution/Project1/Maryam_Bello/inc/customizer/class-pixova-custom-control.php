<?php
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Pixova_Custom_Control' ) ) {
	class Pixova_Custom_Control extends WP_Customize_Control {

		protected function get_value() {
			$setting_value = Pixova_Lite_Helper::get_pixova_setting( $this->id );
			if ( false === $setting_value ) {
				return $this->value();
			} else {
				return $setting_value;
			}
		}

		/**
		 *
		 */
		protected function render_content() {
			switch ( $this->type ) {
				case 'checkbox':
					?>
					<label>
						<?php
						echo '<input type="checkbox" value="' . esc_attr( $this->get_value() ) . '" ' . $this->get_link() . ' ' . checked( $this->get_value(), 1, false ) . '/>';
						?>
						<?php echo esc_html( $this->label ); ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>
					</label>
					<?php
					break;
				case 'radio':
					if ( empty( $this->choices ) ) {
						return;
					}
					$name = '_customize-radio-' . $this->id;
					if ( ! empty( $this->label ) ) :
						?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php
					endif;
					if ( ! empty( $this->description ) ) :
						?>
						<span class="description customize-control-description"><?php echo $this->description; ?></span>
					<?php
					endif;
					foreach ( $this->choices as $value => $label ) :
						?>
						<label>
							<?php
							echo '<input type="radio" value="' . esc_attr( $value ) . '" name="' . esc_attr( $name ) . $this->get_link() . ' ' . checked( $this->get_value(), $value, false ) . '/>';
							echo esc_html( $label );
							?>
							<br/>
						</label>
						<?php
					endforeach;
					break;
				case 'select':
					if ( empty( $this->choices ) ) {
						return;
					}
					?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>

						<select <?php $this->link(); ?>>
							<?php
							foreach ( $this->choices as $value => $label ) {
								echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->get_value(), $value, false ) . '>' . $label . '</option>';
							}
							?>
						</select>
					</label>
					<?php
					break;
				case 'textarea':
					?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>
						<textarea
								rows="5" <?php $this->input_attrs(); ?> <?php $this->link(); ?>><?php echo esc_textarea( $this->get_value() ); ?></textarea>
					</label>
					<?php
					break;
				case 'dropdown-pages':
					?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>

						<?php
						$dropdown_name     = '_customize-dropdown-pages-' . $this->id;
						$show_option_none  = __( '&mdash; Select &mdash;', 'pixova-lite' );
						$option_none_value = '0';
						$dropdown          = wp_dropdown_pages(
							array(
								'name'              => $dropdown_name,
								'echo'              => 0,
								'show_option_none'  => $show_option_none,
								'option_none_value' => $option_none_value,
								'selected'          => $this->get_value(),
							)
						);
						if ( empty( $dropdown ) ) {
							$dropdown  = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $dropdown_name ) );
							$dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
							$dropdown .= '</select>';
						}
						// Hackily add in the data link parameter.
						$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
						// Even more hacikly add auto-draft page stubs.
						// @todo Eventually this should be removed in favor of the pages being injected into the underlying get_pages() call. See <https://github.com/xwp/wp-customize-posts/pull/250>.
						$nav_menus_created_posts_setting = $this->manager->get_setting( 'nav_menus_created_posts' );
						if ( $nav_menus_created_posts_setting && current_user_can( 'publish_pages' ) ) {
							$auto_draft_page_options = '';
							foreach ( $nav_menus_created_posts_setting->get_value() as $auto_draft_page_id ) {
								$post = get_post( $auto_draft_page_id );
								if ( $post && 'page' === $post->post_type ) {
									$auto_draft_page_options .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $post->ID ), esc_html( $post->post_title ) );
								}
							}
							if ( $auto_draft_page_options ) {
								$dropdown = str_replace( '</select>', $auto_draft_page_options . '</select>', $dropdown );
							}
						}
						echo $dropdown;
						?>
					</label>
					<?php if ( $this->allow_addition && current_user_can( 'publish_pages' ) && current_user_can( 'edit_theme_options' ) ) : ?>
					<button type="button" class="button-link add-new-toggle">
						<?php
						/* translators: %s: add new page label */
						printf( __( '+ %s', 'pixova-lite' ), get_post_type_object( 'page' )->labels->add_new_item );
						?>
					</button>
					<div class="new-content-item">
						<label for="create-input-<?php echo $this->id; ?>"><span
									class="screen-reader-text"><?php _e( 'New page title', 'pixova-lite' ); ?></span></label>
						<input type="text" id="create-input-<?php echo $this->id; ?>" class="create-item-input" placeholder="<?php esc_attr_e( 'New page title&hellip;', 'pixova-lite' ); ?>">
						<button type="button" class="button add-content"><?php _e( 'Add', 'pixova-lite' ); ?></button>
					</div>
				<?php
				endif;
					break;
				default:
					?>
					<label>
						<?php if ( ! empty( $this->label ) ) : ?>
							<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $this->description ) ) : ?>
							<span class="description customize-control-description"><?php echo $this->description; ?></span>
						<?php endif; ?>
						<input type="<?php echo esc_attr( $this->type ); ?>" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->get_value() ); ?>" <?php $this->link(); ?> />
					</label>
					<?php
					break;
			}// End switch().
		}

		public function json() {
			$this->to_json();
			$this->json['value'] = $this->get_value();

			return $this->json;
		}

	}
} // End if().
