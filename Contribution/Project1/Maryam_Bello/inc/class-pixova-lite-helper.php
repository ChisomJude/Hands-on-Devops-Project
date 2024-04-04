<?php

class Pixova_Lite_Helper {

	public static $pixova_settings;
	public static $pixova_fields = array(
		'pixova_lite_copyright',
		'pixova_lite_preloader_enabled',
		'pixova_lite_animations_enabled',
		'pixova_lite_enable_post_breadcrumbs',
		'pixova_lite_enable_default_images',
		'pixova_lite_header_effect_enabled',
		'pixova_lite_email',
		'pixova_lite_phone',
		'pixova_lite_address',
		'pixova_lite_blog_breadcrumb_menu_prefix',
		'pixova_lite_blog_breadcrumb_menu_separator',
		'pixova_lite_enable_blog_header_image',
		'pixova_lite_blog_text_title',
		'pixova_lite_blog_text_description',
		'pixova_lite_related_posts_enabled',
		'pixova_lite_howmany_blog_posts',
		'pixova_lite_woocommerce_show_header_image',
		'pixova_lite_woocommerce_title',
		'pixova_lite_woocommerce_description',
		'pixova_lite_woocommerce_show_sidebar_on_shop_page',
		'pixova_lite_woocommerce_show_sidebar_on_left_or_right_side',
		'pixova_lite_intro_title_cta',
		'pixova_lite_intro_cta',
		'pixova_lite_intro_sub_cta',
		'pixova_lite_intro_outline_button_text',
		'pixova_lite_intro_outline_button_url',
		'pixova_lite_intro_outline_button_color',
		'pixova_lite_intro_outline_button_text_color',
		'pixova_lite_intro_button_text',
		'pixova_lite_intro_button_url',
		'pixova_lite_intro_button_color',
		'pixova_lite_intro_button_text_color',
		'pixova_lite_intro_what_we_do_1_icon',
		'pixova_lite_intro_what_we_do_1_title',
		'pixova_lite_intro_what_we_do_1_description',
		'pixova_lite_intro_what_we_do_2_icon',
		'pixova_lite_intro_what_we_do_2_title',
		'pixova_lite_intro_what_we_do_2_description',
		'pixova_lite_intro_what_we_do_3_icon',
		'pixova_lite_intro_what_we_do_3_title',
		'pixova_lite_intro_what_we_do_3_description',
		'pixova_lite_about_section_title',
		'pixova_lite_about_section_sub_title',
		'pixova_lite_about_section_textarea',
		'pixova_lite_about_section_blockquote',
		'pixova_lite_about_section_chart_1_heading',
		'pixova_lite_about_section_chart_1_percentage',
		'pixova_lite_about_section_chart_2_heading',
		'pixova_lite_about_section_chart_2_percentage',
		'pixova_lite_about_section_chart_3_heading',
		'pixova_lite_about_section_chart_3_percentage',
		'pixova_lite_about_section_chart_4_heading',
		'pixova_lite_about_section_chart_4_percentage',
		'pixova_lite_about_section_chart_1_bar_color',
		'pixova_lite_about_section_chart_1_track_color',
		'pixova_lite_about_section_chart_2_bar_color',
		'pixova_lite_about_section_chart_2_track_color',
		'pixova_lite_about_section_chart_3_bar_color',
		'pixova_lite_about_section_chart_3_track_color',
		'pixova_lite_about_section_chart_4_bar_color',
		'pixova_lite_about_section_chart_4_track_color',
		'pixova_lite_work_section_title',
		'pixova_lite_work_section_sub_title',
		'pixova_lite_works_project_1_image',
		'pixova_lite_works_project_1_logo',
		'pixova_lite_works_project_1_url',
		'pixova_lite_works_project_2_image',
		'pixova_lite_works_project_2_logo',
		'pixova_lite_works_project_2_url',
		'pixova_lite_works_project_3_image',
		'pixova_lite_works_project_3_logo',
		'pixova_lite_works_project_3_url',
		'pixova_lite_works_project_4_image',
		'pixova_lite_works_project_4_logo',
		'pixova_lite_works_project_4_url',
		'pixova_lite_testimonial_section_title',
		'pixova_lite_testimonial_section_sub_title',
		'pixova_lite_testimonial_1_person_name',
		'pixova_lite_testimonial_1_person_description',
		'pixova_lite_testimonial_1_person_image',
		'pixova_lite_testimonial_2_person_name',
		'pixova_lite_testimonial_2_person_description',
		'pixova_lite_testimonial_2_person_image',
		'pixova_lite_testimonial_3_person_name',
		'pixova_lite_testimonial_3_person_description',
		'pixova_lite_testimonial_3_person_image',
		'pixova_lite_testimonial_4_person_name',
		'pixova_lite_testimonial_4_person_description',
		'pixova_lite_testimonial_4_person_image',
		'pixova_lite_testimonial_5_person_name',
		'pixova_lite_testimonial_5_person_description',
		'pixova_lite_testimonial_5_person_image',
		'pixova_lite_news_section_title',
		'pixova_lite_news_section_sub_title',
		'pixova_lite_news_section_button_text',
		'pixova_lite_news_section_no_posts_per_slide',
		'pixova_lite_contact_section_title',
		'pixova_lite_contact_section_sub_title',
		'pixova_lite_contact_first_heading',
		'pixova_lite_contact_second_heading',
		'pixova_lite_contact_section_cf7',
		'pixova_lite_team_section_title',
		'pixova_lite_team_section_sub_title',
		'pixova_lite_team_member_1_name',
		'pixova_lite_team_member_1_image',
		'pixova_lite_team_member_1_facebook',
		'pixova_lite_team_member_1_dribbble',
		'pixova_lite_team_member_1_email',
		'pixova_lite_team_member_1_twitter',
		'pixova_lite_team_member_1_linkedin',
		'pixova_lite_team_member_1_pinterest',
		'pixova_lite_team_member_1_instagram',
		'pixova_lite_team_member_1_googleplus',
		'pixova_lite_team_member_2_name',
		'pixova_lite_team_member_2_image',
		'pixova_lite_team_member_2_facebook',
		'pixova_lite_team_member_2_dribbble',
		'pixova_lite_team_member_2_email',
		'pixova_lite_team_member_2_twitter',
		'pixova_lite_team_member_2_linkedin',
		'pixova_lite_team_member_2_pinterest',
		'pixova_lite_team_member_2_instagram',
		'pixova_lite_team_member_2_googleplus',
		'pixova_lite_team_member_3_name',
		'pixova_lite_team_member_3_image',
		'pixova_lite_team_member_3_facebook',
		'pixova_lite_team_member_3_dribbble',
		'pixova_lite_team_member_3_email',
		'pixova_lite_team_member_3_twitter',
		'pixova_lite_team_member_3_linkedin',
		'pixova_lite_team_member_3_pinterest',
		'pixova_lite_team_member_3_instagram',
		'pixova_lite_team_member_3_googleplus',
		'pixova_lite_team_member_4_name',
		'pixova_lite_team_member_4_image',
		'pixova_lite_team_member_4_facebook',
		'pixova_lite_team_member_4_dribbble',
		'pixova_lite_team_member_4_email',
		'pixova_lite_team_member_4_twitter',
		'pixova_lite_team_member_4_linkedin',
		'pixova_lite_team_member_4_pinterest',
		'pixova_lite_team_member_4_instagram',
		'pixova_lite_team_member_4_googleplus',
		'pixova_lite_team_member_5_name',
		'pixova_lite_team_member_5_image',
		'pixova_lite_team_member_5_facebook',
		'pixova_lite_team_member_5_dribbble',
		'pixova_lite_team_member_5_email',
		'pixova_lite_team_member_5_twitter',
		'pixova_lite_team_member_5_linkedin',
		'pixova_lite_team_member_5_pinterest',
		'pixova_lite_team_member_5_instagram',
		'pixova_lite_team_member_5_googleplus',
	);


