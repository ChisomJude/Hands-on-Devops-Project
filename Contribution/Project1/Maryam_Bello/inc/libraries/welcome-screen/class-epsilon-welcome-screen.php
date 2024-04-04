<?php
/**
 * Epsilon Welcome Screen
 *
 * @package Epsilon Framework
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Welcome_Screen
 */
class Epsilon_Welcome_Screen {
	/**
	 * Theme name
	 *
	 * @var string
	 */
	public $theme_name = '';

	/**
	 * Theme slug
	 *
	 * @var string
	 */
	public $theme_slug = '';

	/**
	 * Author Logo
	 *
	 * @var string
	 */
	public $author_logo = '';

	/**
	 * Required actions
	 *
	 * @var array|mixed
	 */
	public $actions = array();

	/**
	 * Actions count
	 *
	 * @var int
	 */
	public $actions_count = 0;

	/**
	 * Required Plugins
	 *
	 * @var array|mixed
	 */
	public $plugins = array();

	/**
	 * Notice message
	 *
	 * @var mixed|string
	 */
	public $notice = '';

	/**
	 * Tab sections
	 *
	 * @var array
	 */
	public $sections = array();

	/**
	 * EDD Strings
	 *
	 * @var array
	 */
	public $strings = array();

	/**
	 * EDD load
	 *
	 * @var bool
	 */
	public $edd = false;

	/**
	 * If we have an EDD product, we need to add an ID
	 *
	 * @var string
	 */
	public $download_id = '';

	/**
	 * Epsilon_Welcome_Screen constructor.
	 *
	 * @param array $config Configuration array.
	 */
	public function __construct( $config = array() ) {
		$theme    = wp_get_theme();
		$defaults = array(
			'theme-name'  => $theme->get( 'Name' ),
			'theme-slug'  => $theme->get( 'TextDomain' ),
			'author-logo' => get_template_directory_uri() . '/inc/libraries/welcome-screen/img/colorlib-logo.png',
			'actions'     => array(),
			'plugins'     => array(),
			'notice'      => '',
			'sections'    => array(),
			'edd'         => false,
			'download_id' => '',
		);

		$config = wp_parse_args( $config, $defaults );

		/**
		 * Configure our welcome screen
		 */
		$this->theme_name    = $config['theme-name'];
		$this->theme_slug    = $config['theme-slug'];
		$this->author_logo   = $config['author-logo'];
		$this->actions       = $config['actions'];
		$this->actions_count = $this->count_actions();
		$this->plugins       = $config['plugins'];
		$this->notice        = $config['notice'];
		$this->sections      = $config['sections'];
		$this->edd           = $config['edd'];
		$this->download_id   = $config['download_id'];

		if ( $this->edd ) {
			$this->strings = EDD_Theme_Helper::get_strings();
		}

		if ( empty( $config['sections'] ) ) {
			$this->sections = $this->set_default_sections( $config );
		}

		/**
		 * Create the dashboard page
		 */
		add_action( 'admin_menu', array( $this, 'welcome_screen_menu' ) );

		/**
		 * Load the welcome screen styles and scripts
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		/**
		 * Add the notice in the admin backend
		 */
		$this->add_admin_notice();

		/**
		 * Add the default option array ( required actions related )
		 */
		$this->add_default_options();

		/**
		 * Ajax callbacks
		 */
		add_action( 'wp_ajax_welcome_screen_ajax_callback', array(
			$this,
			'welcome_screen_ajax_callback',
		) );
		add_action( 'wp_ajax_nopriv_welcome_screen_ajax_callback', array(
			$this,
			'welcome_screen_ajax_callback',
		) );

		if ( $this->edd ) {
			/**
			 * Initiate EDD Stuff
			 */
			add_action( 'admin_init', array( 'EDD_Theme_Helper', 'init' ) );
			add_filter( 'http_request_args', array( 'EDD_Theme_Helper', 'disable_wporg_request' ), 5, 2 );

			add_action(
				'update_option_' . $this->theme_slug . '_license_key',
				array(
					'EDD_Theme_Helper',
					'license_activator_deactivator',
				),
				10,
				2
			);
		}
	}

	/**
	 * AJAX Handler
	 */
	public function welcome_screen_ajax_callback() {
		if ( isset( $_POST['args'], $_POST['args']['nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['args']['nonce'] ), 'welcome_nonce' ) ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
					)
				)
			);
		}

		$args_action = array_map( 'sanitize_text_field', wp_unslash( $_POST['args']['action'] ) );

