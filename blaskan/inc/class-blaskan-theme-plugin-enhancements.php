<?php

/**
 * Inform a theme user of plugins that will extend their theme's functionality.
 *
 * @link    https://github.com/Automattic/theme-tools/
 *
 * @package Blaskan
 */
class Blaskan_Theme_Plugin_Enhancements {

	/**
	 * @var array; holds the information of the plugins declared as enhancements
	 */
	var $plugins;

	/**
	 * @var boolean; whether to display an admin notice or not.
	 */
	var $display_notice = false;

	/**
	 * Init function.
	 */
	static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new Blaskan_Theme_Plugin_Enhancements;
		}

		return $instance;
	}

	/**
	 * Determine the plugin enhancements declared by the theme.
	 *
	 * Themes must declare the plugins on which they depend by using
	 * add_theme_support( 'plugin-enhancements' ).
	 *
	 * If there are plugin enhancements and any of the enhancements are
	 * either not installed or not activated, alert the user.
	 */
	function __construct() {

		// We only want to display the notice on the Dashboard, Themes, and Plugins pages.
		// Return early if we are on a different screen.
		$screen = get_current_screen();
		if ( ! in_array( $screen->base, array( 'dashboard', 'themes', 'plugins' ) ) ) {
			return;
		}

		// Get the plugin enhancements information declared by the theme.
		$this->dependencies = $this->get_theme_dependencies();

		// Return early if we have no plugin dependencies.
		if ( empty( $this->dependencies ) ) {
			return;
		}

		// Otherwise, build an array to list all the necessary dependencies and modules.
		$dependency_list = '';
		$this->modules   = array();

		// Create a list of dependencies.
		foreach ( $this->dependencies as $dependency ) :

			// Add to our list of recommended modules.
			if ( 'none' !== $dependency['module'] ) :
				$this->modules[ $dependency['name'] ] = $dependency['module'];
			endif;

			// Build human-readable list.
			$dependency_list .= $dependency['name'] . ' (' . $this->get_module_name( $dependency['module'] ) . '), ';
		endforeach;

		// Define our Jetpack plugin as a necessary plugin.
		$this->plugins = array(
			array(
				'slug'    => 'jetpack',
				'name'    => 'Jetpack by WordPress.com',
				'message' => sprintf(
					esc_html__( 'The %1$s is necessary to use some of this theme&rsquo;s features, including: ', 'blaskan' ),
					'<strong>' . esc_html__( 'Jetpack plugin', 'blaskan' ) . '</strong>' ),
				'modules' => rtrim( $dependency_list, ', ' ) . '.',
			),
		);

		// Set the status of each of these enhancements and determine if a notice is necessary.
		$this->set_plugin_status();
		$this->set_module_status();

		// Output the corresponding notices in the admin.
		if ( $this->display_notice && current_user_can( 'install_plugins' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}
	}

	/**
	 * Let's see which modules (if any!) this theme relies on.
	 */
	function get_theme_dependencies() {
		$dependencies = array();

		if ( current_theme_supports( 'jetpack-content-options' ) ) :
			$dependencies['content'] = array(
				'name'   => esc_html__( 'Content Option', 'blaskan' ),
				'slug'   => 'jetpack-content-options',
				'url'    => '',
				'module' => 'none',
			);
		endif;

		return $dependencies;
	}

	/**
	 * Set the name of our modules. This is just so we can easily refer to them in
	 * a nice, consistent, human-readable way.
	 *
	 * @param string $module The slug of the Jetpack module in question.
	 */
	function get_module_name( $module ) {
		$module_names = array(
			'none'                 => esc_html__( 'no specific module needed', 'blaskan' ),
			'custom-content-types' => esc_html__( 'Custom Content Types module', 'blaskan' ),
		);

		return $module_names[ $module ];
	}

	/**
	 * Determine the status of each of the plugins declared as a dependency
	 * by the theme and whether an admin notice is necessary or not.
	 */
	function set_plugin_status() {
		// Get the names of the installed plugins.
		$installed_plugin_names = wp_list_pluck( get_plugins(), 'Name' );

		foreach ( $this->plugins as $key => $plugin ) {

			// Determine whether a plugin is installed.
			if ( in_array( $plugin['name'], $installed_plugin_names ) ) {

				// Determine whether the plugin is active. If yes, remove if from
				// the array containing the plugin enhancements.
				if ( is_plugin_active( array_search( $plugin['name'], $installed_plugin_names ) ) ) {
					unset( $this->plugins[ $key ] );
				} // Set the plugin status as to-activate.
				else {
					$this->plugins[ $key ]['status'] = 'to-activate';
					$this->display_notice            = true;
				}

				// Set the plugin status as to-install.
			} else {
				$this->plugins[ $key ]['status'] = 'to-install';
				$this->display_notice            = true;
			}
		}
	}

	/**
	 * For Jetpack modules, we want to check and see if those modules are actually activated.
	 */
	function set_module_status() {
		$this->unactivated_modules = array();
		// Loop through each module to check if it's active.
		foreach ( $this->modules as $feature => $module ) :
			if ( class_exists( 'Jetpack' ) && ! Jetpack::is_module_active( $module ) ) :
				// Add this feature to our array.
				$this->unactivated_modules[ $module ][] = $feature;
				$this->display_notice                   = true;

			endif;
		endforeach;

	}

	/**
	 * Display the admin notice for the plugin enhancements.
	 */
	function admin_notices() {
		// Bail if the user has previously dismissed the notice (doesn't show the notice)
		if ( get_user_meta( get_current_user_id(), 'blaskan_jetpack_admin_notice', true ) === 'dismissed' ) {
			return;
		}

		$notice = '';

		// Loop through the plugins and print the message and the download or active links.
		foreach ( $this->plugins as $key => $plugin ) {
			$notice .= '<p>';

			// Custom message provided by the theme.
			if ( isset( $plugin['message'] ) ) {
				$notice .= $plugin['message'];
				$notice .= esc_html( $plugin['modules'] );
			}

			// Activation message.
			if ( 'to-activate' === $plugin['status'] ) {
				$activate_url = $this->plugin_activate_url( $plugin['slug'] );
				$notice       .= sprintf(
					esc_html__( ' Please activate %1$s. %2$s', 'blaskan' ),
					esc_html( $plugin['name'] ),
					( $activate_url ) ? '<a href="' . $activate_url . '">' . esc_html__( 'Activate', 'blaskan' ) . '</a>' : ''
				);
			}

			// Download message.
			if ( 'to-install' === $plugin['status'] ) {
				$install_url = $this->plugin_install_url( $plugin['slug'] );
				$notice      .= sprintf(
					esc_html__( ' Please install %1$s. %2$s', 'blaskan' ),
					esc_html( $plugin['name'] ),
					( $install_url ) ? '<a href="' . $install_url . '">' . esc_html__( 'Install', 'blaskan' ) . '</a>' : ''
				);
			}

			$notice .= '</p>';
		}

		// Output a notice if we're missing a module.
		foreach ( $this->unactivated_modules as $module => $features ) :
			$featurelist = array();
			foreach ( $features as $feature ) {
				$featurelist[] = $feature;
			}

			if ( 2 === count( $featurelist ) ) {
				$featurelist = implode( ' or ', $featurelist );
			} elseif ( 1 < count( $featurelist ) ) {
				$last_feature = array_pop( $featurelist );
				$featurelist  = implode( ', ', $featurelist ) . ', or ' . $last_feature;
			} else {
				$featurelist = implode( ', ', $featurelist );
			}

			$notice .= '<p>';
			$notice .= sprintf(
				esc_html__( 'To use %1$s, please activate the Jetpack plugin&rsquo;s %2$s.', 'blaskan' ),
				esc_html( $featurelist ),
				'<strong>' . esc_html( $this->get_module_name( $module ) ) . '</strong>'
			);
			$notice .= '</p>';
		endforeach;

		// Output notice HTML.
		$allowed = array(
			'p'      => array(),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
			'i'      => array(),
			'a'      => array( 'href' => array() ),
		);
		printf(
			'<div id="jetpack-notice" class="notice notice-warning is-dismissible">%s</div>',
			wp_kses( $notice, $allowed )
		);
	}

	/**
	 * Helper function to return the URL for activating a plugin.
	 *
	 * @param string $slug Plugin slug; determines which plugin to activate.
	 */
	function plugin_activate_url( $slug ) {
		// Find the path to the plugin.
		$plugin_paths = array_keys( get_plugins() );
		$plugin_path  = false;

		foreach ( $plugin_paths as $path ) {
			if ( preg_match( '|^' . $slug . '|', $path ) ) {
				$plugin_path = $path;
			}
		}

		if ( ! $plugin_path ) {
			return false;
		} else {
			return wp_nonce_url(
				self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_path ),
				'activate-plugin_' . $plugin_path
			);
		}
	}

	/**
	 * Helper function to return the URL for installing a plugin.
	 *
	 * @param string $slug Plugin slug; determines which plugin to install.
	 */
	function plugin_install_url( $slug ) {
		/*
		 * Include Plugin Install Administration API to get access to the
		 * plugins_api() function
		 */
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$plugin_information = plugins_api( 'plugin_information', array( 'slug' => $slug ) );

		if ( is_wp_error( $plugin_information ) ) {
			return false;
		} else {
			return wp_nonce_url(
				self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ),
				'install-plugin_' . $slug
			);
		}
	}
}

