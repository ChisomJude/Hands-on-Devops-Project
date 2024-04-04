<?php

if ( ! function_exists( 'pixova_lite_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Pixova Lite 1.0.0
	 */
	function pixova_lite_theme_setup() {

		/*
        * Using this feature you can set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
        * @see http://codex.wordpress.org/Content_Width
        */
		if ( ! isset( $content_width ) ) {
			$content_width = 1140;
		}

		/**
		 * Custom Header Support
		 */

		$args = array(
			'default-image'      => get_template_directory_uri() . '/layout/images/header-bg.jpg',
			'default-text-color' => '#000',
			'width'              => 1920,
			'height'             => 1080,
			'flex-height'        => true,
			'video'              => true,
		);

		add_theme_support( 'custom-header', $args );

		/**
		 * Jetpack support
		 */
		require get_template_directory() . '/inc/jetpack.php';

		/**
		 * Custom functions that act independently of the theme templates.
		 */
		require get_template_directory() . '/inc/extras.php';
		require get_template_directory() . '/inc/components/breadcrumbs/class-pixova-lite-breadcrumbs.php';
		require get_template_directory() . '/inc/components/related-posts/class-pixova-lite-related-posts.php';

		/**
		 * Customizer additions.
		 */
		require get_template_directory() . '/inc/class-pixova-lite-helper.php';
		require get_template_directory() . '/inc/customizer/class-pixova-custom-panel.php';
		require get_template_directory() . '/inc/customizer/class-pixova-custom-control.php';
		require get_template_directory() . '/inc/customizer/class-pixova-custom-setting.php';
		require get_template_directory() . '/inc/customizer/class-pixova-custom-upload.php';
		require get_template_directory() . '/inc/customizer.php';
		require get_template_directory() . '/inc/customizer/class-pixova-lite-cf7-custom-control.php';
		require get_template_directory() . '/inc/customizer/class-pixova-lite-number-custom-control.php';

		/**
		 * Sidebars
		 */
		require get_template_directory() . '/sidebars/sidebars.php';

		/**
		 * Widgets
		 */
		require get_template_directory() . '/widgets/class-pixova-lite-widget-about.php';
		require get_template_directory() . '/widgets/class-pixova-lite-widget-latest-posts.php';
		require get_template_directory() . '/widgets/class-pixova-lite-widget-social-media.php';

		/**
		 *  Next compatible
		 */
		require get_template_directory() . '/inc/next-compatible.php';

		/**
		 *  Back compatible
		 */
		require get_template_directory() . '/inc/back-compatible.php';

		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
		load_theme_textdomain( 'pixova-lite', get_template_directory() . '/languages/' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
		add_editor_style( array( 'layout/css/editor-style.min.css', 'layout/css/font-awesome.min.css', pixova_lite_fonts_url() ) );

		/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
		add_theme_support( 'title-tag' );

		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'   => __( 'Header Menu', 'pixova-lite' ),
				'secondary' => __( 'Footer Menu', 'pixova-lite' ),
			)
		);

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'pixova_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
         * Add WooCommerce theme support
         */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/*
         * Add image sizes
         * @link http://codex.wordpress.org/Function_Reference/add_image_size
         */
		add_image_size( 'pixova-lite-project-slider-logo-image', 187, 35, true );
		add_image_size( 'pixova-lite-homepage-blog-posts', 250, 250, true );
		add_image_size( 'pixova-lite-featured-blog-image', 750, 250, true );
		add_image_size( 'pixova-lite-related-posts',  600, 450, true );
		add_image_size( 'pixova-lite-recent-works-image', 285, 450, true );

		/*
         * Add selective refresh
         */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*******************************************/
		/*************  Welcome screen *************/
		/*******************************************/

		if ( is_admin() ) {

			global $pixova_required_actions, $pixova_recommended_plugins;
			require get_template_directory() . '/inc/libraries/class-pixova-notify-system.php';
			require get_template_directory() . '/inc/libraries/welcome-screen/class-epsilon-welcome-screen.php';

			$pixova_recommended_plugins = array(
				'kiwi-social-share'        => array(
					'recommended' => false,
				),
				'modula-best-grid-gallery' => array(
					'recommended' => true,
				),
				'fancybox-for-wordpress'   => array(
					'recommended' => false,
				),
				'simple-custom-post-order' => array(
					'recommended' => false,
				),
			);

			/*
             * id - unique id; required
             * title
             * description
             * check - check for plugins (if installed)
             * plugin_slug - the plugin's slug (used for installing the plugin)
             *
             */
			$pixova_required_actions = array(
				array(
					'id'          => 'pixova-lite-req-ac-install-contact-forms',
					'title'       => esc_html__( 'Install Contact Form 7' ,'pixova-lite' ),
					'description' => esc_html__( 'In the next updates, Pixova Lite\'s default contact form will be removed. Please make sure you install the Pirate Forms plugin to keep your site updated, and experience a smooth transition to the latest version.','pixova-lite' ),
					'check'       => Pixova_Notify_System::has_plugin( 'contact-form-7' ),
					'plugin_slug' => 'contact-form-7',
				),
				array(
					'id'          => 'pixova-lite-import-demo-content',
					'title'       => esc_html__( 'Add sample content', 'pixova-lite' ),
					'description' => esc_html__( 'Clicking the button below will add content and set static front page to your WordPress installation. Click advanced to customize the import process.', 'pixova-lite' ),
					'help'        => array( 'Epsilon_Welcome_Screen', 'demo_content_html' ),
					'check'       => Pixova_Notify_System::check_for_content(),
				),
			);

			if ( is_customize_preview() ) {
				$url                                = 'themes.php?page=%1$s-welcome&tab=%2$s';
				$pixova_required_actions[1]['help'] = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'pixova-lite', 'recommended-actions' ) ) ) . '">' . __( 'Import Demo Content', 'pixova-lite' ) . '</a>';
			}

			Epsilon_Welcome_Screen::get_instance(
				$config = array(
					'theme-name' => 'Pixova Lite',
					'theme-slug' => 'pixova-lite',
					'actions'    => $pixova_required_actions,
					'plugins'    => $pixova_recommended_plugins,
					'edd'        => false,
				)
			);

		}// End if().

	} // function pixova_lite_theme_setup
	add_action( 'after_setup_theme', 'pixova_lite_theme_setup', 9 );
} // End if().

