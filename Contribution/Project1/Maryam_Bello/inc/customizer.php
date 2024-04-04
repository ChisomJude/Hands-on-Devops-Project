<?php

function pixova_lite_customize_register( $wp_customize ) {

	// Recomended actions
	global $pixova_required_actions, $pixova_recommended_plugins;
	$customizer_recommended_plugins = array();
	if ( is_array( $pixova_recommended_plugins ) ) {
		foreach ( $pixova_recommended_plugins as $k => $s ) {
			if ( $s['recommended'] ) {
				$customizer_recommended_plugins[ $k ] = $s;
			}
		}
	}
	$customizer_pixova_required_actions = array();
	if ( ! empty( $pixova_required_actions ) ) {
		foreach ( $pixova_required_actions as $required_action ) {
			if ( 'pixova-req-import-content' == $required_action['id'] ) {
				$required_action['description'] = sprintf(
					esc_html__( 'In oder to import the demo content go %s', 'pixova-lite' ),
					'<a href="' . admin_url( 'themes.php?page=pixova-welcome&tab=recommended_actions' ) . '">' . esc_html__( 'here', 'pixova-lite' ) . '</a>'
				);
			}
			$customizer_pixova_required_actions[] = $required_action;
		}
	}
	$current_theme = wp_get_theme();
	$theme_slug    = 'pixova';
	$wp_customize->add_section( new Epsilon_Section_Recommended_Actions( $wp_customize, 'epsilon_recomended_section', array(
		'title'                        => esc_html__( 'Recomended Actions', 'pixova-lite' ),
		'social_text'                  => esc_html( $current_theme->get( 'Author' ) ) . esc_html__( ' is social', 'pixova-lite' ),
		'plugin_text'                  => esc_html__( 'Recomended Plugins', 'pixova-lite' ),
		'actions'                      => $customizer_pixova_required_actions,
		'plugins'                      => $customizer_recommended_plugins,
		'theme_specific_option'        => $theme_slug . '_show_required_actions',
		'theme_specific_plugin_option' => $theme_slug . '_show_recommended_plugins',
		'facebook'                     => 'https://www.facebook.com/colorlib',
		'twitter'                      => 'https://twitter.com/colorlib',
		'wp_review'                    => true,
		'priority'                     => 0,
	) ) );
	$wp_customize->add_section( new Epsilon_Section_Pro( $wp_customize, 'epsilon-section-pro', array(
		'title'       => esc_html__( 'Theme documentation', 'pixova-lite' ),
		'button_text' => esc_html__( 'Learn more', 'pixova-lite' ),
		'button_url'  => 'https://colorlib.com/wp/support/pixova/',
		'priority'    => 0,
	) ) );

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Remove sections from customizer front-view
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );

	# Necessary since we can't debug on IIS servers
	# Mac OS X rules for dev :)
	if ( ! pixova_lite_on_iis() ) {

		// Change panel for Site Title & Tagline Section
		$site_title        = $wp_customize->get_section( 'title_tagline' );
		$site_title->panel = 'pixova_lite_panel_general';

		// Change panel for Header Image
		$site_title2        = $wp_customize->get_section( 'header_image' );
		$site_title2->panel = 'pixova_lite_panel_intro';

		// Change panel for Static Front Page
		$site_title3        = $wp_customize->get_section( 'static_front_page' );
		$site_title3->panel = 'pixova_lite_panel_general';

		// Change priority for Site Title
		$site_title4              = $wp_customize->get_control( 'blogname' );
		$site_title4->section     = 'pixova_lite_general_section';
		$site_title4->description = esc_html__( 'Company name in text format below', 'pixova-lite' );
		$site_title4->priority    = 1;

		// Change priority for Site Tagline
		$site_title5           = $wp_customize->get_control( 'blogdescription' );
		$site_title5->priority = 17;
	}

	/* Section Visibility */
	$wp_customize->add_section( 'pixova_lite_visibility_section', array(
		'title'    => esc_html__( 'Section visibility', 'pixova-lite' ),
		'priority' => 25,
	) );

	/* About visibility */
	$wp_customize->add_setting( 'pixova_lite_about_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_about_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the Pie Chart section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/* Recent works visibility */
	$wp_customize->add_setting( 'pixova_lite_works_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_works_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the works section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/* Testimonials visibility */
	$wp_customize->add_setting( 'pixova_lite_testimonials_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_testimonials_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the testimonials section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/* Team visibility */
	$wp_customize->add_setting( 'pixova_lite_team_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_team_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the team section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/* News visibility */
	$wp_customize->add_setting( 'pixova_lite_news_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_news_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the news section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/* Contact visibility */
	$wp_customize->add_setting( 'pixova_lite_contact_visibility', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => '1',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_contact_visibility', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Display the contact section ?', 'pixova-lite' ),
		'section' => 'pixova_lite_visibility_section',
	) ) );

	/***********************************************/
	/************** GENERAL OPTIONS  ***************/
	/***********************************************/

	$wp_customize->add_panel( 'pixova_lite_panel_general', array(
		'priority'       => 24,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme options', 'pixova-lite' ),
	) );

	/***********************************************/
	/************** General Site Settings  ***************/
	/***********************************************/

	$wp_customize->add_section( 'pixova_lite_general_section',
		array(
			'title'    => esc_html__( 'General', 'pixova-lite' ),
			'panel'    => 'pixova_lite_panel_general',
			'priority' => 1,
		)
	);

	/* COPYRIGHT */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_copyright_enable', array(
		'label'             => esc_html__( 'Enable theme copyright message in the footer?', 'pixova-lite' ),
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_copyright_enable', array(
		'type'        => 'epsilon-toggle',
		'label'       => esc_html__( 'Display theme copyright in the footer?', 'pixova-lite' ),
		'description' => esc_html__( 'By disabling this field, the theme copyright text & links will be removed from the footer', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
		'std'         => '1',
	) ) );

	$wp_customize->add_setting( 'pixova_lite_copyright', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => sprintf( '&copy; %s', esc_html__( 'Copyright 20', 'pixova-lite' ) . sprintf( '%s', date( 'y' ) ) . esc_html__( '. All Rights Reserved', 'pixova-lite' ) ),
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_copyright', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Copyright', 'pixova-lite' ),
		'description' => esc_html__( 'This is your copyright message. Will be displayed in the footer', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_copyright', array(
		'selector' => '#footer .footer-copyright .pixova-lite-footer-text-copyright',
	) );

	/* Enable Preloader */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_preloader_enabled', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'preloader_enabled',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_preloader_enabled', array(
		'type'        => 'radio',
		'choices'     => array(
			'preloader_enabled'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'preloader_disabled' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Enable Preloader ?', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
		'description' => esc_html__( 'Enable the LOADING message that is displayed when pages are loading ?', 'pixova-lite' ),
	) ) );

	/* Enable Site Animations */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_animations_enabled', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'animations_enabled',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_animations_enabled', array(
		'type'        => 'radio',
		'choices'     => array(
			'animations_enabled'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'animations_disabled' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Enable Section Animations ?', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
		'description' => esc_html__( 'When scrolling, elements are coming into view with a slide-in animation. By disabling this setting, the swooshing of elements will be canceled.', 'pixova-lite' ),
	) ) );

	#Breadcrumbs on single blog posts
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_enable_post_breadcrumbs', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'breadcrumbs_enabled',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_enable_post_breadcrumbs', array(
		'type'        => 'radio',
		'choices'     => array(
			'breadcrumbs_enabled'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'breadcrumbs_disabled' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Breadcrumbs on single blog posts', 'pixova-lite' ),
		'description' => esc_html__( 'This will disable the breadcrumbs', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
	) ) );

	# Default Blog Images :: Affects Sections / Section-News
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_enable_default_images', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'images_disabled',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_enable_default_images', array(
		'type'        => 'radio',
		'choices'     => array(
			'images_enabled'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'images_disabled' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Enable default blog images ?', 'pixova-lite' ),
		'description' => esc_html__( 'Disabling this will mean that when there is no featured image set, you will not have a placeholder.', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
	) ) );

	# Default Header Parallax Effect :: Affects Header Area
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_header_effect_enabled', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'header_effect_enabled',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_header_effect_enabled', array(
		'type'        => 'radio',
		'choices'     => array(
			'header_effect_enabled'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'header_effect_disabled' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Enable Parallax Header Fade-out Effect ?', 'pixova-lite' ),
		'description' => esc_html__( 'Disabling this, will remove the header parallax text fade-out effect.', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_section',
	) ) );

	/***********************************************/
	/************** Contact Details  ***************/
	/***********************************************/
	$wp_customize->add_section( 'pixova_lite_general_contact_section', array(
		'title'    => esc_html__( 'Contact Details', 'pixova-lite' ),
		'priority' => 3,
		'panel'    => 'pixova_lite_panel_contact',
	) );

	/* email */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_email', array(
		'sanitize_callback' => 'esc_attr',
		'default'           => esc_attr( 'contact@site.com' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_email', array(
		'label'       => esc_html__( 'Email', 'pixova-lite' ),
		'description' => esc_html__( 'Email address will be displayed on the left of the contact form. Updates in real time.', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_contact_section',
		'settings'    => 'pixova_lite_email',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_email', array(
		'selector' => '#contact .contact-info-details-email span',
	) );

	/* phone number */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_phone', array(
		'sanitize_callback' => 'pixova_lite_sanitize_number',
		'default'           => esc_attr( '0 332 548 954' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_phone', array(
		'label'       => esc_html__( 'Phone number', 'pixova-lite' ),
		'description' => esc_html__( 'Phone number will be displayed on the left of the contact form. Updates in real time.', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_contact_section',
		'settings'    => 'pixova_lite_phone',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_phone', array(
		'selector' => '#contact .contact-info-details-phone span',
	) );

	/* address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_address', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Street 221B Baker Street', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_address', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Address', 'pixova-lite' ),
		'description' => esc_html__( 'Street Address will be displayed on the left of the contact form. Updates in real time.', 'pixova-lite' ),
		'section'     => 'pixova_lite_general_contact_section',
		'settings'    => 'pixova_lite_address',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_address', array(
		'selector' => '#contact .contact-info-details.address span',
	) );

	/***********************************************/
	/************** Breadcrumb Settings  ***************/
	/***********************************************/

	$wp_customize->add_section( 'pixova_lite_blog_breadcrumb_section', array(
		'title'       => esc_html__( 'Breadcrumbs', 'pixova-lite' ),
		'description' => esc_html__( 'Various breadcrumb related settings, like: breadcrumb prefix, breadcrumb item separator & breadcrumb menu post category visibility setting.', 'pixova-lite' ),
		'panel'       => 'pixova_lite_panel_general',
	) );

	/* BreadCrumb Menu:  Prefix */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_blog_breadcrumb_menu_prefix', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'You are here', 'pixova-lite' ),
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_blog_breadcrumb_menu_prefix', array(
		'label'       => esc_html__( 'Text before the breadcrumbs menu', 'pixova-lite' ),
		'description' => esc_html__( 'Recommended: You are here', 'pixova-lite' ),
		'section'     => 'pixova_lite_blog_breadcrumb_section',
	) ) );

	/* BreadCrumb Menu:  separator */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_blog_breadcrumb_menu_separator', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'rarr',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_blog_breadcrumb_menu_separator', array(
		'type'        => 'select',
		'choices'     => array(
			'rarr'      => esc_html( '&rarr;' ),
			'middot'    => esc_html( '&middot;' ),
			'diez'      => esc_html( '&#35;' ),
			'ampersand' => esc_html( '&#38;' ),
		),
		'label'       => esc_html__( 'Separator to be used between breadcrumb items', 'pixova-lite' ),
		'description' => esc_html__( 'Select from predefined separators', 'pixova-lite' ),
		'section'     => 'pixova_lite_blog_breadcrumb_section',
	) ) );

	/* BreadCrumb Menu:  post category */
	$wp_customize->add_setting( 'pixova_lite_blog_breadcrumb_menu_post_category', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_blog_breadcrumb_menu_post_category', array(
		'type'        => 'epsilon-toggle',
		'label'       => esc_html__( 'Show post category ?', 'pixova-lite' ),
		'description' => esc_html__( 'Show the post category in the breadcrumb ?', 'pixova-lite' ),
		'section'     => 'pixova_lite_blog_breadcrumb_section',
	) ) );

	/************************************************/
	/***************** Related Posts ****************/
	/************************************************/
	$wp_customize->add_section( 'pixova_lite_blog_related_section', array(
		'title'       => esc_html__( 'Blog Settings', 'pixova-lite' ),
		'description' => esc_html__( 'Control various post settings from here. For a demo-like experience, we recommend you don\'t change these settings.', 'pixova-lite' ),
		'panel'       => 'pixova_lite_panel_general',
	) );

	/* Blog Page Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_blog_text_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Blog', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_blog_text_title', array(
		'label'   => esc_html__( 'Enter Archive(Blog) Page Title', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/* Blog Page Description */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_blog_text_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Maecenas eget nisl vitae nunc molestie elementum non id urna.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_blog_text_description', array(
		'label'   => esc_html__( 'Enter Archive(Blog) Page Description', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	# Related posts show
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_related_posts_enabled', array(
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
		'default'           => 'pixova_lite_related_posts_enable',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_related_posts_enabled', array(
		'type'        => 'radio',
		'choices'     => array(
			'pixova_lite_related_posts_enable'  => esc_html__( 'Enabled', 'pixova-lite' ),
			'pixova_lite_related_posts_disable' => esc_html__( 'Disabled', 'pixova-lite' ),
		),
		'label'       => esc_html__( 'Enable Related Posts Section?', 'pixova-lite' ),
		'description' => esc_html__( 'Disabling this, will remove the related posts box at the end of posts', 'pixova-lite' ),
		'section'     => 'pixova_lite_blog_related_section',
	) ) );

	/*  Prev / Next post */
	$wp_customize->add_setting( 'pixova_lite_enable_content_navigation', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
	) );

	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_enable_content_navigation', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Show prev/next links below posts?', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/*  Author Box */
	$wp_customize->add_setting( 'pixova_lite_enable_author_box', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
	) );

	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_enable_author_box', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Show author box below posts?', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/*  related posts title */
	$wp_customize->add_setting( 'pixova_lite_enable_related_title_blog_posts', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 0,
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_enable_related_title_blog_posts', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Posts title in the carousel ?', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/*  related posts date */
	$wp_customize->add_setting( 'pixova_lite_enable_related_date_blog_posts', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 0,
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_enable_related_date_blog_posts', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Carousel related posts date?', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/* Auto play carousel */
	$wp_customize->add_setting( 'pixova_lite_autoplay_blog_posts', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_autoplay_blog_posts', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Autoplay related carousel?', 'pixova-lite' ),
		'section' => 'pixova_lite_blog_related_section',
	) ) );

	/* Number of related posts to display at once  */
	$wp_customize->add_setting( 'pixova_lite_howmany_blog_posts', array(
		'sanitize_callback' => 'absint',
		'default'           => 3,
	) );
	$wp_customize->add_control( new Epsilon_Control_Slider( $wp_customize, 'pixova_lite_howmany_blog_posts', array(
		'label'       => esc_html__( 'How many blog posts to display in the carousel at once?', 'pixova-lite' ),
		'description' => esc_html__( 'No more than 4 posts at once;', 'pixova-lite' ),
		'choices'     => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		),
		'section'     => 'pixova_lite_blog_related_section',
		'default'     => 3,
	) ) );

	/* Display pagination ?  */
	$wp_customize->add_setting( 'pixova_lite_pagination_blog_posts', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 1,
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_pagination_blog_posts', array(
		'type'        => 'epsilon-toggle',
		'label'       => esc_html__( 'Carousel pagination controls?', 'pixova-lite' ),
		'description' => esc_html__( 'Will be displayed as navigation bullets', 'pixova-lite' ),
		'section'     => 'pixova_lite_blog_related_section',
	) ) );

	/************************************************/
	/******************* WooCommerce ****************/
	/************************************************/
	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_section( 'pixova_lite_woocommerce', array(
			'title'       => esc_html__( 'WooCommerce', 'pixova-lite' ),
			'description' => esc_html__( 'Control various for WooCommerce.', 'pixova-lite' ),
			'priority'    => 39,
		) );

		// Show Header Image?
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_show_header_image', array(
			'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
			'default'           => 'show',
		) ) );
		$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_woocommerce_show_header_image', array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Header Image?', 'pixova-lite' ),
			'description' => esc_html__( 'Select to show or not to show the header image on WooCommerce pages.', 'pixova-lite' ),
			'choices'     => array(
				'show' => esc_html__( 'Show', 'pixova-lite' ),
				'hide' => esc_html__( 'Hide', 'pixova-lite' ),
			),
			'section'     => 'pixova_lite_woocommerce',
		) ) );

		// Header Image
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_header_image', array(
			'sanitize_callback' => 'pixova_lite_sanitize_file_url',
			'default'           => esc_url( get_template_directory_uri() . '/layout/images/header-bg.jpg' ),
		) ) );
		$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_woocommerce_header_image', array(
			'label'           => __( 'Header Image', 'pixova-lite' ),
			'description'     => esc_html__( 'Select custom header image for WooCommerce pages.', 'pixova-lite' ),
			'section'         => 'pixova_lite_woocommerce',
			'active_callback' => 'is_woocommerce_show_header_image',
		) ) );

		// Title
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_title', array(
			'sanitize_callback' => 'wp_kses_post',
			'default'           => __( 'WooCommerce', 'pixova-lite' ),
		) ) );
		$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_woocommerce_title', array(
			'label'           => __( 'Title', 'pixova-lite' ),
			'description'     => esc_html__( 'Add the custom title for WooCommerce pages.', 'pixova-lite' ),
			'section'         => 'pixova_lite_woocommerce',
			'active_callback' => 'is_woocommerce_show_header_image',
		) ) );

		// Description
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_description', array(
			'sanitize_callback' => 'wp_kses_post',
			'default'           => esc_html__( 'We have the best products.', 'pixova-lite' ),
		) ) );
		$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_woocommerce_description', array(
			'label'           => __( 'Description', 'pixova-lite' ),
			'description'     => __( 'Add the custom description for WooCommerce pages.', 'pixova-lite' ),
			'section'         => 'pixova_lite_woocommerce',
			'active_callback' => 'is_woocommerce_show_header_image',
			'type'            => 'epsilon-text-editor',
		) ) );

		// Show Sidebar on Shop Page?
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_show_sidebar_on_shop_page', array(
			'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
			'default'           => 'show',
		) ) );
		$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_woocommerce_show_sidebar_on_shop_page', array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Show sidebar on Shop Page?', 'pixova-lite' ),
			'description' => esc_html__( 'Select to show or not to show the sidebar on WooCommerce Shop Page.', 'pixova-lite' ),
			'choices'     => array(
				'show' => esc_html__( 'Show', 'pixova-lite' ),
				'hide' => esc_html__( 'Hide', 'pixova-lite' ),
			),
			'section'     => 'pixova_lite_woocommerce',
		) ) );

		// Show Sidebar on Left or Right side?
		$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_woocommerce_show_sidebar_on_left_or_right_side', array(
			'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
			'default'           => 'left',
		) ) );
		$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_woocommerce_show_sidebar_on_left_or_right_side', array(
			'type'            => 'radio',
			'label'           => esc_html__( 'Show Sidebar on Left or Right side?', 'pixova-lite' ),
			'description'     => esc_html__( 'Select where you want to show the sidebar on WooCommerce Shop Page.', 'pixova-lite' ),
			'choices'         => array(
				'left'  => esc_html__( 'Left', 'pixova-lite' ),
				'right' => esc_html__( 'Right', 'pixova-lite' ),
			),
			'section'         => 'pixova_lite_woocommerce',
			'active_callback' => 'is_woocommerce_show_sidebar_on_shop_page',
		) ) );
	}// End if().

	// Front Page Sections
	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_frontpage_sections', array(
		'title'       => esc_html__( 'Front Page Sections', 'pixova-lite' ),
		'description' => esc_html__( 'Drag & drop to reorder Front Page sections', 'pixova-lite' ),
		'priority'    => 29,
	) ) );

	/***********************************************/
	/************** Intro  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_intro', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_intro' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'CTA Section (big bg. image)', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	/* Text Section */
	$wp_customize->add_section( 'pixova_lite_intro_text', array(
		'title' => esc_html__( 'CTA Text', 'pixova-lite' ),
		'panel' => 'pixova_lite_panel_intro',
	) );

	/* Main CTA title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_title_cta', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => __( 'WELCOME TO PIXOVA LITE', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );
	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_title_cta', array(
		'type'    => 'epsilon-text-editor',
		'label'   => esc_html__( 'Main CTA title', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_text',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_title_cta', array(
		'selector' => '#intro .intro-content .intro-cta-title',
	) );

	/* Main CTA text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_cta', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Free & Modern One-Page Parallax WordPress Theme', 'pixova-lite' ),
		'transport'         => 'refresh',
	) ) );
	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_cta', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Main CTA text', 'pixova-lite' ),
		'description' => esc_html__( 'This is your main attention grabber. Make the best of it.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_text',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_cta', array(
		'selector' => '#intro .intro-content .intro-title',
	) );

	/* Main CTA sub-text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_sub_cta', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => wp_kses_post( __( 'Your cool business headline here. You can even <u><strong>insert HTML here & images</strong></u>.<br> Lorem ipsum dolor sit amet lorem dolor sit amet.', 'pixova-lite' ) ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_sub_cta', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Main CTA sub-title ', 'pixova-lite' ),
		'description' => esc_html__( 'Most often main call to actions work best with a sub call to action that emphasises the main CTA.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_text',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_sub_cta', array(
		'selector' => '#intro .intro-content .intro-tagline',
	) );

	/* Outline Button Section */
	$wp_customize->add_section( 'pixova_lite_intro_outline_button', array(
		'title' => esc_html__( 'Outline Button', 'pixova-lite' ),
		'panel' => 'pixova_lite_panel_intro',
	) );

	/* Outline Button text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_outline_button_text', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'LEARN MORE', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_outline_button_text', array(
		'label'       => esc_html__( 'Button text ', 'pixova-lite' ),
		'description' => esc_html__( 'Text to be displayed on the button. Like BUY NOW or other Call To Action Text', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_outline_button',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_outline_button_text', array(
		'selector' => '#intro .intro-content .btn-cta-intro-outline',
	) );

	/* Outline Button URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_outline_button_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( '#about' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_outline_button_url', array(
		'label'       => esc_html__( 'Button URL ', 'pixova-lite' ),
		'description' => esc_html__( 'You can make this button link to a section on the homepage, by using the section id and a # in front of it', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_outline_button',
	) ) );

	# Outline Button Background color
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_outline_button_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => esc_attr( '#ffffff' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_intro_outline_button_color', array(
		'label'       => esc_html__( 'Button border color ', 'pixova-lite' ),
		'description' => esc_html__( 'Change the button border color from here.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_outline_button',
	) ) );

	# Outline Button Text color
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_outline_button_text_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => esc_attr( '#ffffff' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_intro_outline_button_text_color', array(
		'label'       => esc_html__( 'Button text color ', 'pixova-lite' ),
		'description' => esc_html__( 'Change the button text color from here.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_outline_button',
	) ) );

	/* Button Section */
	$wp_customize->add_section( 'pixova_lite_intro_button', array(
		'title' => esc_html__( 'Button', 'pixova-lite' ),
		'panel' => 'pixova_lite_panel_intro',
	) );

	/* Button text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_button_text', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'CONTACT US', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_button_text', array(
		'label'       => esc_html__( 'Button text ', 'pixova-lite' ),
		'description' => esc_html__( 'Text to be displayed on the button. Like BUY NOW or other Call To Action Text', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_button',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_button_text', array(
		'selector' => '#intro .intro-content .btn-cta-intro',
	) );

	/* Button URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_button_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( '#about' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_button_url', array(
		'label'       => esc_html__( 'Button URL ', 'pixova-lite' ),
		'description' => esc_html__( 'You can make this button link to a section on the homepage, by using the section id and a # in front of it', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_button',
	) ) );

	# Button Background color
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_button_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => esc_attr( '#f2c351' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_intro_button_color', array(
		'label'       => esc_html__( 'Button background color ', 'pixova-lite' ),
		'description' => esc_html__( 'Change the button background color from here.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_button',
	) ) );

	# Button Text color
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_button_text_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => esc_attr( '#ffffff' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_intro_button_text_color', array(
		'label'       => esc_html__( 'Button text color ', 'pixova-lite' ),
		'description' => esc_html__( 'Change the button text color from here.', 'pixova-lite' ),
		'section'     => 'pixova_lite_intro_button',
	) ) );

	/* Show what we do ? */
	$wp_customize->add_section( 'pixova_lite_show_what_we_do', array(
		'title' => esc_html__( 'Show what we do section ?', 'pixova-lite' ),
		'panel' => 'pixova_lite_panel_intro',
	) );

	/* What we do #1: change icon */
	$wp_customize->add_setting( 'pixova_lite_intro_what_we_do_enabled', array(
		'sanitize_callback' => 'pixova_lite_sanitize_checkbox',
		'default'           => 0,
	) );

	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'pixova_lite_intro_what_we_do_enabled', array(
		'type'    => 'epsilon-toggle',
		'label'   => esc_html__( 'Enable what we do section?', 'pixova-lite' ),
		'section' => 'pixova_lite_show_what_we_do',
		'default' => 0,
	) ) );

	/* What we do Section #1 */
	$wp_customize->add_section( 'pixova_lite_intro_what_we_do_1', array(
		'title'       => esc_html__( 'What we do #1', 'pixova-lite' ),
		'description' => esc_html__( 'Use the controls below to change the way the what we do icons & text look.', 'pixova-lite' ),
		'panel'       => 'pixova_lite_panel_intro',
	) );

	/* What we do #1: change icon */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_1_icon', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'fa fa-bold', 'pixova-lite' ),
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Icon_Picker( $wp_customize, 'pixova_lite_intro_what_we_do_1_icon', array(
		'type'    => 'epsilon-icon-picker',
		'label'   => esc_html__( 'Specify icon name', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_1',
		'icons'   => '',
	) ) );

	/* What we do #1: title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_1_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Web design', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_what_we_do_1_title', array(
		'label'   => esc_html__( 'What we do #1 title ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_1',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_1_title', array(
		'selector' => '.intro-services .intro-services .intro-service-title-1',
	) );

	/* What we do #1: description */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_1_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Lorem ipsum dolor sit amet. Lorem ipsum.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_what_we_do_1_description', array(
		'type'    => 'epsilon-text-editor',
		'label'   => esc_html__( 'What we do #1 description ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_1',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_1_description', array(
		'selector' => '.intro-services .intro-services .intro-service-text-1',
	) );

	/* What we do Section #2 */
	$wp_customize->add_section( 'pixova_lite_intro_what_we_do_2', array(
		'title'       => esc_html__( 'What we do #2', 'pixova-lite' ),
		'description' => esc_html__( 'Use the controls below to change the way the what we do icons & text look.', 'pixova-lite' ),
		'panel'       => 'pixova_lite_panel_intro',
	) );

	/* What we do #2: change icon */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_2_icon', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'fa fa-code', 'pixova-lite' ),
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Icon_Picker( $wp_customize, 'pixova_lite_intro_what_we_do_2_icon', array(
		'type'    => 'epsilon-icon-picker',
		'label'   => esc_html__( 'Specify icon name', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_2',
		'icons'   => '',
	) ) );

	/* What we do #2: title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_2_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Development', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_what_we_do_2_title', array(
		'label'   => esc_html__( 'What we do #2 title ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_2',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_2_title', array(
		'selector' => '.intro-services .intro-services .intro-service-title-2',
	) );

	/* What we do #2: description */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_2_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Lorem ipsum dolor sit amet. Lorem ipsum.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_what_we_do_2_description', array(
		'type'    => 'epsilon-text-editor',
		'label'   => esc_html__( 'What we do #2 description ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_2',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_2_description', array(
		'selector' => '.intro-services .intro-services .intro-service-text-2',
	) );

	/* What we do Section #3 */
	$wp_customize->add_section( 'pixova_lite_intro_what_we_do_3', array(
		'title'       => esc_html__( 'What we do #3', 'pixova-lite' ),
		'description' => esc_html__( 'Use the controls below to change the way the what we do icons & text look.', 'pixova-lite' ),
		'panel'       => 'pixova_lite_panel_intro',
	) );

	/* What we do #1: change icon */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_3_icon', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'fa fa-envelope', 'pixova-lite' ),
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Icon_Picker( $wp_customize, 'pixova_lite_intro_what_we_do_3_icon', array(
		'type'    => 'epsilon-icon-picker',
		'label'   => esc_html__( 'Specify icon name', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_3',
		'icons'   => '',
	) ) );

	/* What we do #3: title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_3_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Print design', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_intro_what_we_do_3_title', array(
		'label'   => esc_html__( 'What we do #3 title ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_3',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_3_title', array(
		'selector' => '.intro-services .intro-services .intro-service-title-3',
	) );

	/* What we do #3: description */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_intro_what_we_do_3_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Lorem ipsum dolor sit amet. Lorem ipsum.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_intro_what_we_do_3_description', array(
		'type'    => 'epsilon-text-editor',
		'label'   => esc_html__( 'What we do #3 description ', 'pixova-lite' ),
		'section' => 'pixova_lite_intro_what_we_do_3',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_intro_what_we_do_3_description', array(
		'selector' => '.intro-services .intro-services .intro-service-text-3',
	) );

	/***********************************************/
	/************** About Options  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_about', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_about' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Pie Chart Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_about_titles', array(
		'title'    => esc_html__( 'Section Titles', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'We build solutions for your everyday problems.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_about_section_title', array(
		'label'   => esc_html__( 'Section title', 'pixova-lite' ),
		'section' => 'pixova_lite_about_titles',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_title', array(
		'selector' => '#about .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'This is what we do in a nutshell', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_about_section_sub_title', array(
		'type'    => 'epsilon-text-editor',
		'label'   => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section' => 'pixova_lite_about_titles',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_sub_title', array(
		'selector' => '#about .section-sub-heading',
	) );

	$wp_customize->add_section( 'pixova_lite_about_section_text', array(
		'title'    => esc_html__( 'Section text', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* About textarea */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_textarea', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Creative ut tincidunt nibh, varius cursus nunc. Curabitur molestie, metus vel luctus euismod, mi libero laoreet odio, eu dapibus leo tortor sit amet purus. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_about_section_textarea', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Block of text', 'pixova-lite' ),
		'description' => esc_html__( 'This block accepts limited HTML. Accepted tags are: a, img, em, br & strong.', 'pixova-lite' ),
		'section'     => 'pixova_lite_about_section_text',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_textarea', array(
		'selector' => '#about .about-text',
	) );

	/* About blockquote */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_blockquote', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Erlich Bachman, Aviato', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_about_section_blockquote', array(
		'type'        => 'epsilon-text-editor',
		'label'       => esc_html__( 'Blockquote', 'pixova-lite' ),
		'description' => esc_html__( 'This block accepts limited HTML. Accepted tags are: a, img, em, br & strong.', 'pixova-lite' ),
		'section'     => 'pixova_lite_about_section_text',
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_blockquote', array(
		'selector' => '#about blockquote p',
	) );

	/* Section Chart # 1 */
	$wp_customize->add_section( 'pixova_lite_section_chart_1', array(
		'title'    => esc_html__( 'Section Chart #1', 'pixova-lite' ),
		'priority' => 2,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* Chart #1 Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_1_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Web design', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_about_section_chart_1_heading', array(
		'label'    => esc_html__( 'Heading for chart', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_1',
		'priority' => 0,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_chart_1_heading', array(
		'selector' => '#about .pixova_lite_chart_1 .pixova-heading',
	) );

	/* Chart #1 Settings */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_1_percentage', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '70',
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Slider( $wp_customize, 'pixova_lite_about_section_chart_1_percentage', array(
		'label'    => esc_html__( 'Chart Percentage', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_1',
		'choices'  => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
		'priority' => 1,
	) ) );

	/* Chart Bar Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_1_bar_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => pixova_lite_sanitize_hex_color( '#f2c351' ),
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_1_bar_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart bar color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_1',
		'priority' => 2,
	) ) );

	/* Chart Track Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_1_track_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#EEE',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_1_track_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart Track color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_1',
		'priority' => 3,
	) ) );

	/* Section Chart # 2 */
	$wp_customize->add_section( 'pixova_lite_section_chart_2', array(
		'title'    => esc_html__( 'Section Chart #2', 'pixova-lite' ),
		'priority' => 3,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* Chart #2 Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_2_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Web development', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_about_section_chart_2_heading', array(
		'label'    => esc_html__( 'Heading for chart', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_2',
		'priority' => 0,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_chart_2_heading', array(
		'selector' => '#about .pixova_lite_chart_2 .pixova-heading',
	) );

	/* Chart #2 Settings */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_2_percentage', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '90',
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Slider( $wp_customize, 'pixova_lite_about_section_chart_2_percentage', array(
		'label'    => esc_html__( 'Chart Percentage', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_2',
		'choices'  => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
		'priority' => 1,
	) ) );

	/* Chart Bar Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_2_bar_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#f2c351',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_2_bar_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart bar color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_2',
		'priority' => 2,
	) ) );

	/* Chart Track Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_2_track_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#EEE',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_2_track_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart Track color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_2',
		'priority' => 3,
	) ) );

	/* Section Chart #3 */
	$wp_customize->add_section( 'pixova_lite_section_chart_3', array(
		'title'    => esc_html__( 'Section Chart #3', 'pixova-lite' ),
		'priority' => 4,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* Chart #3 Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_3_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Print design', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_about_section_chart_3_heading', array(
		'label'    => esc_html__( 'Heading for chart', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_3',
		'priority' => 0,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_chart_3_heading', array(
		'selector' => '#about .pixova_lite_chart_3 .pixova-heading',
	) );

	/* Chart #3 Settings */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_3_percentage', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '90',
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Slider( $wp_customize, 'pixova_lite_about_section_chart_3_percentage', array(
		'label'    => esc_html__( 'Chart Percentage', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_3',
		'choices'  => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
		'priority' => 1,
	) ) );

	/* Chart Bar Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_3_bar_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#f2c351',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_3_bar_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart bar color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_3',
		'priority' => 2,
	) ) );

	/* Chart Track Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_3_track_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#EEE',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_3_track_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart Track color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_3',
		'priority' => 3,
	) ) );

	/* Section Chart #4 */
	$wp_customize->add_section( 'pixova_lite_section_chart_4', array(
		'title'    => esc_html__( 'Section Chart #4', 'pixova-lite' ),
		'priority' => 5,
		'panel'    => 'pixova_lite_panel_about',
	) );

	/* Chart #4 Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_4_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Graphic identity', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_about_section_chart_4_heading', array(
		'label'    => esc_html__( 'Heading for chart', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_4',
		'priority' => 0,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_about_section_chart_4_heading', array(
		'selector' => '#about .pixova_lite_chart_4 .pixova-heading',
	) );

	/* Chart #4 Settings */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_4_percentage', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '50',
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Slider( $wp_customize, 'pixova_lite_about_section_chart_4_percentage', array(
		'label'    => esc_html__( 'Chart Percentage', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_4',
		'choices'  => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
		'priority' => 1,
	) ) );

	/* Chart Bar Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_4_bar_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#f2c351',
	) ) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_4_bar_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart bar color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_4',
		'priority' => 2,
	) ) );

	/* Chart Track Color */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_about_section_chart_4_track_color', array(
		'sanitize_callback' => 'pixova_lite_sanitize_hex_color',
		'default'           => '#EEE',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pixova_lite_about_section_chart_4_track_color', array(
		'type'     => 'color',
		'label'    => esc_html__( 'Chart Track color', 'pixova-lite' ),
		'section'  => 'pixova_lite_section_chart_4',
		'priority' => 3,
	) ) );

	/***********************************************/
	/************** Recent Works  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_works', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_works' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Recent Works Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_work_titles', array(
		'title'    => esc_html__( 'Section Titles', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_works',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_work_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Recent works', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_work_section_title', array(
		'label'    => esc_html__( 'Section title', 'pixova-lite' ),
		'section'  => 'pixova_lite_work_titles',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_work_section_title', array(
		'selector' => '#works .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_work_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'It\'s show and tell time.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_work_section_sub_title', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section'  => 'pixova_lite_work_titles',
		'priority' => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_work_section_sub_title', array(
		'selector' => '#works .section-sub-heading',
	) );

	/* Recent works: project #1 section */
	$wp_customize->add_section( 'pixova_lite_works_project_1', array(
		'title'    => esc_html__( 'Project #1', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_works',
	) );

	/* Recent works: project #1 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_1_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => esc_url( get_template_directory_uri() . '/layout/images/recent-works/recent-works-1-270x426.jpg' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_1_image', array(
		'label'    => esc_html__( 'Project big image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_1',
		'priority' => 1,
	) ) );

	/* Recent works: project #1 logo */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_1_logo', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/logo1.png',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_1_logo', array(
		'label'    => esc_html__( 'Project logo image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_1',
		'priority' => 2,
	) ) );

	/* Recent works: project #1 URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_1_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://colorlib.com/wp/themes/pixova/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_works_project_1_url', array(
		'label'    => esc_html__( 'Project URL (enter project link here)', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_1',
		'priority' => 3,
	) ) );

	/* Recent works: project #2 section */
	$wp_customize->add_section( 'pixova_lite_works_project_2', array(
		'title'    => esc_html__( 'Project #2', 'pixova-lite' ),
		'priority' => 2,
		'panel'    => 'pixova_lite_panel_works',
	) );

	/* Recent works: project #2 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_2_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/recent-works-2-270x426.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_2_image', array(
		'label'    => esc_html__( 'Project big image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_2',
		'priority' => 2,
	) ) );

	/* Recent works: project #2 logo */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_2_logo', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/logo2.png',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_2_logo', array(
		'label'    => esc_html__( 'Project logo image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_2',
		'priority' => 2,
	) ) );

	/* Recent works: project #2 URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_2_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://colorlib.com/wp/themes/pixova/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_works_project_2_url', array(
		'label'    => esc_html__( 'Project URL (enter project link here)', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_2',
		'priority' => 3,
	) ) );

	/* Recent works: project #3 section */
	$wp_customize->add_section( 'pixova_lite_works_project_3', array(
		'title'    => esc_html__( 'Project #3', 'pixova-lite' ),
		'priority' => 3,
		'panel'    => 'pixova_lite_panel_works',
	) );

	/* Recent works: project #3 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_3_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/recent-works-3-270x426.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_3_image', array(
		'label'    => esc_html__( 'Project big image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_3',
		'priority' => 3,
	) ) );

	/* Recent works: project #3 logo */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_3_logo', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/logo3.png',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_3_logo', array(
		'label'    => esc_html__( 'Project logo image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_3',
		'priority' => 3,
	) ) );

	/* Recent works: project #3 URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_3_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://colorlib.com/wp/themes/pixova/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_works_project_3_url', array(
		'label'    => esc_html__( 'Project URL (enter project link here)', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_3',
		'priority' => 3,
	) ) );

	/* Recent works: project #4 section */
	$wp_customize->add_section( 'pixova_lite_works_project_4', array(
		'title'    => esc_html__( 'Project #4', 'pixova-lite' ),
		'priority' => 4,
		'panel'    => 'pixova_lite_panel_works',
	) );

	/* Recent works: project #4 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_4_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/recent-works-4-270x426.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_4_image', array(
		'label'    => esc_html__( 'Project big image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_4',
		'priority' => 4,
	) ) );

	/* Recent works: project #4 logo */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_4_logo', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/recent-works/logo4.png',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_works_project_4_logo', array(
		'label'    => esc_html__( 'Project logo image', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_4',
		'priority' => 4,
	) ) );

	/* Recent works: project #4 URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_works_project_4_url', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://colorlib.com/wp/themes/pixova/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_works_project_4_url', array(
		'label'    => esc_html__( 'Project URL (enter project link here)', 'pixova-lite' ),
		'section'  => 'pixova_lite_works_project_4',
		'priority' => 4,
	) ) );

	/***********************************************/
	/************** Testimonials  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_testimonials', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_testimonials' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Testimonials Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_testimonial_titles', array(
		'title'    => esc_html__( 'Section Titles', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Some words from our clients', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_section_title', array(
		'label'    => esc_html__( 'Section title', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_titles',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_testimonial_section_title', array(
		'selector' => '#testimonials .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'We don\'t like to brag, others do it for us.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_section_sub_title', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_titles',
		'priority' => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_testimonial_section_sub_title', array(
		'selector' => '#testimonials .section-sub-heading',
	) );

	/* Testimonials: testimonial #1 section */
	$wp_customize->add_section( 'pixova_lite_testimonial_1', array(
		'title'    => esc_html__( 'Testimonial #1', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Testimonials: testimonial #1 person name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_1_person_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Katie Parry - Hooli', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_1_person_name', array(
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_1',
		'priority' => 1,
	) ) );

	/* Testimonials: testimonial #1 text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_1_person_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixova has been an experience for a lifetime. I strongly  reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_1_person_description', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Testimonial person description', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_1',
		'priority' => 2,
	) ) );

	/* Testimonials: testimonial #1 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_1_person_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/testimonials/teammembru_burned-92x92.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_testimonial_1_person_image', array(
		'label'    => esc_html__( 'Testimonial person image', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_1',
		'priority' => 3,
	) ) );

	/* Testimonials: testimonial #2 section */
	$wp_customize->add_section( 'pixova_lite_testimonial_2', array(
		'title'    => esc_html__( 'Testimonial #2', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Testimonials: testimonial #2 person name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_2_person_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'John Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_2_person_name', array(
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_2',
		'priority' => 1,
	) ) );

	/* Testimonials: testimonial #2 text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_2_person_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixova has been an experience for a lifetime. I strongly  reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_2_person_description', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_2',
		'priority' => 2,
	) ) );

	/* Testimonials: testimonial #2 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_2_person_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/testimonials/teammembru_burned2-92x92.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_testimonial_2_person_image', array(
		'label'    => esc_html__( 'Testimonial person image', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_2',
		'priority' => 3,
	) ) );

	/* Testimonials: testimonial #3 section */
	$wp_customize->add_section( 'pixova_lite_testimonial_3', array(
		'title'    => esc_html__( 'Testimonial #3', 'pixova-lite' ),
		'priority' => 3,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Testimonials: testimonial #3 person name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_3_person_name', array(
		'sanitize_callback' => 'pixova_lite_sanitize_allowed_html',
		'default'           => esc_html__( 'Katie Parry - Hooli', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_3_person_name', array(
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_3',
		'priority' => 1,
	) ) );

	/* Testimonials: testimonial #3 text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_3_person_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixova has been an experience for a lifetime. I strongly  reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_3_person_description', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Testimonial person description', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_3',
		'priority' => 2,
	) ) );

	/* Testimonials: testimonial #3 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_3_person_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/testimonials/teammembru_burned-92x92.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_testimonial_3_person_image', array(
		'label'    => esc_html__( 'Testimonial person image', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_3',
		'priority' => 3,
	) ) );

	/* Testimonials: testimonial #4 section */
	$wp_customize->add_section( 'pixova_lite_testimonial_4', array(
		'title'    => esc_html__( 'Testimonial #4', 'pixova-lite' ),
		'priority' => 4,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Testimonials: testimonial #4 person name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_4_person_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Katie Parry - Hooli', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_4_person_name', array(
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_4',
		'priority' => 1,
	) ) );

	/* Testimonials: testimonial #4 text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_4_person_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixova has been an experience for a lifetime. I strongly  reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_4_person_description', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Testimonial person description', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_4',
		'priority' => 2,
	) ) );

	/* Testimonials: testimonial #4 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_4_person_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/testimonials/teammembru_burned-92x92.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_testimonial_4_person_image', array(
		'label'    => esc_html__( 'Testimonial person image', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_4',
		'priority' => 3,
	) ) );

	/* Testimonials: testimonial #5 section */
	$wp_customize->add_section( 'pixova_lite_testimonial_5', array(
		'title'    => esc_html__( 'Testimonial #5', 'pixova-lite' ),
		'priority' => 5,
		'panel'    => 'pixova_lite_panel_testimonials',
	) );

	/* Testimonials: testimonial #5 person name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_5_person_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Katie Parry - Hooli', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_testimonial_5_person_name', array(
		'label'    => esc_html__( 'Testimonial person name', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_5',
		'priority' => 1,
	) ) );

	/* Testimonials: testimonial #5 text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_5_person_description', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Working with Pixva has been an experience for a lifetime. I strongly  reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_testimonial_5_person_description', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Testimonial person description', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_5',
		'priority' => 2,
	) ) );

	/* Testimonials: testimonial #5 image */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_testimonial_5_person_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/testimonials/teammembru_burned-92x92.jpg',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_testimonial_5_person_image', array(
		'label'    => esc_html__( 'Testimonial person image', 'pixova-lite' ),
		'section'  => 'pixova_lite_testimonial_5',
		'priority' => 3,
	) ) );

	/***********************************************/
	/************** Latest News  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_news', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_news' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Latest News Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_news_general', array(
		'title'    => esc_html__( 'Section Options', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_news',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_news_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Latest news', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_news_section_title', array(
		'label'    => esc_html__( 'Section title', 'pixova-lite' ),
		'section'  => 'pixova_lite_news_general',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_news_section_title', array(
		'selector' => '#news .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_news_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Straight from our blog', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_news_section_sub_title', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section'  => 'pixova_lite_news_general',
		'priority' => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_news_section_sub_title', array(
		'selector' => '#news .section-sub-heading',
	) );

	/* Button Text */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_news_section_button_text', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( 'Visit our blog', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_news_section_button_text', array(
		'label'   => esc_html__( 'Button Text', 'pixova-lite' ),
		'section' => 'pixova_lite_news_general',
	) ) );

	/* Number of post per slide */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_news_section_no_posts_per_slide', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => esc_html__( '2', 'pixova-lite' ),
		'transport'         => 'refresh',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_news_section_no_posts_per_slide', array(
		'type'    => 'select',
		'choices' => array(
			'2' => esc_html( '2' ),
			'4' => esc_html( '4' ),
		),
		'label'   => esc_html__( 'Number of post per slide', 'pixova-lite' ),
		'section' => 'pixova_lite_news_general',
	) ) );

	/***********************************************/
	/************** Contact  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_contact', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_contact' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Contact Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_contact_titles', array(
		'title'    => esc_html__( 'Section titles', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_contact',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Contact us', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_contact_section_title', array(
		'label'    => esc_html__( 'Section title', 'pixova-lite' ),
		'section'  => 'pixova_lite_contact_titles',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_contact_section_title', array(
		'selector' => '#contact .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'And we\'ll reply in no time', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_contact_section_sub_title', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section'  => 'pixova_lite_contact_titles',
		'priority' => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_contact_section_sub_title', array(
		'selector' => '#contact .section-sub-heading',
	) );

	/* Address Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_first_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Address', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_contact_first_heading', array(
		'label'       => esc_html__( 'Left Heading 1', 'pixova-lite' ),
		'description' => esc_html__( 'This is the heading before the address on the Contact section. Default is Address', 'pixova-lite' ),
		'section'     => 'pixova_lite_contact_titles',
		'priority'    => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_contact_first_heading', array(
		'selector' => '#contact .pixova-contact-info h3.address',
	) );

	/* Customer Support Heading */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_second_heading', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Customer Support', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_contact_second_heading', array(
		'label'       => esc_html__( 'Left Heading 2', 'pixova-lite' ),
		'description' => esc_html__( 'This is the heading before the email and phone on the Contact section. Default is Customer Support', 'pixova-lite' ),
		'section'     => 'pixova_lite_contact_titles',
		'priority'    => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_contact_second_heading', array(
		'selector' => '#contact .pixova-contact-info h3.support',
	) );

	$wp_customize->add_section( 'pixova_lite_contact_cf7', array(
		'title'    => esc_html__( 'Contact forms', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_contact',
	) );

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) && is_plugin_active( 'pirate-forms/pirate-forms.php' ) ) {
		$contact_section_type = array(
			'contact-form-7' => esc_html__( 'Contact Form 7', 'pixova-lite' ),
			'pirate-forms'   => esc_html__( 'Pirate Forms', 'pixova-lite' ),
		);
	} elseif ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		$contact_section_type = array(
			'contact-form-7' => esc_html__( 'Contact Form 7', 'pixova-lite' ),
		);
	} elseif ( is_plugin_active( 'pirate-forms/pirate-forms.php' ) ) {
		$contact_section_type = array(
			'pirate-forms' => esc_html__( 'Pirate Forms', 'pixova-lite' ),
		);
	} else {
		$contact_section_type = false;
	}

	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_section_type', array(
		'default'           => 'contact-form-7',
		'sanitize_callback' => 'pixova_lite_sanitize_radio_buttons',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_contact_section_type', array(
		'section'         => 'pixova_lite_contact_cf7',
		'label'           => esc_html__( 'Select the type of Contact Form to show (Contact Form 7 or Pirate Forms)', 'pixova-lite' ),
		'type'            => 'radio',
		'priority'        => 1,
		'settings'        => 'pixova_lite_contact_section_type',
		'active_callback' => 'pixova_lite_active_callback_contact_section_type',
		'choices'         => $contact_section_type,
	) ) );

	/* Contact: contact form select */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_contact_section_cf7', array(
		'sanitize_callback' => 'pixova_lite_sanitize_number',
	) ) );

	$wp_customize->add_control( new Pixova_Lite_CF7_Custom_Control( $wp_customize, 'pixova_lite_contact_section_cf7', array(
		'label'           => esc_html__( 'Select the contact form you\'d like to display (powered by Contact Form 7)', 'pixova-lite' ),
		'section'         => 'pixova_lite_contact_cf7',
		'priority'        => 2,
		'type'            => 'pixova_lite_contact_form_7',
		'active_callback' => 'pixova_lite_active_callback_contact_section_cf7',
	) ) );

	/***********************************************/
	/************** Team  ***************/
	/***********************************************/

	$wp_customize->add_panel( new Pixova_Custom_Panel( $wp_customize, 'pixova_lite_panel_team', array(
		'priority'       => pixova_get_section_position( 'pixova_lite_panel_team' ),
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Team Section', 'pixova-lite' ),
		'panel'          => 'pixova_lite_frontpage_sections',
	) ) );

	$wp_customize->add_section( 'pixova_lite_team_titles', array(
		'title'    => esc_html__( 'Section Titles', 'pixova-lite' ),
		'priority' => 1,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Section Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_section_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'The team', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_section_title', array(
		'label'    => esc_html__( 'Section title', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_titles',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_section_title', array(
		'selector' => '#team .light-section-heading',
	) );

	/* Section Sub-Title */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_section_sub_title', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Meet the people that made it all happen.', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Epsilon_Control_Text_Editor( $wp_customize, 'pixova_lite_team_section_sub_title', array(
		'type'     => 'epsilon-text-editor',
		'label'    => esc_html__( 'Section sub-title', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_titles',
		'priority' => 2,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_section_sub_title', array(
		'selector' => '#team .section-sub-heading',
	) );

	/* Team: team member #1 section */
	$wp_customize->add_section( 'pixova_lite_team_member_1', array(
		'title'    => esc_html__( 'Team member #1', 'pixova-lite' ),
		'priority' => 2,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Team: team member #1 name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Angelina Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_name', array(
		'label'    => esc_html__( 'Team member #1 name', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_member_1_name', array(
		'selector' => '#team .pixova-lite-team-member-1 .pixova-team-member-name',
	) );

	/* Team: team member #1 picture */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/team/teammembru-150x150.jpg',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_team_member_1_image', array(
		'label'    => esc_html__( 'Team member #1 image', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 2,
	) ) );

	/* Team: team member #1 facebook */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_facebook', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'https://www.facebook.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_facebook', array(
		'label'    => esc_html__( 'Team member #1 Facebook URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 3,
	) ) );

	/* Team: team member #1 Dribbble */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_dribbble', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'http://www.dribbble.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_dribbble', array(
		'label'    => esc_html__( 'Team member #1 Dribbble URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 4,
	) ) );

	/* Team: team member #1 E-mail Address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_email', array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => sanitize_email( 'contact@site.com' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_email', array(
		'label'    => esc_html__( 'Team member #1 E-mail Address', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #1 Twitter URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_twitter', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://twitter.com/colorlib' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_twitter', array(
		'label'    => esc_html__( 'Team member #1 Twitter URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #1 LinkedIN URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_linkedin', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.linkedin.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_linkedin', array(
		'label'    => esc_html__( 'Team member #1 LinkedIN URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #1 Pinterest URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_pinterest', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://pinterest.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_pinterest', array(
		'label'    => esc_html__( 'Team member #1 Pinterest URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #1 Instagram URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_instagram', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.instagram.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_instagram', array(
		'label'    => esc_html__( 'Team member #1 Instagram URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #1 Google+ URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_1_googleplus', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://plus.google.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_1_googleplus', array(
		'label'    => esc_html__( 'Team member #1 Google+ URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_1',
		'priority' => 5,
	) ) );

	/* Team: team member #2 section */
	$wp_customize->add_section( 'pixova_lite_team_member_2', array(
		'title'    => esc_html__( 'Team member #2', 'pixova-lite' ),
		'priority' => 2,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Team: team member #2 name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'John Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_name', array(
		'label'    => esc_html__( 'Team member #2 name', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_member_2_name', array(
		'selector' => '#team .pixova-lite-team-member-2 .pixova-team-member-name',
	) );

	/* Team: team member #2 picture */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/team/teammembru2-150x150.jpg',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_team_member_2_image', array(
		'label'    => esc_html__( 'Team member #2 image', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 2,
	) ) );

	/* Team: team member #2 facebook */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_facebook', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'https://www.facebook.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_facebook', array(
		'label'    => esc_html__( 'Team member #2 Facebook URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 3,
	) ) );

	/* Team: team member #2 Dribbble */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_dribbble', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'http://www.dribbble.com/madalin.duca/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_dribbble', array(
		'label'    => esc_html__( 'Team member #2 Dribbble URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 4,
	) ) );

	/* Team: team member #2 E-mail Address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_email', array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => sanitize_email( 'contact@site.com' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_email', array(
		'label'    => esc_html__( 'Team member #2 Email', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #2 Twitter URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_twitter', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://twitter.com/colorlib' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_twitter', array(
		'label'    => esc_html__( 'Team member #2 Twitter URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #2 LinkedIN URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_linkedin', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.linkedin.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_linkedin', array(
		'label'    => esc_html__( 'Team member #2 LinkedIN URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #2 Pinterest URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_pinterest', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://pinterest.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_pinterest', array(
		'label'    => esc_html__( 'Team member #2 Pinterest URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #2 Instagram URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_instagram', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.instagram.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_instagram', array(
		'label'    => esc_html__( 'Team member #2 Instagram URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #2 Google+ URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_2_googleplus', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://plus.google.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_2_googleplus', array(
		'label'    => esc_html__( 'Team member #2 Google+ URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_2',
		'priority' => 5,
	) ) );

	/* Team: team member #3 section */
	$wp_customize->add_section( 'pixova_lite_team_member_3', array(
		'title'    => esc_html__( 'Team member #3', 'pixova-lite' ),
		'priority' => 3,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Team: team member #3 name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Angelina Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_name', array(
		'label'    => esc_html__( 'Team member #3 name', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_member_3_name', array(
		'selector' => '#team .pixova-lite-team-member-3 .pixova-team-member-name',
	) );

	/* Team: team member #3 picture */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/team/teammembru3-150x150.jpg',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_team_member_3_image', array(
		'label'    => esc_html__( 'Team member #3 image', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 2,
	) ) );

	/* Team: team member #3 facebook */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_facebook', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'https://www.facebook.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_facebook', array(
		'label'    => esc_html__( 'Team member #3 Facebook URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 3,
	) ) );

	/* Team: team member #3 Dribbble */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_dribbble', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'http://www.dribbble.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_dribbble', array(
		'label'    => esc_html__( 'Team member #3 Dribbble URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 4,
	) ) );

	/* Team: team member #3 E-mail Address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_email', array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => sanitize_email( 'contact@site.com' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_email', array(
		'label'    => esc_html__( 'Team member #3 E-mail Address', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #3 Twitter URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_twitter', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://twitter.com/colorlib' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_twitter', array(
		'label'    => esc_html__( 'Team member #3 Twitter URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #3 LinkedIN URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_linkedin', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.linkedin.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_linkedin', array(
		'label'    => esc_html__( 'Team member #3 LinkedIN URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #3 Pinterest URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_pinterest', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://pinterest.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_pinterest', array(
		'label'    => esc_html__( 'Team member #3 Pinterest URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #3 Instagram URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_instagram', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.instagram.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_instagram', array(
		'label'    => esc_html__( 'Team member #3 Instagram URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #3 Google+ URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_3_googleplus', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://plus.google.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_3_googleplus', array(
		'label'    => esc_html__( 'Team member #3 Google+ URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_3',
		'priority' => 5,
	) ) );

	/* Team: team member #4 section */
	$wp_customize->add_section( 'pixova_lite_team_member_4', array(
		'title'    => esc_html__( 'Team member #4', 'pixova-lite' ),
		'priority' => 4,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Team: team member #4 name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'Angelina Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_name', array(
		'label'    => esc_html__( 'Team member #4 name', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_member_4_name', array(
		'selector' => '#team .pixova-lite-team-member-4 .pixova-team-member-name',
	) );

	/* Team: team member #4 picture */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => get_template_directory_uri() . '/layout/images/team/teammembru4-150x150.jpg',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_team_member_4_image', array(
		'label'    => esc_html__( 'Team member #4 image', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 2,
	) ) );

	/* Team: team member #4 facebook */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_facebook', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'https://www.facebook.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_facebook', array(
		'label'    => esc_html__( 'Team member #4 Facebook URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 3,
	) ) );

	/* Team: team member #4 Dribbble */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_dribbble', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'http://www.dribbble.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_dribbble', array(
		'label'    => esc_html__( 'Team member #4 Dribbble URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 4,
	) ) );

	/* Team: team member #4 E-mail Address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_email', array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => sanitize_email( 'contact@site.com' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_email', array(
		'label'    => esc_html__( 'Team member #4 E-mail Address', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #4 Twitter URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_twitter', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://twitter.com/colorlib' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_twitter', array(
		'label'    => esc_html__( 'Team member #4 Twitter URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #4 LinkedIN URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_linkedin', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.linkedin.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_linkedin', array(
		'label'    => esc_html__( 'Team member #4 LinkedIN URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #4 Pinterest URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_pinterest', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://pinterest.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_pinterest', array(
		'label'    => esc_html__( 'Team member #4 Pinterest URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #4 Instagram URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_instagram', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.instagram.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_instagram', array(
		'label'    => esc_html__( 'Team member #4 Instagram URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #4 Google+ URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_4_googleplus', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://plus.google.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_4_googleplus', array(
		'label'    => esc_html__( 'Team member #4 Google+ URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_4',
		'priority' => 5,
	) ) );

	/* Team: team member #5 section */
	$wp_customize->add_section( 'pixova_lite_team_member_5', array(
		'title'    => esc_html__( 'Team member #5', 'pixova-lite' ),
		'priority' => 5,
		'panel'    => 'pixova_lite_panel_team',
	) );

	/* Team: team member #5 name */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_name', array(
		'sanitize_callback' => 'wp_kses_post',
		'default'           => esc_html__( 'John Doe', 'pixova-lite' ),
		'transport'         => 'postMessage',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_name', array(
		'label'    => esc_html__( 'Team member #5 name', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 1,
	) ) );
	$wp_customize->selective_refresh->add_partial( 'pixova_lite_team_member_5_name', array(
		'selector' => '#team .pixova-lite-team-member-5 .pixova-team-member-name',
	) );

	/* Team: team member #5 picture */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_image', array(
		'sanitize_callback' => 'pixova_lite_sanitize_file_url',
		'default'           => '',
	) ) );
	$wp_customize->add_control( new Pixova_Custom_Upload( $wp_customize, 'pixova_lite_team_member_5_image', array(
		'label'    => esc_html__( 'Team member #5 image', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 2,
	) ) );

	/* Team: team member #5 facebook */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_facebook', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'https://www.facebook.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_facebook', array(
		'label'    => esc_html__( 'Team member #5 Facebook URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 3,
	) ) );

	/* Team: team member #5 Dribbble */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_dribbble', array(
		'sanitize_callback' => 'esc_url',
		'default'           => 'http://www.dribbble.com/colorlib/',
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_dribbble', array(
		'label'    => esc_html__( 'Team member #5 Dribbble URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 4,
	) ) );

	/* Team: team member #5 E-mail Address */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_email', array(
		'sanitize_callback' => 'sanitize_email',
		'default'           => sanitize_email( 'contact@site.com' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_email', array(
		'label'    => esc_html__( 'Team member #5 E-mail Address', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	/* Team: team member #5 Twitter URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_twitter', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://twitter.com/colorlib' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_twitter', array(
		'label'    => esc_html__( 'Team member #5 Twitter URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	/* Team: team member #5 LinkedIN URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_linkedin', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.linkedin.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_linkedin', array(
		'label'    => esc_html__( 'Team member #5 LinkedIN URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	/* Team: team member #5 Pinterest URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_pinterest', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://pinterest.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_pinterest', array(
		'label'    => esc_html__( 'Team member #5 Pinterest URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	/* Team: team member #5 Instagram URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_instagram', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://www.instagram.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_instagram', array(
		'label'    => esc_html__( 'Team member #5 Instagram URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	/* Team: team member #5 Google+ URL */
	$wp_customize->add_setting( new Pixova_Custom_Setting( $wp_customize, 'pixova_lite_team_member_5_googleplus', array(
		'sanitize_callback' => 'esc_url',
		'default'           => esc_url( 'https://plus.google.com/' ),
	) ) );

	$wp_customize->add_control( new Pixova_Custom_Control( $wp_customize, 'pixova_lite_team_member_5_googleplus', array(
		'label'    => esc_html__( 'Team member #5 Google+ URL', 'pixova-lite' ),
		'section'  => 'pixova_lite_team_member_5',
		'priority' => 5,
	) ) );

	// Typography
	$wp_customize->add_panel( 'pixova_lite_typography_section', array(
		'title'    => esc_html__( 'Typography', 'pixova-lite' ),
		'priority' => 25,
	) );
	$wp_customize->add_section( 'pixova_lite_typography_headings', array(
		'title'    => esc_html__( 'Content', 'pixova-lite' ),
		'priority' => 25,
		'panel'    => 'pixova_lite_typography_section',
	) );
	$wp_customize->add_section( 'pixova_lite_typography_sections', array(
		'title'    => esc_html__( 'Sections', 'pixova-lite' ),
		'priority' => 25,
		'panel'    => 'pixova_lite_typography_section',
	) );

	$wp_customize->add_setting( 'pixova_lite_heading_1', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_1', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 1', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h1',
		),
		'font_defaults' => array(
			'font-size'      => '36',
			'line-height'    => '44',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_heading_2', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_2', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 2', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h2',
		),
		'font_defaults' => array(
			'font-size'      => '32',
			'line-height'    => '40',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_heading_3', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_3', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 3', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h3',
		),
		'font_defaults' => array(
			'font-size'      => '28',
			'line-height'    => '36',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_heading_4', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_4', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 4', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h4',
		),
		'font_defaults' => array(
			'font-size'      => '24',
			'line-height'    => '32',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_heading_5', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_5', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 5', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h5',
		),
		'font_defaults' => array(
			'font-size'      => '20',
			'line-height'    => '28',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_heading_6', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_heading_6', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Heading 6', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content h6',
		),
		'font_defaults' => array(
			'font-size'      => '18',
			'line-height'    => '26',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_paragraph', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_paragraph', array(
		'section'       => 'pixova_lite_typography_headings',
		'label'         => esc_html__( 'Paragraph', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.entry-content p',
		),
		'font_defaults' => array(
			'font-size'      => '16',
			'line-height'    => '28',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_section_title_typography', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_section_title_typography', array(
		'section'       => 'pixova_lite_typography_sections',
		'label'         => esc_html__( 'Section Title', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.section-heading h2',
		),
		'font_defaults' => array(
			'font-size'      => '30',
			'line-height'    => '42',
			'letter-spacing' => '0',
			'font-family'    => 'Poppins',
		),
	) ) );

	$wp_customize->add_setting( 'pixova_lite_section_subtitle_typography', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( new Epsilon_Control_Typography( $wp_customize, 'pixova_lite_section_subtitle_typography', array(
		'section'       => 'pixova_lite_typography_sections',
		'label'         => esc_html__( 'Section Subtitle', 'pixova-lite' ),
		'stylesheet'    => 'pixova-lite-min-style',
		'choices'       => array(
			'font-family',
			'font-weight',
			'font-style',
			'font-size',
			'line-height',
			'letter-spacing',
		),
		'selectors'     => array(
			'.section-heading .section-sub-heading',
		),
		'font_defaults' => array(
			'font-size'      => '16',
			'line-height'    => '23',
			'letter-spacing' => '0',
			'font-family'    => 'Roboto',
		),
	) ) );

	// Colors
	$wp_customize->add_section( 'pixova_lite_colors', array(
		'title'    => esc_html__( 'Color Schemes', 'pixova-lite' ),
		'priority' => 30,
	) );
	$wp_customize->add_setting( 'pixova_lite_color_scheme', array(
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
		'default'           => 'default',
	) );

	$wp_customize->add_control( new Epsilon_Control_Color_Scheme( $wp_customize, 'pixova_lite_color_scheme', array(
		'label'    => esc_html__( 'Color Schemes', 'pixova-lite' ),
		'type'     => 'epsilon-color-scheme',
		'priority' => 0,
		'default'  => 'yellow',
		'section'  => 'pixova_lite_colors',
		'choices'  => array(
			array(
				'id'     => 'yellow',
				'name'   => 'Default',
				'colors' => array(
					'pixova_lite_accent_color'           => '#ffce55',
					'pixova_lite_heading_color'          => '#222533',
					'pixova_lite_text_color'             => '#777777',
					'pixova_lite_hover_color'            => '#ffce55',
					'pixova_lite_footer_bg_color'        => '#1f1f1f',
					'pixova_lite_footer_widget_bg_color' => '#313233',
				),
			),
			array(
				'id'     => 'pallet-1',
				'name'   => 'Pallet 1',
				'colors' => array(
					'pixova_lite_accent_color'           => '#ff004f',
					'pixova_lite_heading_color'          => '#545454',
					'pixova_lite_text_color'             => '#8c9597',
					'pixova_lite_hover_color'            => '#482c54',
					'pixova_lite_footer_bg_color'        => '#1f1f1f',
					'pixova_lite_footer_widget_bg_color' => '#313233',
				),
			),
			array(
				'id'     => 'pallet-2',
				'name'   => 'Pallet 2',
				'colors' => array(
					'pixova_lite_accent_color'           => '#f66f6d',
					'pixova_lite_heading_color'          => '#545454',
					'pixova_lite_text_color'             => '#8c9597',
					'pixova_lite_hover_color'            => '#195962',
					'pixova_lite_footer_bg_color'        => '#1f1f1f',
					'pixova_lite_footer_widget_bg_color' => '#313233',
				),
			),
			array(
				'id'     => 'pallet-3',
				'name'   => 'Pallet 3',
				'colors' => array(
					'pixova_lite_accent_color'           => '#6ebbdc',
					'pixova_lite_heading_color'          => '#545454',
					'pixova_lite_text_color'             => '#8c9597',
					'pixova_lite_hover_color'            => '#2e3d51',
					'pixova_lite_footer_bg_color'        => '#1f1f1f',
					'pixova_lite_footer_widget_bg_color' => '#313233',
				),
			),
			array(
				'id'     => 'pallet-4',
				'name'   => 'Pallet 4',
				'colors' => array(
					'pixova_lite_accent_color'           => '#507fe2',
					'pixova_lite_heading_color'          => '#545454',
					'pixova_lite_text_color'             => '#8c9597',
					'pixova_lite_hover_color'            => '#1acdcb',
					'pixova_lite_footer_bg_color'        => '#1f1f1f',
					'pixova_lite_footer_widget_bg_color' => '#313233',
				),
			),
		),
	) ) );

}

add_action( 'customize_register', 'pixova_lite_customize_register' );

if ( ! function_exists( 'is_woocommerce_show_header_image' ) ) {
	function is_woocommerce_show_header_image() {
		if ( 'show' == get_theme_mod( 'pixova_lite_woocommerce_show_header_image', 'show' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'is_woocommerce_show_sidebar_on_shop_page' ) ) {
	function is_woocommerce_show_sidebar_on_shop_page() {
		if ( 'show' == get_theme_mod( 'pixova_lite_woocommerce_show_sidebar_on_shop_page', 'show' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'pixova_lite_active_callback_contact_section_type' ) ) {
	function pixova_lite_active_callback_contact_section_type() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( is_plugin_active( 'pirate-forms/pirate-forms.php' ) || is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'pixova_lite_active_callback_contact_section_cf7' ) ) {
	function pixova_lite_active_callback_contact_section_cf7( $control ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		if ( 'contact-form-7' == $control->manager->get_setting( 'pixova_lite_contact_section_type' )->value() && is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'pixova_lite_customize_preview_js' ) ) {
	function pixova_lite_customize_preview_js() {
		wp_enqueue_script( 'pixova_lite_customizer', get_template_directory_uri() . '/layout/js/customizer/customizer.js', array(
			'customize-preview',
			'smooth-scroll-js',
		), '1.0', true );
	}

	add_action( 'customize_preview_init', 'pixova_lite_customize_preview_js' );
}

function pixova_lite_customizer_js_load() {

	wp_enqueue_style( 'pixova-customizer', get_template_directory_uri() . '/layout/css/customizer.css' );

	wp_enqueue_script( 'pixova_lite_customizer_script', get_template_directory_uri() . '/layout/js/customizer.js', array( 'customize-controls' ), '1.0', true );

	$pioxva_customizer                       = array();
	$pioxva_customizer['ajax_url']           = admin_url( 'admin-ajax.php' );
	$pioxva_customizer['template_directory'] = get_template_directory_uri();
	wp_localize_script( 'pixova_lite_customizer_script', 'PixovaCustomizer', $pioxva_customizer );

}

add_action( 'customize_controls_enqueue_scripts', 'pixova_lite_customizer_js_load' );


if ( ! function_exists( 'pixova_lite_sanitize_radio_buttons' ) ) {
	/**
	 * Simple function to validate choices from radio buttons
	 *
	 * @param $input
	 *
	 * @return string
	 */
	function pixova_lite_sanitize_radio_buttons( $input, $setting ) {

		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );

		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}

function pixova_lite_sanitize_pro_version( $input ) {
	return force_balance_tags( $input );
}

function pixova_lite_sanitize_number( $input ) {
	return force_balance_tags( $input );
}

function pixova_lite_sanitize_file_url( $url ) {

	$output = '';

	$filetype = wp_check_filetype( $url );
	if ( $filetype['ext'] ) {
		$output = esc_url( $url );
	}

	return $output;
}

function pixova_lite_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

function pixova_lite_sanitize_checkbox( $value ) {
	if ( 1 == $value ) {
		return 1;
	} else {
		return 0;
	}
}

function pixova_lite_sanitize_allowed_html( $value ) {

	return wp_kses( $value, array(
		'a'      => array(
			'href'  => array(),
			'title' => array(),
		),
		'img'    => array(
			'alt'   => array(),
			'title' => array(),
			'src'   => array(),
			'class' => array(),
			'id'    => array(),
		),
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
	) );

}

/**
 *  Customizer CSS
 */
if ( ! function_exists( 'pixova_lite_customizer_css' ) ) {
	function pixova_lite_customizer_css() {
		$pixova_lite_intro_button_color      = get_theme_mod( 'pixova_lite_intro_button_color' );
		$pixova_lite_intro_button_text_color = get_theme_mod( 'pixova_lite_intro_button_text_color' );

		$pixova_lite_intro_outline_button_color      = get_theme_mod( 'pixova_lite_intro_outline_button_color' );
		$pixova_lite_intro_outline_button_text_color = get_theme_mod( 'pixova_lite_intro_outline_button_text_color' );

		$output = '';

		$output .= '<style type="text/css">';
		$output .= $pixova_lite_intro_button_color ? 'body .btn-cta-intro {background-color: ' . esc_attr( $pixova_lite_intro_button_color ) . ';}' : '';
		$output .= $pixova_lite_intro_button_text_color ? 'body .btn-cta-intro {color: ' . esc_attr( $pixova_lite_intro_button_text_color ) . ';}' : '';
		$output .= $pixova_lite_intro_outline_button_color ? 'body .btn-cta-intro-outline {border-color: ' . esc_attr( $pixova_lite_intro_outline_button_color ) . ';}' : '';
		$output .= $pixova_lite_intro_outline_button_text_color ? 'body .btn-cta-intro-outline {color: ' . esc_attr( $pixova_lite_intro_outline_button_text_color ) . ';}' : '';
		$output .= '</style>';

		echo $output;
	}

	add_action( 'wp_head', 'pixova_lite_customizer_css' );
}

// Ajax for sections ordering
add_action( 'wp_ajax_pixova_order_sections', 'pixova_order_sections' );
function pixova_order_sections() {
	if ( isset( $_POST['sections'] ) ) {
		set_theme_mod( 'pixova_frontpage_sections', $_POST['sections'] );
		echo 'succes';
	}
	wp_die(); // this is required to terminate immediately and return a proper response
}

if ( ! function_exists( 'pixova_get_sections_position' ) ) {
	function pixova_get_sections_position() {
		$defaults = array(
			'pixova_lite_panel_intro',
			'pixova_lite_panel_about',
			'pixova_lite_panel_works',
			'pixova_lite_panel_testimonials',
			'pixova_lite_panel_news',
			'pixova_lite_panel_team',
			'pixova_lite_panel_contact',
		);
		$sections = get_theme_mod( 'pixova_frontpage_sections', $defaults );

		return $sections;
	}
}
if ( ! function_exists( 'pixova_get_section_position' ) ) {
	function pixova_get_section_position( $key ) {
		$sections = pixova_get_sections_position();
		$position = array_search( $key, $sections );
		$return   = ( $position + 1 ) * 10;

		return $return;
	}
}
