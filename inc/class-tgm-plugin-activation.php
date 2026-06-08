<?php
/**
 * TGM Plugin Activation — Lumea bundled copy.
 *
 * Declares required/recommended plugins to WordPress and shows
 * admin notices with install/activate links when they are missing.
 *
 * @package Lumea
 * @license GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {

	
	class TGM_Plugin_Activation {

		
		protected static $_instance = null;

		
		public $plugins = array();

		
		public $id = 'tgmpa';

		
		public $parent_slug = 'themes.php';

		
		public $capability = 'edit_theme_options';

		
		public $has_notices = true;

		
		public $dismissable = true;

		
		public $default_path = '';

		
		public $is_automatic = false;

		
		public $message = '';

		
		public static function get_instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		
		protected function __construct() {
			add_action( 'after_setup_theme', array( $this, 'init' ), 1 );
		}

		
		public function init() {
			do_action( 'tgmpa_register' );

			if ( empty( $this->plugins ) ) {
				return;
			}

			if ( $this->has_notices ) {
				add_action( 'admin_notices', array( $this, 'notices' ) );
			}

			if ( $this->is_automatic ) {
				add_action( 'admin_init', array( $this, 'maybe_auto_activate' ) );
			}
		}

		
		public function register( array $plugins, array $config = array() ) {
			foreach ( $plugins as $plugin ) {
				$plugin = wp_parse_args(
					$plugin,
					array(
						'name'               => '',
						'slug'               => '',
						'source'             => 'repo',
						'required'           => false,
						'version'            => '',
						'force_activation'   => false,
						'force_deactivation' => false,
						'external_url'       => '',
					)
				);

				if ( empty( $plugin['slug'] ) ) {
					continue;
				}

				$this->plugins[ $plugin['slug'] ] = $plugin;
			}

			foreach ( $config as $key => $value ) {
				if ( property_exists( $this, $key ) ) {
					$this->$key = $value;
				}
			}
		}

		
		public function notices() {
			if ( ! current_user_can( $this->capability ) ) {
				return;
			}

			$missing_required    = array();
			$missing_recommended = array();

			foreach ( $this->plugins as $slug => $plugin ) {
				if ( $this->is_plugin_active( $slug ) ) {
					continue;
				}
				if ( $plugin['required'] ) {
					$missing_required[ $slug ] = $plugin;
				} else {
					$missing_recommended[ $slug ] = $plugin;
				}
			}

			if ( ! empty( $missing_required ) ) {
				$this->render_notice( $missing_required, 'error', true );
			}

			if ( ! empty( $missing_recommended ) ) {
				$this->render_notice( $missing_recommended, 'warning', false );
			}
		}

		
		protected function render_notice( array $plugins, $type, $required ) {
			$theme_name = esc_html( wp_get_theme()->get( 'Name' ) );
			$names      = array_map( function ( $p ) { return '<strong>' . esc_html( $p['name'] ) . '</strong>'; }, $plugins );
			$name_list  = implode( ', ', $names );

			if ( $required ) {
				$message = sprintf(
					/* translators: 1: theme name, 2: comma-separated plugin name(s). */
					esc_html__( '%1$s requires the following plugin(s) to work correctly: %2$s.', 'lumea' ),
					'<strong>' . $theme_name . '</strong>',
					$name_list
				);
			} else {
				$message = sprintf(
					/* translators: 1: theme name, 2: comma-separated plugin name(s). */
					esc_html__( '%1$s recommends installing: %2$s.', 'lumea' ),
					'<strong>' . $theme_name . '</strong>',
					$name_list
				);
			}

			echo '<div class="notice notice-' . esc_attr( $type ) . '">';
			if ( $this->message ) {
				echo '<p>' . wp_kses_post( $this->message ) . '</p>';
			}
			echo '<p>' . wp_kses( $message, array( 'strong' => array() ) );

			foreach ( $plugins as $slug => $plugin ) {
				if ( ! $this->is_plugin_installed( $slug ) ) {
					$install_url = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => $slug,
							),
							admin_url( 'update.php' )
						),
						'install-plugin_' . $slug
					);
					echo ' &mdash; <a href="' . esc_url( $install_url ) . '">' . esc_html__( 'Install Now', 'lumea' ) . '</a>';
				} elseif ( ! $this->is_plugin_active( $slug ) ) {
					$activate_url = wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'activate',
								'plugin' => $slug . '/' . $slug . '.php',
							),
							admin_url( 'plugins.php' )
						),
						'activate-plugin_' . $slug . '/' . $slug . '.php'
					);
					echo ' &mdash; <a href="' . esc_url( $activate_url ) . '">' . esc_html__( 'Activate Now', 'lumea' ) . '</a>';
				}
			}

			echo '</p></div>';
		}

		
		public function maybe_auto_activate() {
			foreach ( $this->plugins as $slug => $plugin ) {
				if ( ! empty( $plugin['force_activation'] ) && ! $this->is_plugin_active( $slug ) ) {
					$file = $slug . '/' . $slug . '.php';
					if ( $this->is_plugin_installed( $slug ) ) {
						activate_plugin( $file );
					}
				}
			}
		}

		
		protected function is_plugin_active( $slug ) {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			return is_plugin_active( $slug . '/' . $slug . '.php' );
		}

		
		protected function is_plugin_installed( $slug ) {
			$plugin_file = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
			return file_exists( $plugin_file );
		}
	}
}

if ( ! function_exists( 'tgmpa' ) ) {
	
	function tgmpa( array $plugins, array $config = array() ) {
		TGM_Plugin_Activation::get_instance()->register( $plugins, $config );
	}
}