if ( ! function_exists( 'pixova_lite_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 *
	 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
	 *
	 * @since Pixova Lite 1.0.0
	 */

	function pixova_lite_enqueue_scripts() {

		// Bootstrap JS (required for theme)
		wp_register_script( 'bootstrap-min-js' , get_template_directory_uri() . '/layout/js/bootstrap/bootstrap.min.js', array( 'jquery' ), '3.3.4', true );

		# Pace Loader
		wp_register_script( 'pace-loader-min-js', get_template_directory_uri() . '/layout/js/pace/pace.min.js', array( 'jquery' ), '2.0', true );

		# Sticky JS
		wp_register_script( 'pixova-sticky-js', get_template_directory_uri() . '/layout/js/sticky/jquery.sticky.js', array( 'jquery' ), '2.0', true );

		# Preloader JS
		wp_register_script( 'pixova-lite-preloader', get_template_directory_uri() . '/layout/js/preloader.min.js', array( 'pace-loader-min-js' ), '1.0', true );

		# ViewPort JS
		wp_register_script( 'viewport-min-js', get_template_directory_uri() . '/layout/js/viewport/viewport.min.js', array( 'jquery' ), '1.0', true );

		# Parallax JS
		wp_register_script( 'parallax-min-js', get_template_directory_uri() . '/layout/js/parallax/parallax.min.js', array( 'jquery' ), '1.3.1', true );

		# owlCarousel main JS
		wp_register_script( 'owlCarousel-js', get_template_directory_uri() . '/layout/js/owl-carousel/owl-carousel.min.js', array( 'jquery' ), '1.3.3', true );

		# Classie JS
		wp_register_script( 'classie-js', get_template_directory_uri() . '/layout/js/classie/classie.js', array( 'jquery' ), '1.0.0', true );

		# Smooth Scroll JS
		wp_register_script( 'smooth-scroll-js', get_template_directory_uri() . '/layout/js/smoothscroll/smoothscroll.min.js', array( 'jquery' ), '0.9.9', true );

		# WOW js
		wp_register_script( 'wow-min-js', get_template_directory_uri() . '/layout/js/wow/wow.min.js', array( 'jquery' ), '1.0.3', true );

		# Simple Placeholders JS
		wp_register_script( 'simple-placeholder-js', get_template_directory_uri() . '/layout/js/simpleplaceholder/simplePlaceholder.min.js', array( 'jquery' ), '1.0.0', true );

		# jQuery Easy Pie Charts
		wp_register_script( 'pie-chart-js', get_template_directory_uri() . '/layout/js/easypiechart/easypiechart.min.js', array( 'jquery', 'viewport-min-js' ), '2.1.7', true );

		# jQuery Easy Pie Charts
		wp_register_script( 'pathloader-js', get_template_directory_uri() . '/layout/js/pathLoader.js', array(), '2.1.7', true );

		# Scripts JS
		wp_register_script( 'pixova-lite-scripts-js', get_template_directory_uri() . '/layout/js/scripts.min.js', array( 'jquery', 'classie-js' ), '1.41.1', true );

		// Plugins JS
		wp_register_script( 'pixova-lite-plugins-js', get_template_directory_uri() . '/layout/js/plugins.min.js', array( 'jquery', 'pie-chart-js', 'wow-min-js', 'pixova-lite-scripts-js', 'simple-placeholder-js' ), '1.41.1', true );

		/* Enqueue scripts */
		function pixova_lite_output_css_to_head() {

			echo '<!-- Customizer CSS Fixes-->' . "\n";
			echo '<style>';
			echo '#page {padding-top: 0 !important; }' . "\n";
			echo '</style>';
		}

		# Let's make sure we don't load our pre-loader script in the customizer
		global $wp_customize;

		# Preloader Enabled ?
		$preloader_enabled = get_theme_mod( 'pixova_lite_preloader_enabled', 'preloader_enabled' );

		if ( ! isset( $wp_customize ) && 'preloader_enabled' == $preloader_enabled ) {
			wp_enqueue_script( 'pathloader-js' );
			wp_enqueue_script( 'pace-loader-min-js' );
			wp_enqueue_script( 'pixova-lite-preloader' );
		} else {
			add_action( 'wp_head', 'pixova_lite_output_css_to_head' );
		}

		wp_enqueue_script( 'bootstrap-min-js' );
		wp_enqueue_script( 'pixova-sticky-js' );
		wp_enqueue_script( 'owlCarousel-js' );
		wp_enqueue_script( 'classie-js' );
		wp_enqueue_script( 'simple-placeholder-js' );
		wp_enqueue_script( 'smooth-scroll-js' );
		wp_enqueue_script( 'viewport-min-js' );
		wp_enqueue_script( 'parallax-min-js' );

		# Animations Enabled ?
		$animations_enabled = get_theme_mod( 'pixova_lite_animations_enabled', 'animations_enabled' );

		if ( 'animations_enabled' == $animations_enabled ) {
			wp_enqueue_script( 'wow-min-js' );
		}

		#
		# Localize Plugins JS
		#
		$pixova_lite_plugins_options = array(
			'animations_enabled' => $animations_enabled,
		);

		wp_localize_script( 'pixova-lite-plugins-js', 'pixova_lite_localization', $pixova_lite_plugins_options );
		wp_enqueue_script( 'pixova-lite-plugins-js' );

		#
		# Localize Scripts JS
		#

		# Header Text Parallax Effect ?
		$parallax_enabed = get_theme_mod( 'pixova_lite_header_effect_enabled', 'header_effect_enabled' );

		$pixova_lite_scripts_options = array(
			'parallax_enabled'   => $parallax_enabed,
			'animations_enabled' => $animations_enabled,
		);

		wp_localize_script( 'pixova-lite-scripts-js', 'pixova_lite_localization', $pixova_lite_scripts_options );
		wp_enqueue_script( 'pixova-lite-scripts-js' );

		// Animate CSS
		if ( 'animations_enabled' == $animations_enabled ) {
			wp_enqueue_style( 'animate-min-css', get_template_directory_uri() . '/layout/css/animate.min.css' );
		}

		// Font Awesome Stylesheet
		wp_enqueue_style( 'font-awesome-min-css', get_template_directory_uri() . '/layout/css/font-awesome.min.css' );

		// Google Fonts StyleSheet
		wp_enqueue_style( 'ga-fonts', pixova_lite_fonts_url() );

		// Bootstrap Stylesheet
		wp_enqueue_style( 'bootstrap-min-css', get_template_directory_uri() . '/layout/css/bootstrap.min.css' );

		// owlCarousel Stylesheet
		wp_enqueue_style( 'owlCarousel-main-css', get_template_directory_uri() . '/layout/css/owl.carousel.css' );
		wp_enqueue_style( 'owlCarousel-theme-css', get_template_directory_uri() . '/layout/css/owl.theme.css' );

		if ( function_exists( 'is_woocommerce' ) ) {
			wp_enqueue_style( 'pixova-lite-woocommerce-min-css', get_template_directory_uri() . '/layout/css/pixova-woocommerce.min.css' );
		}

		// General theme Stylesheet
		wp_enqueue_style( 'pixova-lite-min-css', get_template_directory_uri() . '/layout/css/style.min.css' );
		wp_enqueue_style( 'pixova-lite-min-style', get_stylesheet_uri() );

	} // function pixova_lite_enqueue_scripts end

	add_action( 'wp_enqueue_scripts', 'pixova_lite_enqueue_scripts' );

} // End if().

if ( ! function_exists( 'pixova_lite_child_manage_woocommerce_styles' ) ) {
	/**
	 * Optimize WooCommerce Scripts
	 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 *
	 * @since Pixova Lite 1.0.9
	 */

	function pixova_lite_child_manage_woocommerce_styles() {
		//first check that woo exists to prevent fatal errors
		if ( function_exists( 'is_woocommerce' ) ) {

			//remove generator meta tag
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

			//dequeue scripts and styles
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce_frontend_styles' );
				wp_dequeue_style( 'woocommerce_fancybox_styles' );
				wp_dequeue_style( 'woocommerce_chosen_styles' );
				wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
				wp_dequeue_script( 'wc_price_slider' );
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'wc-checkout' );
				wp_dequeue_script( 'wc-add-to-cart-variation' );
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-cart' );
				wp_dequeue_script( 'wc-chosen' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'prettyPhoto' );
				wp_dequeue_script( 'prettyPhoto-init' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
				wp_dequeue_script( 'fancybox' );
				wp_dequeue_script( 'jqueryui' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'pixova_lite_child_manage_woocommerce_styles', 99 );
}// End if().


if ( ! function_exists( 'pixova_lite_comment_reply_js' ) ) {
	/**
	 * Function that only loads the comment-reply JS script on pages that have the comment form enabled
	 *
	 * Given that we have a one page website, is_singular() will return true for pages as well (that means it gets loaded on the homepage for nothing)
	 *
	 * @since Pixova Lite 1.0.0
	 */
	function pixova_lite_comment_reply_js() {

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'comment_form_before', 'pixova_lite_comment_reply_js' );
}

// Fallback nav menu
if ( ! function_exists( 'pixova_lite_fallback_cb' ) ) {
	/**
	 * Nav menu fallback function
	 *
	 * @since Pixova Lite 1.11
	 *
	 */
	function pixova_lite_fallback_cb() {

		$html          = '<ul id="menu-pixova-lite-main-menu-container" class="pixova-default-menu">';
		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#about" title="' . __( 'About', 'pixova-lite' ) . '">';
				$html .= __( 'About', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#works" title="' . __( 'Recent Works', 'pixova-lite' ) . '">';
				$html .= __( 'Recent Works', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#testimonials" title="' . __( 'Testimonials', 'pixova-lite' ) . '">';
				$html .= __( 'Testimonials', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#team" title="' . __( 'Team', 'pixova-lite' ) . '">';
				$html .= __( 'Team', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#news" title="' . __( 'News', 'pixova-lite' ) . '">';
				$html .= __( 'News', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
			$html     .= '<a href="' . get_site_url() . '/#contact" title="' . __( 'Contact', 'pixova-lite' ) . '">';
				$html .= __( 'Contact', 'pixova-lite' );
			$html     .= '</a>';
		$html         .= '</li>';

		if ( function_exists( 'is_woocommerce' ) ) {
			$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
				$html     .= '<a href="' . get_site_url() . '/shop/" title="' . __( 'Shop', 'pixova-lite' ) . '">';
					$html .= __( 'Shop', 'pixova-lite' );
				$html     .= '</a>';
			$html         .= '</li>';
		}
		$html .= '</ul>';
		echo $html;
	}
}// End if().

if ( ! function_exists( 'pixova_lite_fonts_url' ) ) {
	/**
	 * Register Google fonts for Pixova Lite.
	 *
	 * @since Pixova Lite 1.16
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function pixova_lite_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
         * Translators: If there are characters in your language that are not supported
         * by Source Sans Pro Sans Serif, translate this to 'off'. Do not translate into your own language.
         */
		if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'pixova-lite' ) ) {
			$fonts[] = 'Poppins:600';
		}

		/*
         * Translators: If there are characters in your language that are not supported
         * by Souce Sans Pro Sans Serif, translate this to 'off'. Do not translate into your own language.
         */
		if ( 'off' !== _x( 'on', 'Roboto: on or off', 'pixova-lite' ) ) {
			$fonts[] = 'Roboto:400,500,700,400italic,700italic';
		}

		/*
         * Translators: If there are characters in your language that are not supported
         * by Inconsolata, translate this to 'off'. Do not translate into your own language.
         */
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'pixova-lite' ) ) {
			$fonts[] = 'Inconsolata:400,700';
		}

		/*
         * Translators: To add an additional character subset specific to your language,
         * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
         */
		$subset = _x( 'no-subset', 'Add new subset (latin-extended, vietnamese)', 'pixova-lite' );

		if ( 'latin-extended' == $subset ) {
			$subsets .= ',latin,latin-ext';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), '//fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
}// End if().

if ( ! function_exists( 'pixova_lite_add_default_widgets' ) ) {
	/**
	* Function to import widgets based on a JSON config file
	* JSON file is generated using plugin: Widget Importer / Exporter
	* @link https://github.com/stevengliebe/widget-importer-exporter
	*/
	function pixova_lite_add_default_widgets() {

		$json             = '{"orphaned_widgets_1":{"woocommerce_price_filter-2":{"title":"Filter by price"},"woocommerce_products-2":{"title":"Products","number":"5","show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-2":{"title":"Product Tags"},"woocommerce_recent_reviews-2":{"title":"Recent Reviews","number":"10"}},"shop-sidebar":{"woocommerce_price_filter-2":{"title":"Filter by price"},"woocommerce_products-2":{"title":"Products","number":"5","show":"","orderby":"date","order":"desc","hide_free":0,"show_hidden":0},"woocommerce_product_tag_cloud-2":{"title":"Product Tags"},"woocommerce_recent_reviews-2":{"title":"Recent Reviews","number":"10"}},"blog-sidebar":{"search-2":{"title":""},"recent-posts-2":{"title":"","number":5},"recent-comments-2":{"title":"","number":5},"archives-2":{"title":"","count":0,"dropdown":0},"categories-2":{"title":"","count":0,"hierarchical":0,"dropdown":0},"meta-2":{"title":""}},"footer-sidebar-1":{"pixova_lite_widget_about-2":{"title":"About","about_text":"The many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected true of a humour.\r\n\r\n","show_title":"1"}},"footer-sidebar-2":{"text-2":{"title":"Quick nav","text":"  <ul id=\"menu-pixova-footer-menu\" class=\"menu\">\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#about\">About<\/a><\/li>\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#works\">Recent Works<\/a><\/li>\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#testimonials\">Testimonials<\/a><\/li>\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#news\">News<\/a><\/li>\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#team\">Team<\/a><\/li>\r\n                                        <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#contact\">Contact<\/a><\/li>\r\n                                    <\/ul>","filter":false}},"footer-sidebar-3":{"pixova_lite_widget_latest_posts-2":{"title":"Latest post","items":"1","show_title":"1"}},"footer-sidebar-4":{"pixova_lite_widget_social_media-3":{"title":"Follow us","profile_facebook":" ","profile_twitter":" ","profile_plus":" ","profile_pinterest":" ","profile_youtube":" ","profile_dribbble":" ","profile_tumblr":" ","profile_instagram":" ","profile_github":" ","profile_bitbucket":" ","profile_codepen":"","show_title":""}}}';
		$config           = json_decode( $json );
		$sidebars_widgets = get_option( 'sidebars_widgets' );

		# Parse config
		foreach ( $config as $sidebar => $elemements ) {
			# verify if the sidebar doesn't have ny widgets
			if ( strpos( $sidebar, 'orphaned_widgets' ) === false && ! is_active_sidebar( $sidebar ) ) {
				# create an empty array for active widgets
				$this_sidebar_active_widgets = array();
				# parse all widgets for current sidebar
				foreach ( $elemements as $id_widget => $args ) {
					# add current widget to current sidebar
					$this_sidebar_active_widgets[] = $id_widget;
					# split widget name in order to get widget name and index
					$id_widget_parts = explode( '-',$id_widget );
					# get widget index
					$index_widget = end( $id_widget_parts );
					#remove widget index from array
					array_pop( $id_widget_parts );
					#generate widget name
					$widget_name = implode( '-', $id_widget_parts );
					#get all widgets who are like current widget
					$widgets = get_option( 'widget_' . $widget_name );
					#check if current index exist in array
					if ( ! isset( $widgets[ $index_widget ] ) ) {
						#add current widget with his index and args
						$widgets[ $index_widget ] = get_object_vars( $args );
					}
					#update widgets who are like current widget
					update_option( 'widget_' . $widget_name, $widgets );
				}
				$sidebars_widgets[ $sidebar ] = $this_sidebar_active_widgets;
			}
		}
		update_option( 'sidebars_widgets', $sidebars_widgets );
	}
}// End if().


// Include epsilon framework
require_once get_template_directory() . '/inc/libraries/epsilon-framework/class-epsilon-autoloader.php';
new Epsilon_Framework();

/**
 * Instantiate the Epsilon Typography object
 */
$options = array(
	'pixova_lite_heading_1',
	'pixova_lite_heading_2',
	'pixova_lite_heading_3',
	'pixova_lite_heading_4',
	'pixova_lite_heading_5',
	'pixova_lite_heading_6',
);

$handler = 'pixova-lite-min-style';
Epsilon_Typography::get_instance( $options, $handler );

/**
 * Instantiate the Epsilon Color Scheme object
 */
$handler = 'pixova-lite-min-style';

$args = array(
	'fields' => array(
		'pixova_lite_accent_color'           => array(
			'label'       => __( 'Accent Color', 'pixova-lite' ),
			'description' => __( 'The main color used for links, buttons, and more.', 'pixova-lite' ),
			'default'     => '#ffce55',
			'section'     => 'pixova_lite_colors',
			'hover-state' => true,
		),

		'pixova_lite_heading_color'          => array(
			'label'       => __( 'Heading Color', 'pixova-lite' ),
			'description' => __( 'The color used for headings.', 'pixova-lite' ),
			'default'     => '#222533',
			'section'     => 'pixova_lite_colors',
			'hover-state' => false,
		),

		'pixova_lite_text_color'             => array(
			'label'       => __( 'Text Color', 'pixova-lite' ),
			'description' => __( 'The color used for paragraphs, links, etc.', 'pixova-lite' ),
			'default'     => '#777',
			'section'     => 'pixova_lite_colors',
			'hover-state' => false,
		),

		'pixova_lite_hover_color'            => array(
			'label'       => __( 'Hover Color', 'pixova-lite' ),
			'description' => __( 'The color used for hover on elements.', 'pixova-lite' ),
			'default'     => '#ffce55',
			'section'     => 'pixova_lite_colors',
			'hover-state' => true,
		),

		'pixova_lite_footer_bg_color'        => array(
			'label'       => __( 'Footer Background Color', 'pixova-lite' ),
			'description' => __( 'The color used for the footer background.', 'pixova-lite' ),
			'default'     => '#1f1f1f',
			'section'     => 'pixova_lite_colors',
			'hover-state' => false,
		),

		'pixova_lite_footer_widget_bg_color' => array(
			'label'       => __( 'Footer Widget Background Color', 'pixova-lite' ),
			'description' => __( 'The color used for the footer widgets background.', 'pixova-lite' ),
			'default'     => '#313233',
			'section'     => 'pixova_lite_colors',
			'hover-state' => false,
		),

	),

	'css'    => Epsilon_Color_Scheme::load_css_overrides( get_template_directory() . '/layout/css/style-overrides.css' ),
);

Epsilon_Color_Scheme::get_instance( $handler, $args );