	public static function parse_pixova_settings() {

		$pixova_settings = get_post_meta( Pixova_Lite_Helper::get_setting_page_id(), 'pixova-settings', true );

		if ( is_array( $pixova_settings ) ) {
			return $pixova_settings;
		}

		return array();

	}

	public static function get_pixova_setting( $setting, $default = false ) {

		if ( in_array( $setting, Pixova_Lite_Helper::$pixova_fields ) ) {
			$pixova_settings = Pixova_Lite_Helper::parse_pixova_settings();
			if ( isset( $pixova_settings[ $setting ] ) ) {
				return $pixova_settings[ $setting ];
			} else {
				return false;
			}
		} else {
			return false;
		}

	}

	// static method in order to get settings from page
	// use $arguments[0] if value doesn't exist.
	public static function __callStatic( $name, $arguments ) {

		$settings_id   = str_replace( '_get_', '', $name );
		$setting_value = Pixova_Lite_Helper::get_pixova_setting( $settings_id );

		if ( false === $setting_value ) {
			return $arguments[0];
		} else {
			return $setting_value;
		}

	}

	public static function create_content_from_options() {

		$data = get_post_meta( Pixova_Lite_Helper::get_setting_page_id(), 'pixova-settings', true );

		$sections = array(
			array(
				'title'  => __( 'CTA Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_intro_title_cta'          => __( 'Main CTA title', 'pixova-lite' ),
					'pixova_lite_intro_cta'                => __( 'Main CTA text', 'pixova-lite' ),
					'pixova_lite_intro_sub_cta'            => __( 'Main CTA sub-title', 'pixova-lite' ),
					'pixova_lite_intro_outline_button_text' => __( 'Outline Button Text', 'pixova-lite' ),
					'pixova_lite_intro_outline_button_url' => __( 'Outline Button URL', 'pixova-lite' ),
					'pixova_lite_intro_button_text'        => __( 'Button Text', 'pixova-lite' ),
					'pixova_lite_intro_button_url'         => __( 'Button URL', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'What We Do Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_intro_what_we_do_1_title' => __( 'What we do #1 title', 'pixova-lite' ),
					'pixova_lite_intro_what_we_do_1_description' => __( 'What we do #1 description', 'pixova-lite' ),
					'pixova_lite_intro_what_we_do_2_title' => __( 'What we do #2 title', 'pixova-lite' ),
					'pixova_lite_intro_what_we_do_2_description' => __( 'What we do #2 description', 'pixova-lite' ),
					'pixova_lite_intro_what_we_do_3_title' => __( 'What we do #3 title', 'pixova-lite' ),
					'pixova_lite_intro_what_we_do_3_description' => __( 'What we do #3 description', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Pie Chart Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_about_section_title'      => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_about_section_sub_title'  => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_about_section_textarea'   => __( 'Section content', 'pixova-lite' ),
					'pixova_lite_about_section_blockquote' => __( 'Section blockquote', 'pixova-lite' ),
					'pixova_lite_about_section_chart_1_heading' => __( 'Pie Chart #1 Heading', 'pixova-lite' ),
					'pixova_lite_about_section_chart_1_percentage' => __( 'Pie Chart #1 Percentage', 'pixova-lite' ),
					'pixova_lite_about_section_chart_2_heading' => __( 'Pie Chart #2 Heading', 'pixova-lite' ),
					'pixova_lite_about_section_chart_2_percentage' => __( 'Pie Chart #2 Percentage', 'pixova-lite' ),
					'pixova_lite_about_section_chart_3_heading' => __( 'Pie Chart #3 Heading', 'pixova-lite' ),
					'pixova_lite_about_section_chart_3_percentage' => __( 'Pie Chart #3 Percentage', 'pixova-lite' ),
					'pixova_lite_about_section_chart_4_heading' => __( 'Pie Chart #4 Heading', 'pixova-lite' ),
					'pixova_lite_about_section_chart_4_percentage' => __( 'Pie Chart #4 Percentage', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Recent Works Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_work_section_title'     => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_work_section_sub_title' => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_works_project_1_image'  => __( 'Project #1 Image', 'pixova-lite' ),
					'pixova_lite_works_project_1_logo'   => __( 'Project #1 Logo', 'pixova-lite' ),
					'pixova_lite_works_project_1_url'    => __( 'Project #1 URL', 'pixova-lite' ),
					'pixova_lite_works_project_2_image'  => __( 'Project #2 Image', 'pixova-lite' ),
					'pixova_lite_works_project_2_logo'   => __( 'Project #2 Logo', 'pixova-lite' ),
					'pixova_lite_works_project_2_url'    => __( 'Project #2 URL', 'pixova-lite' ),
					'pixova_lite_works_project_3_image'  => __( 'Project #3 Image', 'pixova-lite' ),
					'pixova_lite_works_project_3_logo'   => __( 'Project #3 Logo', 'pixova-lite' ),
					'pixova_lite_works_project_3_url'    => __( 'Project #3 URL', 'pixova-lite' ),
					'pixova_lite_works_project_4_image'  => __( 'Project #4 Image', 'pixova-lite' ),
					'pixova_lite_works_project_4_logo'   => __( 'Project #4 Logo', 'pixova-lite' ),
					'pixova_lite_works_project_4_url'    => __( 'Project #4 URL', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Testimonials Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_testimonial_section_title'        => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_testimonial_section_sub_title'    => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_testimonial_1_person_name'        => __( 'Testimonial #1 Person Name', 'pixova-lite' ),
					'pixova_lite_testimonial_1_person_description' => __( 'Testimonial #1 Content', 'pixova-lite' ),
					'pixova_lite_testimonial_1_person_image'       => __( 'Testimonial #1 Person Image', 'pixova-lite' ),
					'pixova_lite_testimonial_2_person_name'        => __( 'Testimonial #2 Person Name', 'pixova-lite' ),
					'pixova_lite_testimonial_2_person_description' => __( 'Testimonial #2 Content', 'pixova-lite' ),
					'pixova_lite_testimonial_2_person_image'       => __( 'Testimonial #2 Person Image', 'pixova-lite' ),
					'pixova_lite_testimonial_3_person_name'        => __( 'Testimonial #3 Person Name', 'pixova-lite' ),
					'pixova_lite_testimonial_3_person_description' => __( 'Testimonial #3 Content', 'pixova-lite' ),
					'pixova_lite_testimonial_3_person_image'       => __( 'Testimonial #3 Person Image', 'pixova-lite' ),
					'pixova_lite_testimonial_4_person_name'        => __( 'Testimonial #4 Person Name', 'pixova-lite' ),
					'pixova_lite_testimonial_4_person_description' => __( 'Testimonial #4 Content', 'pixova-lite' ),
					'pixova_lite_testimonial_4_person_image'       => __( 'Testimonial #4 Person Image', 'pixova-lite' ),
					'pixova_lite_testimonial_5_person_name'        => __( 'Testimonial #5 Person Name', 'pixova-lite' ),
					'pixova_lite_testimonial_5_person_description' => __( 'Testimonial #5 Content', 'pixova-lite' ),
					'pixova_lite_testimonial_5_person_image'       => __( 'Testimonial #5 Person Image', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Latest News Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_news_section_title'       => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_news_section_sub_title'   => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_news_section_button_text' => __( 'Button Text', 'pixova-lite' ),
					'pixova_lite_news_section_no_posts_per_slide' => __( 'Number of post per slide', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Team Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_team_section_title'     => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_team_section_sub_title' => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_team_member_1_name'     => __( 'Team #1 Name', 'pixova-lite' ),
					'pixova_lite_team_member_1_image'    => __( 'Team #1 Image', 'pixova-lite' ),
					'pixova_lite_team_member_1_facebook' => __( 'Team #1 Facebook', 'pixova-lite' ),
					'pixova_lite_team_member_1_dribbble' => __( 'Team #1 Dribbble', 'pixova-lite' ),
					'pixova_lite_team_member_1_email'    => __( 'Team #1 Email', 'pixova-lite' ),
					'pixova_lite_team_member_2_name'     => __( 'Team #2 Name', 'pixova-lite' ),
					'pixova_lite_team_member_2_image'    => __( 'Team #2 Image', 'pixova-lite' ),
					'pixova_lite_team_member_2_facebook' => __( 'Team #2 Facebook', 'pixova-lite' ),
					'pixova_lite_team_member_2_dribbble' => __( 'Team #2 Dribbble', 'pixova-lite' ),
					'pixova_lite_team_member_2_email'    => __( 'Team #2 Email', 'pixova-lite' ),
					'pixova_lite_team_member_3_name'     => __( 'Team #3 Name', 'pixova-lite' ),
					'pixova_lite_team_member_3_image'    => __( 'Team #3 Image', 'pixova-lite' ),
					'pixova_lite_team_member_3_facebook' => __( 'Team #3 Facebook', 'pixova-lite' ),
					'pixova_lite_team_member_3_dribbble' => __( 'Team #3 Dribbble', 'pixova-lite' ),
					'pixova_lite_team_member_3_email'    => __( 'Team #3 Email', 'pixova-lite' ),
					'pixova_lite_team_member_4_name'     => __( 'Team #4 Name', 'pixova-lite' ),
					'pixova_lite_team_member_4_image'    => __( 'Team #4 Image', 'pixova-lite' ),
					'pixova_lite_team_member_4_facebook' => __( 'Team #4 Facebook', 'pixova-lite' ),
					'pixova_lite_team_member_4_dribbble' => __( 'Team #4 Dribbble', 'pixova-lite' ),
					'pixova_lite_team_member_4_email'    => __( 'Team #4 Email', 'pixova-lite' ),
					'pixova_lite_team_member_5_name'     => __( 'Team #5 Name', 'pixova-lite' ),
					'pixova_lite_team_member_5_image'    => __( 'Team #5 Image', 'pixova-lite' ),
					'pixova_lite_team_member_5_facebook' => __( 'Team #5 Facebook', 'pixova-lite' ),
					'pixova_lite_team_member_5_dribbble' => __( 'Team #5 Dribbble', 'pixova-lite' ),
					'pixova_lite_team_member_5_email'    => __( 'Team #5 Email', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'Contact Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_contact_section_title'  => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_contact_section_sub_title' => __( 'Section sub-title', 'pixova-lite' ),
					'pixova_lite_contact_first_heading'  => __( 'Left Heading 1', 'pixova-lite' ),
					'pixova_lite_contact_second_heading' => __( 'Left Heading 2', 'pixova-lite' ),
					'pixova_lite_email'                  => __( 'Email', 'pixova-lite' ),
					'pixova_lite_phone'                  => __( 'Phone number', 'pixova-lite' ),
					'pixova_lite_address'                => __( 'Address', 'pixova-lite' ),
				),
			),
			array(
				'title'  => __( 'WooCommerce Section', 'pixova-lite' ),
				'fields' => array(
					'pixova_lite_woocommerce_title'       => __( 'Section title', 'pixova-lite' ),
					'pixova_lite_woocommerce_description' => __( 'Section description', 'pixova-lite' ),
				),
			),
		);

		$content = '';
		foreach ( $sections as $section ) {
			$section_content = '';
			foreach ( $section['fields'] as $field_key => $field_name ) {
				if ( isset( $data[ $field_key ] ) && '' != $field_key ) {
					$section_content .= $field_name . ': ' . $data[ $field_key ] . '<br>';
				}
			}
			if ( '' != $section_content ) {
				if ( '' != $content ) {
					$content .= '<br>';
				}
				$content .= $section['title'] . '<br><br>';
				$content .= $section_content;
			}
		}

		if ( '' != $content ) {
			$pixova_settings_page_args = array(
				'ID'           => Pixova_Lite_Helper::get_setting_page_id(),
				'post_content' => $content,
			);
			wp_update_post( $pixova_settings_page_args );
		}

	}

	public static function get_setting_page_id() {

		$page_id = get_option( 'pixova-settings-id' );
		if ( $page_id ) {
			return $page_id;
		} else {

			$page_args = array(
				'post_title'  => 'Pixova Settings',
				'post_status' => 'draft',
				'post_type'   => 'page',
				'post_author' => 0,
			);

			$page_id = wp_insert_post( $page_args );

			if ( ! is_wp_error( $page_id ) ) {
				update_option( 'pixova-settings-id', $page_id );

				return $page_id;
			}
		}

	}

}

foreach ( Pixova_Lite_Helper::$pixova_fields as $pixova_setting ) {
	add_filter( "customize_sanitize_js_{$pixova_setting}", array( 'Pixova_Lite_Helper', "_get_{$pixova_setting}" ) );
	add_filter( "theme_mod_{$pixova_setting}", array( 'Pixova_Lite_Helper', "_get_{$pixova_setting}" ) );
}

add_action( 'customize_save_after', array( 'Pixova_Lite_Helper', 'create_content_from_options' ) );

add_action( 'add_meta_boxes', 'pixova_remove_editor_for_pixova_settings', 20, 2 );

function pixova_remove_editor_for_pixova_settings( $post_type, $post ) {

	if ( 'page' != $post_type ) {
		return;
	}

	$pixova_page_id = get_option( 'pixova-settings-id' );

	if ( $pixova_page_id && $pixova_page_id == $post->ID ) {
		add_action( 'edit_form_after_title', '_pixova_setting_page_notice' );
		remove_post_type_support( $post_type, 'editor' );
	}

}

function _pixova_setting_page_notice() {
	echo '<div class="notice notice-warning inline"><p>' . __( 'You are currently editing the page that hold your theme settings. Please don\'t delete it', 'pixova-lite' ) . '</p></div>';
}

add_filter( 'display_post_states', 'add_states_for_pixova_settings_page', 10, 2 );

function add_states_for_pixova_settings_page( $post_states, $post ) {

	if ( intval( get_option( 'pixova-settings-id' ) ) === $post->ID ) {
		$post_states['pixova_setting_page'] = __( 'Theme Settings Page. Don\'t delete it.', 'pixova-lite' );
		unset( $post_states['draft'] );
	}

	return $post_states;

}


add_action( 'customize_update_epsilon_page', 'pixova_lite_save_custom_setting', 10, 2 );

function pixova_lite_save_custom_setting( $value, $setting ) {

	$existing_settings = Pixova_Lite_Helper::parse_pixova_settings();
	$key               = $setting->id;

	$existing_settings[ $key ] = $value;

	update_post_meta( Pixova_Lite_Helper::get_setting_page_id(), 'pixova-settings', $existing_settings );

	return true;

}
