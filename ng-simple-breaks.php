<?php
/*
 * Plugin Name: NG Simple Breaks
 * Plugin URI: https://www.nosegraze.com
 * Description: Adds in [br] [clearleft] [clearright] [clearboth] [hr] [space] shortcodes to use in posts and pages.
 * Version: 1.0
 * Author: Nose Graze
 * Author URI: https://www.nosegraze.com
 * License: GPL2
 *
 * NG Simple Breaks is based on the "Simple Breaks" plugin by Hit Reach. "Simple Breaks" is licensed under GPL.
 * @link https://wordpress.org/plugins/simple-breaks/
 * 
 * @package ng-simple-breaks
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license GPL2+
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'NG_Simple_Breaks' ) ) {

	class NG_Simple_Breaks {

		/**
		 * NG_Simple_Breaks constructor.
		 *
		 * @access public
		 * @since  1.0
		 * @return void
		 */
		public function __construct() {

			$this->define_constants();
			$this->add_shortcodes();

			// TinyMCE
			add_action( 'admin_head', array( $this, 'add_tinymce_buttons' ) );

		}

		/**
		 * Define Constants
		 *
		 * @access private
		 * @since  1.0
		 * @return void
		 */
		private function define_constants() {

			// Plugin version.
			if ( ! defined( 'NG_SB_VERSION' ) ) {
				define( 'NG_SB_VERSION', '1.0' );
			}
			// Plugin Folder Path.
			if ( ! defined( 'NG_SB_PLUGIN_DIR' ) ) {
				define( 'NG_SB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			// Plugin Folder URL.
			if ( ! defined( 'NG_SB_PLUGIN_URL' ) ) {
				define( 'NG_SB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
			// Plugin Root File.
			if ( ! defined( 'NG_SB_PLUGIN_FILE' ) ) {
				define( 'NG_SB_PLUGIN_FILE', __FILE__ );
			}

		}

		/**
		 * Registers all shortcodes with WordPress.
		 *
		 * @access private
		 * @since  1.0
		 * @return void
		 */
		private function add_shortcodes() {

			add_shortcode( 'br', array( $this, 'br_shortcode' ) );
			add_shortcode( 'clearleft', array( $this, 'clear_left_shortcode' ) );
			add_shortcode( 'clearboth', array( $this, 'clear_both_shortcode' ) );
			add_shortcode( 'clearright', array( $this, 'clear_right_shortcode' ) );
			add_shortcode( 'hr', array( $this, 'hr_shortcode' ) );
			add_shortcode( 'space', array( $this, 'spacer_shortcode' ) );

		}

		/**
		 * Shortcode: [br]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function br_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => ''
			), $atts, 'br' );

			$attributes = array();

			// Add class.
			$atts['class'] = empty( $atts['class'] ) ? 'sb-br' : $atts['class'] . ' sb-br';
			$attributes[]  = 'class="' . esc_attr( $atts['class'] ) . '"';

			// Add ID attributes.
			if ( ! empty( $atts['id'] ) ) {
				$attributes[] = 'id="' . $atts['id'] . '"';
			}

			return '<br ' . implode( ' ', $attributes ) . '>';

		}

		/**
		 * Shortcode: [clearleft]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function clear_left_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => '',
				'span'  => false
			), $atts, 'clearleft' );

			return $this->build_clear_tag( $atts, 'left' );

		}

		/**
		 * Shortcode: [clearboth]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function clear_both_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => '',
				'span'  => false
			), $atts, 'clearboth' );

			return $this->build_clear_tag( $atts, 'both' );

		}

		/**
		 * Shortcode: [clearright]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function clear_right_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => '',
				'span'  => false
			), $atts, 'clearright' );

			return $this->build_clear_tag( $atts, 'right' );

		}

		/**
		 * Build Clear Tag
		 *
		 * Creates the HTML tag for all of the 'clear' shortcodes.
		 *
		 * @param array  $atts
		 * @param string $clear
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function build_clear_tag( $atts, $clear = 'both' ) {

			$attributes = array();

			switch ( $clear ) {
				case 'left' :
					$class = 'sb-cl';
					break;
				case 'right' :
					$class = 'sb-cr';
					break;
				default :
					$class = 'sb-cb';
					break;
			}

			// Add class.
			$atts['class'] = empty( $atts['class'] ) ? sanitize_html_class( $class ) : $atts['class'] . ' ' . sanitize_html_class( $clear );
			$attributes[]  = 'class="' . esc_attr( $atts['class'] ) . '"';

			// Add ID attributes.
			if ( ! empty( $atts['id'] ) ) {
				$attributes[] = 'id="' . $atts['id'] . '"';
			}

			// Add CSS style.
			$attributes[] = 'style="clear: ' . esc_attr( $clear ) . ';"';

			$html_tag = ( false === $atts['span'] ) ? 'div' : 'span';

			return '<' . $html_tag . ' ' . implode( ' ', $attributes ) . '></' . $html_tag . '>';

		}

		/**
		 * Shortcode: [hr]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function hr_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => '',
				'size'  => 1,
				'color' => 'black'
			), $atts, 'hr' );

			$attributes = array();

			// Add class.
			$atts['class'] = empty( $atts['class'] ) ? 'sb-hr' : $atts['class'] . ' sb-hr';
			$attributes[]  = 'class="' . esc_attr( $atts['class'] ) . '"';

			// Add ID attributes.
			if ( ! empty( $atts['id'] ) ) {
				$attributes[] = 'id="' . $atts['id'] . '"';
			}

			// Add style attributes.
			$attributes[] = 'style="border: none; height: ' . absint( $atts['size'] ) . 'px; background: ' . $atts['color'] . ';"';

			return '<hr ' . implode( ' ', $attributes ) . '>';

		}

		/**
		 * Shortcode: [space]
		 *
		 * @param array $atts Shortcode attributes
		 *
		 * @access public
		 * @since  1.0
		 * @return string
		 */
		public function spacer_shortcode( $atts ) {

			$atts = shortcode_atts( array(
				'id'    => '',
				'class' => '',
				'size'  => 1
			), $atts, 'space' );

			$attributes = array();

			// Add class.
			$atts['class'] = empty( $atts['class'] ) ? 'sb-sp' : $atts['class'] . ' sb-sp';
			$attributes[]  = 'class="' . esc_attr( $atts['class'] ) . '"';

			// Add ID attributes.
			if ( ! empty( $atts['id'] ) ) {
				$attributes[] = 'id="' . $atts['id'] . '"';
			}

			// Add style attributes.
			$attributes[] = 'style="height: ' . absint( $atts['size'] ) . 'px; margin: 0; padding: 0;"';

			return '<div ' . implode( ' ', $attributes ) . '></div>';

		}

		/**
		 * Add TinyMCE Buttons
		 *
		 * @access public
		 * @since  1.0
		 * @return void
		 */
		public function add_tinymce_buttons() {

			// Make sure the user has the right permissions.
			if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
				return;
			}
			// Add the button only if WYSIWYG is enabled.
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_js' ) );
				add_filter( 'mce_buttons', array( $this, 'register_tinymce_button' ) );
			}

		}

		/**
		 * Add TinyMCE JavaScript
		 *
		 * @param array $plugin_array
		 *
		 * @access public
		 * @since  1.0.0
		 * @return array
		 */
		public function add_tinymce_js( $plugin_array ) {

			$plugin_array['ng_sb_button'] = NG_SB_PLUGIN_URL . 'tinymce.js';

			return $plugin_array;

		}

		/**
		 * Adds the Simple Breaks button to the array of buttons.
		 *
		 * @param array $buttons
		 *
		 * @access public
		 * @since  1.0
		 * @return array
		 */
		public function register_tinymce_button( $buttons ) {

			array_push( $buttons, 'ng_sb_button' );

			return $buttons;

		}

	}

}

new NG_Simple_Breaks();