add_action( 'admin_head', array( 'Blaskan_Theme_Plugin_Enhancements', 'init' ) );

function enqueue_scripts() {
	// Add the admin JS if the notice has not been dismissed
	if ( is_admin() && get_user_meta( get_current_user_id(), 'blaskan_jetpack_admin_notice', true ) !== 'dismissed' ) {

		// Adds our JS file to the queue that WordPress will load
		wp_enqueue_script( 'blaskan_jetpack_admin_script', get_template_directory_uri() . '/assets/js/plugin-enhancements.js', array( 'jquery' ), '20160624', true );

		// Make some data available to our JS file
		wp_localize_script( 'blaskan_jetpack_admin_script', 'blaskan_jetpack_admin', array(
			'blaskan_jetpack_admin_nonce' => wp_create_nonce( 'blaskan_jetpack_admin_nonce' ),
		) );
	}
}

add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );

/**
 *    Process the AJAX request on the server and send a response back to the JS.
 *    If nonce is valid, update the current user's meta to prevent notice from displaying.
 */
function dismiss_admin_notice() {
	// Verify the security nonce and die if it fails
	if ( ! isset( $_POST['blaskan_jetpack_admin_nonce'] ) || ! wp_verify_nonce( $_POST['blaskan_jetpack_admin_nonce'], 'blaskan_jetpack_admin_nonce' ) ) {
		wp_die( esc_html__( 'Your request failed permission check.', 'blaskan' ) );
	}
	// Store the user's dimissal so that the notice doesn't show again
	update_user_meta( get_current_user_id(), 'blaskan_jetpack_admin_notice', 'dismissed' );
	// Send success message
	wp_send_json( array(
		              'status'  => 'success',
		              'message' => esc_html__( 'Your request was processed. See ya!', 'blaskan' )
	              ) );
}

add_action( 'wp_ajax_blaskan_jetpack_admin_notice', 'dismiss_admin_notice' );