		if ( count( $args_action ) !== 2 ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Not allowed', 'epsilon-framework' ),
					)
				)
			);
		}

		if ( ! class_exists( $args_action[0] ) ) {
			wp_die(
				wp_json_encode(
					array(
						'status' => false,
						'error'  => esc_html__( 'Class does not exist', 'epsilon-framework' ),
					)
				)
			);
		}

		$class  = $args_action[0];
		$method = $args_action[1];
		$args   = array();

		if ( is_array( $_POST['args']['args'] ) ) {
			$args = Epsilon_Sanitizers::array_map_recursive( 'sanitize_text_field', wp_unslash( $_POST['args']['args'] ) );
		}

		$response = $class::$method( $args );

		if ( is_array( $response ) ) {
			wp_die( wp_json_encode( $response ) );
		}

		if ( 'ok' === $response ) {
			wp_die(
				wp_json_encode(
					array(
						'status'  => true,
						'message' => 'ok',
					)
				)
			);
		}

		wp_die(
			wp_json_encode(
				array(
					'status'  => false,
					'message' => 'nok',
				)
			)
		);
	}

	/**
	 * Instance constructor
	 *
	 * @param array $config Configuration array.
	 *
	 * @returns object
	 */
	public static function get_instance( $config = array() ) {
		static $inst;

		if ( ! $inst ) {
			$inst = new Epsilon_Welcome_Screen( $config );
		}

		return $inst;
	}

	/**
	 * Load welcome screen css and javascript
	 */
	public function enqueue() {
		if ( is_admin() ) {
			wp_enqueue_style(
				'welcome-screen',
				get_template_directory_uri() . '/inc/libraries/welcome-screen/css/welcome.css'
			);

			wp_enqueue_script(
				'welcome-screen',
				get_template_directory_uri() . '/inc/libraries/welcome-screen/js/welcome.js',
				array(
					'jquery-ui-slider',
				),
				'12123'
			);

			wp_localize_script(
				'welcome-screen',
				'welcomeScreen',
				array(
					'nr_actions_required'      => absint( $this->count_actions() ),
					'template_directory'       => esc_url( get_template_directory_uri() ),
					'no_required_actions_text' => esc_html__( 'Hooray! There are no required actions for you right now.', 'epsilon-framework' ),
					'ajax_nonce'               => wp_create_nonce( 'welcome_nonce' ),
					'activating_string'        => esc_html__( 'Activating', 'epsilon-framework' ),
					'body_class'               => 'appearance_page_' . $this->theme_slug . '-welcome',
					'no_actions'               => esc_html__( 'Hooray! There are no required actions for you right now.', 'epsilon-framework' ),
				)
			);
		}
	}

	/**
	 * Add a default option array in the database
	 */
	private function add_default_options() {
		if ( ! empty( $this->actions ) ) {
			$actions_left = get_option( 'pixova_show_required_actions', array() );
			if ( empty( $actions_left ) ) {
				foreach ( $this->actions as $action ) {
					$actions_left[ $action['id'] ] = true;
				}
				update_option( 'pixova_show_required_actions', $actions_left );
			}
		}

		if ( ! empty( $this->plugins ) ) {
			$plugins_left = get_option( 'pixova_show_recommended_plugins', array() );
			if ( empty( $plugins_left ) ) {
				foreach ( $this->plugins as $plugin => $prop ) {
					$plugins_left[ $plugin ] = true;
				}
				update_option( 'pixova_show_recommended_plugins', $plugins_left );
			}
		}
	}

	/**
	 * Adds an admin notice in the backend
	 *
	 * If the Epsilon Notification class does not exist, we stop
	 */
	private function add_admin_notice() {
		if ( ! class_exists( 'Epsilon_Notifications' ) ) {
			return;
		}

		if ( empty( $this->notice ) ) {
			if ( ! empty( $this->author_logo ) ) {
				$this->notice .= '<img src="' . $this->author_logo . '" class="epsilon-author-logo" />';
			}
			/* Translators: Notice Title */
			$this->notice .= '<h1>' . sprintf( esc_html__( 'Welcome to %1$s', 'epsilon-framework' ), $this->theme_name ) . '</h1>';
			$this->notice .= '<p>';
			$this->notice .=
				sprintf( /* Translators: Notice */
					esc_html__( 'Welcome! Thank you for choosing %3$s! To fully take advantage of the best our theme can offer please make sure you visit our %1$swelcome page%2$s.', 'epsilon-framework' ),
					'<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-welcome' ) ) . '">',
					'</a>',
					$this->theme_name
				);
			$this->notice .= '</p>';
			/* Translators: Notice URL */
			$this->notice .= '<p><a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-welcome' ) ) . '" class="button button-primary button-hero" style="text-decoration: none;"> ' . sprintf( esc_html__( 'Get started with %1$s', 'epsilon-framework' ), $this->theme_name ) . '</a></p>';

		}

		$notifications = Epsilon_Notifications::get_instance();
		$notifications->add_notice(
			array(
				'id'      => 'pixova_welcome_notice',
				'type'    => 'notice epsilon-big',
				'message' => $this->notice,
			)
		);
	}

	/**
	 * Registers the welcome screen menu
	 */
	public function welcome_screen_menu() {
		/* Translators: Menu Title */
		$title = sprintf( esc_html__( 'About %1$s', 'epsilon-framework' ), esc_html( $this->theme_name ) );

		if ( 0 < $this->actions_count ) {
			$title .= '<span class="badge-action-count">' . esc_html( $this->actions_count ) . '</span>';
		}

		add_theme_page(
			$this->theme_name,
			$title,
			'edit_theme_options',
			$this->theme_slug . '-welcome',
			array(
				$this,
				'render_welcome_screen',
			)
		);
	}

	/**
	 * Render the welcome screen
	 */
	public function render_welcome_screen() {
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );

		$theme = wp_get_theme();
		$tab   = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'getting-started';

		?>
		<div class="wrap about-wrap epsilon-wrap">
			<h1>
				<?php
				/* Translators: Welcome Screen Title. */
				echo sprintf( esc_html__( 'Welcome to %1$s - v', 'epsilon-framework' ), esc_html( $this->theme_name ) ) . esc_html( $theme['Version'] );
				?>
			</h1>
			<div class="about-text">
				<?php
				/* Translators: Welcome Screen Description. */
				echo sprintf( esc_html__( '%1$s is now installed and ready to use! Get ready to build something beautiful. We hope you enjoy it! We want to make sure you have the best experience using %1$s and that is why we gathered here all the necessary information for you. We hope you will enjoy using %1$s, as much as we enjoy creating great products.', 'epsilon-framework' ), esc_html( $this->theme_name ) );
				?>
			</div>
			<div class="wp-badge epsilon-welcome-logo"></div>

			<h2 class="nav-tab-wrapper wp-clearfix">
				<?php foreach ( $this->sections as $id => $section ) { ?>
					<a class="nav-tab <?php echo $id === $tab ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( $section['url'] ); ?>"><?php echo wp_kses_post( $section['label'] ); ?></a>
				<?php } ?>
			</h2>

			<?php require_once $this->sections[ $tab ]['path']; ?>
		</div>
		<?php
	}

	/**
	 * Count the number of actions left
	 *
	 * @return int
	 */
	private function count_actions() {
		$actions_left = get_option( 'pixova_show_required_actions', array() );

		$i = 0;
		foreach ( $this->actions as $action ) {
			$true = false;

			if ( ! $action['check'] ) {
				$true = true;
			}

			if ( ! empty( $actions_left ) && isset( $actions_left[ $action['id'] ] ) && ! $actions_left[ $action['id'] ] ) {
				$true = false;
			}

			if ( $true ) {
				$i ++;
			}
		}

		return $i;
	}

	/**
	 * Generate url for the backend section tabs
	 *
	 * @param string $id Id of the backend tab.
	 *
	 * @return string
	 */
	private function generate_admin_url( $id = '' ) {
		$url = 'themes.php?page=%1$s-welcome&tab=%2$s';

		return admin_url( sprintf( $url, $this->theme_slug, $id ) );
	}

	/**
	 * Generate default sections, with exclusion
	 *
	 * @param array $config Configuration array.
	 *
	 * @return array
	 */
	private function set_default_sections( $config = array() ) {
		$arr = array(
			'getting-started'     => array(
				'id'    => 'getting-started',
				'url'   => $this->generate_admin_url( 'getting-started' ),
				'label' => __( 'Getting Started', 'epsilon-framework' ),
				'path'  => get_template_directory() . '/inc/libraries/welcome-screen/sections/getting-started.php',
			),
			'recommended-actions' => array(
				'id'    => 'recommended-actions',
				'url'   => $this->generate_admin_url( 'recommended-actions' ),
				'label' => __( 'Recommended Actions', 'epsilon-framework' ),
				'path'  => get_template_directory() . '/inc/libraries/welcome-screen/sections/recommended-actions.php',
			),
			'recommended-plugins' => array(
				'id'    => 'recommended-plugins',
				'url'   => $this->generate_admin_url( 'recommended-plugins' ),
				'label' => __( 'Recommended Plugins', 'epsilon-framework' ),
				'path'  => get_template_directory() . '/inc/libraries/welcome-screen/sections/recommended-plugins.php',
			),
			'support'             => array(
				'id'    => 'support',
				'url'   => $this->generate_admin_url( 'support' ),
				'label' => __( 'Support', 'epsilon-framework' ),
				'path'  => get_template_directory() . '/inc/libraries/welcome-screen/sections/support.php',
			),
			'registration'        => array(
				'id'    => 'registration',
				'url'   => $this->generate_admin_url( 'registration' ),
				'label' => __( 'Registration', 'epsilon-framework' ),
				'path'  => get_template_directory() . '/inc/libraries/welcome-screen/sections/registration.php',
			),
		);

		if ( 0 === count( $this->plugins ) ) {
			unset( $arr['recommended-plugins'] );
		}

		if ( 0 < $this->actions_count ) {
			$arr['recommended-actions']['label'] .= '<span class="badge-action-count">' . $this->actions_count . '</span>';
		}

		if ( ! $this->edd ) {
			unset( $arr['registration'] );
		}

		if ( isset( $config['sections_exclude'] ) && ! empty( $config['sections_exclude'] ) ) {
			foreach ( $config['sections_exclude'] as $id ) {
				unset( $arr[ $id ] );
			}
		}

		if ( isset( $config['sections_include'] ) && ! empty( $config['sections_include'] ) ) {
			foreach ( $config['sections_include'] as $id => $props ) {
				$arr[ $id ] = $props;
			}
		}

		return $arr;
	}

	/**
	 * Will return an array with everything that we need to render the action info
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @returns array
	 */
	private function check_plugin( $slug = '' ) {
		$arr = array(
			'installed' => Epsilon_Notify_System::check_plugin_is_installed( $slug ),
			'active'    => Epsilon_Notify_System::check_plugin_is_active( $slug ),
			'needs'     => 'install',
			'class'     => 'install-now button',
			'label'     => __( 'Install', 'epsilon-framework' ),
		);

		if ( in_array( $slug, array( 'contact-form-7' ) ) ) {
			switch ( $slug ) {
				case 'contact-form-7':
					if ( file_exists( ABSPATH . 'wp-content/plugins/contact-form-7' ) ) {
						$arr['installed'] = true;
						$arr['active']    = defined( 'WPCF7_VERSION' );
					}
					break;
				default:
					$arr['installed'] = false;
					$arr['active']    = false;
					break;
			}
		}

		if ( $arr['installed'] ) {
			$arr['needs'] = 'activate';
			$arr['class'] = 'activate-now button button-primary';
			$arr['label'] = __( 'Activate now', 'epsilon-framework' );
		}

		if ( $arr['active'] ) {
			$arr['needs'] = 'deactivate';
			$arr['class'] = 'deactivate-now button button-primary';
			$arr['label'] = __( 'Deactivate now', 'epsilon-framework' );
		}

		$arr['url'] = $this->create_plugin_link( $arr['needs'], $slug );

		return $arr;
	}

	/**
	 * Creates a link to install/activate/deactivate certain plugins
	 *
	 * @param string $state Plugin state (active,not installed).
	 * @param string $slug Plugin slug.
	 *
	 * @return string
	 */
	private function create_plugin_link( $state, $slug ) {
		$string        = '';
		$complete_slug = Pixova_Notify_System::_get_plugin_basename_from_slug( $slug );
		switch ( $state ) {
			case 'install':
				$string = wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $slug,
						),
						network_admin_url( 'update.php' )
					),
					'install-plugin_' . $slug
				);
				break;
			case 'deactivate':
				$string = add_query_arg(
					array(
						'action'        => 'deactivate',
						'plugin'        => rawurlencode( $complete_slug ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $complete_slug ),
					),
					network_admin_url( 'plugins.php' )
				);
				break;
			case 'activate':
				$string = add_query_arg(
					array(
						'action'        => 'activate',
						'plugin'        => rawurlencode( $complete_slug ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $complete_slug ),
					),
					admin_url( 'plugins.php' )
				);
				break;
			default:
				$string = '';
				break;
		}// End switch().

		return $string;
	}

	/**
	 * Return information of a plugin
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @return array
	 */
	private function get_plugin_information( $slug = '' ) {
		$arr = array(
			'info' => $this->call_plugin_api( $slug ),
		);

		$arr['icon'] = $this->check_for_icon( $arr['info']->icons );
		$merge       = $this->check_plugin( $slug );

		$arr = array_merge( $arr, $merge );

		return $arr;
	}

	/**
	 * Get information about a plugin
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @return array|mixed|object|WP_Error
	 */
	private function call_plugin_api( $slug = '' ) {
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		$call_api = get_transient( $this->theme_slug . '_plugin_information_transient_' . $slug );

		if ( false === $call_api ) {
			$call_api = plugins_api( 'plugin_information', array(
				'slug'   => $slug,
				'fields' => array(
					'downloaded'        => false,
					'rating'            => false,
					'description'       => false,
					'short_description' => true,
					'donate_link'       => false,
					'tags'              => false,
					'sections'          => true,
					'homepage'          => true,
					'added'             => false,
					'last_updated'      => false,
					'compatibility'     => false,
					'tested'            => false,
					'requires'          => false,
					'downloadlink'      => false,
					'icons'             => true,
				),
			) );
			set_transient( $this->theme_slug . '_plugin_information_transient_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
		}

		return $call_api;
	}

	/**
	 * Searches icons for the plugin
	 *
	 * @param object $object Icon object.
	 *
	 * @return string;
	 */
	private function check_for_icon( $object ) {
		if ( ! empty( $object['svg'] ) ) {
			$plugin_icon_url = $object['svg'];
		} elseif ( ! empty( $object['2x'] ) ) {
			$plugin_icon_url = $object['2x'];
		} elseif ( ! empty( $object['1x'] ) ) {
			$plugin_icon_url = $object['1x'];
		} else {
			$plugin_icon_url = $object['default'];
		}

		return $plugin_icon_url;
	}

	/**
	 * Handle a required action
	 *
	 * @param array $args Argument array.
	 *
	 * @return string;
	 */
	public static function handle_required_action( $args = array() ) {
		$instance     = self::get_instance();
		$actions_left = get_option( 'pixova_show_required_actions', array() );

		$actions_left[ $args['id'] ] = 'hidden' === $args['do'];

		update_option( 'pixova_show_required_actions', $actions_left );

		return 'ok';
	}

	public static function demo_content_html() {
		$html  = '<p><a class="button button-primary epsilon-ajax-button" id="add_default_sections" href="#">' . __( 'Import Demo Content', 'epsilon-framework' ) . '</a>';
		$html .= '<a class="button epsilon-hidden-content-toggler" href="#" data-toggle="welcome-hidden-content">' . __( 'Advanced', 'epsilon-framework' ) . '</a></p>';
		$html .= '<div class="import-content-container" id="welcome-hidden-content">';
		$html .= '<div class="demo-content-container" >';
		$html .= '<div class="checkbox-group">';
		$html .= '<label><input checked type="checkbox" class="demo-checkboxes" value="set_frontpage_to_static" name="set_frontpage_to_static"/>' . __( 'Set Front Page Static', 'epsilon-framework' ) . '</label>';
		$html .= '<label><input checked type="checkbox" class="demo-checkboxes" value="import_demo_content" name="import_demo_content"/>' . __( 'Import Demo Data', 'epsilon-framework' ) . '</label>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	public static function process_sample_content( $args = array() ) {
		$imported = true;

		if ( empty( $args ) ) {
			$args = array( 'set_frontpage_to_static', 'import_demo_content' );
		}

		foreach ( $args as $k => $v ) {
			$response = self::$v();
			if ( $imported && 'ok' != $response ) {
				$imported = false;
			}
		}

		if ( $imported ) {
			return 'ok';
		}

	}

	/**
	 * Set a frontpage to static
	 *
	 * @param array $args Argument array.
	 *
	 * @return string;
	 */
	public static function set_frontpage_to_static( $args = array() ) {
		$home = get_page_by_title( 'Homepage' );
		$blog = get_page_by_title( 'Blog' );

		if ( null === $home ) {
			$id = wp_insert_post(
				array(
					'post_title'  => __( 'Homepage', 'epsilon-framework' ),
					'post_type'   => 'page',
					'post_status' => 'publish',
				)
			);

			update_option( 'page_on_front', $id );
			update_option( 'show_on_front', 'page' );
		} else {
			update_option( 'page_on_front', $home->ID );
			update_option( 'show_on_front', 'page' );
		}

		if ( null === $blog ) {
			$id = wp_insert_post(
				array(
					'post_title'  => __( 'Blog', 'epsilon-framework' ),
					'post_type'   => 'page',
					'post_status' => 'publish',
				)
			);

			update_option( 'page_for_posts', $id );
		} else {
			update_option( 'page_for_posts', $blog->ID );
		}

		return 'ok';
	}

	public static function import_demo_content() {

		$content_json = '{"pixova_lite_intro_title_cta":"WELCOME TO PIXOVA LITE","pixova_lite_intro_cta":"Free & Modern One-Page Parallax WordPress Theme","pixova_lite_intro_sub_cta":"Your cool business headline here. You can even \u003Cu\u003E\u003Cstrong\u003Einsert HTML here & images\u003C\/strong\u003E\u003C\/u\u003E.\nLorem ipsum dolor sit amet lorem dolor sit amet.","pixova_lite_intro_outline_button_text":"LEARN MORE","pixova_lite_intro_outline_button_url":"#about","pixova_lite_intro_button_text":"CONTACT US","pixova_lite_intro_button_url":"#about","pixova_lite_intro_what_we_do_1_icon":"fa fa-bold","pixova_lite_intro_what_we_do_1_title":"Web design","pixova_lite_intro_what_we_do_1_description":"Lorem ipsum dolor sit amet. Lorem ipsum.","pixova_lite_intro_what_we_do_2_icon":"fa fa-code","pixova_lite_intro_what_we_do_2_title":"Development","pixova_lite_intro_what_we_do_2_description":"Lorem ipsum dolor sit amet. Lorem ipsum.","pixova_lite_intro_what_we_do_3_icon":"fa fa-envelope-o","pixova_lite_intro_what_we_do_3_title":"Print design","pixova_lite_intro_what_we_do_3_description":"Lorem ipsum dolor sit amet. Lorem ipsum.","pixova_lite_about_section_title":"We build solutions for your everyday problems.","pixova_lite_about_section_sub_title":"This is what we do in a nutshell.","pixova_lite_about_section_textarea":"Creative ut tincidunt nibh, varius cursus nunc. Curabitur molestie, metus vel luctus euismod, mi libero laoreet odio, eu dapibus leo tortor sit amet purus. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.","pixova_lite_about_section_blockquote":"Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Erlich Bachman, Aviato.","pixova_lite_about_section_chart_1_heading":"Web design","pixova_lite_about_section_chart_2_heading":"Web development","pixova_lite_about_section_chart_3_heading":"Print design","pixova_lite_about_section_chart_3_percentage":"90","pixova_lite_about_section_chart_4_percentage":"50","pixova_lite_about_section_chart_4_heading":"Graphic identity","pixova_lite_work_section_title":"Recent works","pixova_lite_work_section_sub_title":"It\'s show and tell time.","pixova_lite_about_section_chart_1_percentage":"70","pixova_lite_about_section_chart_2_percentage":"90","pixova_lite_works_project_1_url":"https:\/\/colorlib.com\/wp\/themes\/pixova","pixova_lite_works_project_2_url":"https:\/\/colorlib.com\/wp\/themes\/pixova","pixova_lite_works_project_3_url":"https:\/\/colorlib.com\/wp\/themes\/pixova","pixova_lite_works_project_4_url":"https:\/\/colorlib.com\/wp\/themes\/pixova","pixova_lite_testimonial_section_title":"Some words from our clients","pixova_lite_testimonial_section_sub_title":"We don\'t like to brag, others do it for us.","pixova_lite_testimonial_1_person_name":"Katie Parry - Hooli","pixova_lite_testimonial_1_person_description":"Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.","pixova_lite_testimonial_2_person_name":"John Doe","pixova_lite_testimonial_2_person_description":"Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.","pixova_lite_testimonial_3_person_name":"Katie Parry - Hooli","pixova_lite_testimonial_3_person_description":"Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.","pixova_lite_testimonial_4_person_name":"Katie Parry - Hooli","pixova_lite_testimonial_4_person_description":"Working with Pixova has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.","pixova_lite_testimonial_5_person_name":"Katie Parry - Hooli","pixova_lite_testimonial_5_person_description":"Working with Pixva has been an experience for a lifetime. I strongly reccommend these guys for their awesome support. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer volutpat eleifend convallis.","pixova_lite_news_section_title":"Latest news","pixova_lite_news_section_sub_title":"Straight from our blog.","pixova_lite_news_section_button_text":"Visit our blog","pixova_lite_news_section_no_posts_per_slide":"2","pixova_lite_team_section_title":"The team","pixova_lite_team_section_sub_title":"Meet the people that made it all happen.","pixova_lite_team_member_1_name":"Angelina Doe","pixova_lite_team_member_1_facebook":"https:\/\/www.facebook.com\/colorlib","pixova_lite_team_member_1_dribbble":"http:\/\/www.dribbble.com\/colorlib","pixova_lite_team_member_1_email":"contact@site.com","pixova_lite_team_member_1_twitter":"https:\/\/twitter.com\/colorlib\/","pixova_lite_team_member_1_linkedin":"https:\/\/www.linkedin.com","pixova_lite_team_member_1_pinterest":"https:\/\/pinterest.com","pixova_lite_team_member_1_instagram":"https:\/\/www.instagram.com","pixova_lite_team_member_1_googleplus":"https:\/\/plus.google.com","pixova_lite_team_member_2_name":"John Doe","pixova_lite_team_member_2_facebook":"https:\/\/www.facebook.com\/colorlib","pixova_lite_team_member_2_dribbble":"http:\/\/www.dribbble.com\/madalin.duca","pixova_lite_team_member_2_email":"contact@site.com","pixova_lite_team_member_2_twitter":"https:\/\/twitter.com\/colorlib\/","pixova_lite_team_member_2_linkedin":"https:\/\/www.linkedin.com","pixova_lite_team_member_2_pinterest":"https:\/\/pinterest.com","pixova_lite_team_member_2_instagram":"https:\/\/www.instagram.com","pixova_lite_team_member_2_googleplus":"https:\/\/plus.google.com","pixova_lite_team_member_3_name":"Angelina Doe","pixova_lite_team_member_3_facebook":"https:\/\/www.facebook.com\/colorlib","pixova_lite_team_member_3_dribbble":"http:\/\/www.dribbble.com\/colorlib","pixova_lite_team_member_3_email":"contact@site.com","pixova_lite_team_member_3_twitter":"https:\/\/twitter.com\/colorlib\/","pixova_lite_team_member_3_linkedin":"https:\/\/www.linkedin.com","pixova_lite_team_member_3_pinterest":"https:\/\/pinterest.com","pixova_lite_team_member_3_instagram":"https:\/\/www.instagram.com","pixova_lite_team_member_3_googleplus":"https:\/\/plus.google.com","pixova_lite_team_member_4_name":"Angelina Doe","pixova_lite_team_member_4_facebook":"https:\/\/www.facebook.com\/colorlib\/","pixova_lite_team_member_4_dribbble":"http:\/\/www.dribbble.com\/colorlib\/","pixova_lite_team_member_4_email":"contact@site.com","pixova_lite_team_member_4_twitter":"https:\/\/twitter.com\/colorlib","pixova_lite_team_member_4_linkedin":"https:\/\/www.linkedin.com","pixova_lite_team_member_4_pinterest":"https:\/\/pinterest.com","pixova_lite_team_member_4_instagram":"https:\/\/www.instagram.com","pixova_lite_team_member_4_googleplus":"https:\/\/plus.google.com","pixova_lite_team_member_5_name":"John Doe","pixova_lite_team_member_5_facebook":"https:\/\/www.facebook.com\/colorlib","pixova_lite_team_member_5_dribbble":"http:\/\/www.dribbble.com\/colorlib","pixova_lite_team_member_5_email":"contact@site.com","pixova_lite_team_member_5_twitter":"https:\/\/twitter.com\/colorlib\/","pixova_lite_team_member_5_linkedin":"https:\/\/www.linkedin.com","pixova_lite_team_member_5_pinterest":"https:\/\/pinterest.com","pixova_lite_team_member_5_instagram":"https:\/\/www.instagram.com","pixova_lite_team_member_5_googleplus":"https:\/\/plus.google.com","pixova_lite_contact_section_title":"Contact us","pixova_lite_contact_section_sub_title":"And we\'ll reply in no time.","pixova_lite_contact_first_heading":"Address","pixova_lite_contact_second_heading":"Customer Support","pixova_lite_email":"contact@site.org","pixova_lite_phone":"0 332 548 955","pixova_lite_address":"Street 221B Baker Street","pixova_lite_about_section_chart_1_bar_color":"#f2c351","pixova_lite_about_section_chart_1_track_color":"#eeeeee","pixova_lite_about_section_chart_2_bar_color":"#f2c351","pixova_lite_about_section_chart_2_track_color":"#eeeeee","pixova_lite_about_section_chart_3_bar_color":"#f2c351","pixova_lite_about_section_chart_3_track_color":"#eeeeee","pixova_lite_about_section_chart_4_bar_color":"#f2c351","pixova_lite_about_section_chart_4_track_color":"#eeeeee","pixova_lite_works_project_1_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/recent-works-1-270x426.jpg","pixova_lite_works_project_1_logo":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/logo1.png","pixova_lite_works_project_1_url":"https:\/\/colorlib.com\/pixova-lite\/","pixova_lite_works_project_2_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/recent-works-2-270x426.jpg","pixova_lite_works_project_2_logo":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/logo2.png","pixova_lite_works_project_2_url":"https:\/\/colorlib.com\/pixova-lite\/","pixova_lite_works_project_3_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/recent-works-3-270x426.jpg","pixova_lite_works_project_3_logo":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/logo3.png","pixova_lite_works_project_3_url":"https:\/\/colorlib.com\/pixova-lite\/","pixova_lite_works_project_4_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/recent-works-4-270x426.jpg","pixova_lite_works_project_4_logo":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/recent-works\/logo4.png","pixova_lite_works_project_4_url":"https:\/\/colorlib.com\/pixova-lite\/","pixova_lite_testimonial_1_person_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/testimonials\/teammembru_burned-92x92.jpg","pixova_lite_testimonial_2_person_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/testimonials\/teammembru_burned-92x92.jpg","pixova_lite_testimonial_3_person_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/testimonials\/teammembru_burned-92x92.jpg","pixova_lite_testimonial_4_person_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/testimonials\/teammembru_burned-92x92.jpg","pixova_lite_testimonial_5_person_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/testimonials\/teammembru_burned-92x92.jpg","pixova_lite_team_member_1_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/team\/teammembru-150x150.jpg","pixova_lite_team_member_2_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/team\/teammembru2-150x150.jpg","pixova_lite_team_member_3_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/team\/teammembru3-150x150.jpg","pixova_lite_team_member_4_image":"https:\/\/cdn.colorlib.com\/pixova-lite\/wp-content\/themes\/pixova-lite\/layout\/images\/team\/teammembru4-150x150.jpg"}';

		$content = json_decode( $content_json, true );

		// Get contact form
		$args = array(
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
		);

		$cf7forms = new WP_Query( $args );
		if ( $cf7forms->have_posts() ) {
			$content['pixova_lite_contact_section_cf7'] = $cf7forms->posts[0]->ID;
		}

		$pixova_settings_page_id = Pixova_Lite_Helper::get_setting_page_id();
		update_post_meta( $pixova_settings_page_id, 'pixova-settings', $content );
		Pixova_Lite_Helper::create_content_from_options();

		// Add theme widgets
		$config = '{"blog-sidebar":{"search-2":{"title":""},"recent-posts-2":{"title":"","number":5},"recent-comments-2":{"title":"","number":5},"archives-2":{"title":"","count":0,"dropdown":0},"categories-2":{"title":"","count":0,"hierarchical":0,"dropdown":0},"meta-2":{"title":""}},"footer-sidebar-1":{"text-2":{"title":"About","text":"The many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected true of a humour.","filter":true,"visual":true}},"footer-sidebar-2":{"text-3":{"title":"Quick nav","text":"<ul id=\"menu-pixova-footer-menu\" class=\"menu\">\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#about\">About us<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#works\">Recent Works<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#testimonials\">Testimonials<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#news\">News<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#team\">Team<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t\t  <li class=\"menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item\"><a href=\"#contact\">Contact<\/a><\/li>\r\n\t\t\t\t\t\t\t\t\t  <\/ul>","filter":true,"visual":true}},"footer-sidebar-3":{"pixova_lite_widget_latest_posts-2":{"title":"Latest Posts","show_title":"1","items":"1"}},"footer-sidebar-4":{"pixova_lite_widget_social_media-2":{"title":"","show_title":"","profile_facebook":"#","profile_twitter":"#","profile_plus":"#","profile_pinterest":"#","profile_linkedin":"#","profile_youtube":"#","profile_dribbble":"#","profile_tumblr":"#","profile_instagram":"#","profile_github":"#","profile_bitbucket":"#","profile_codepen":"#"}}}';

		$config           = json_decode( $config );
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		# Parse config
		foreach ( $config as $sidebar => $elemements ) {
			# verify if the sidebar doesn't have ny widgets
			if ( false === strpos( $sidebar, 'orphaned_widgets' ) && ! is_active_sidebar( $sidebar ) ) {
				# create an empty array for active widgets
				$this_sidebar_active_widgets = array();
				# parse all widgets for current sidebar
				foreach ( $elemements as $id_widget => $args ) {
					# add current widget to current sidebar
					$this_sidebar_active_widgets[] = $id_widget;
					# split widget name in order to get widget name and index
					$id_widget_parts = explode( '-', $id_widget );
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

		return 'ok';

	}
}
