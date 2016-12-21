<?php
/**
 * A Dashboard Notice Settings
 */

if ( ! class_exists( 'ADN_Settings' ) ) :

class ADN_Settings {

	public $options_capability = 'manage_options';

	public $options = array();

	const SLUG = 'a_dashboard_notice';

	protected static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new ADN_Settings;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	protected function __construct() {
		/** Don't do anything **/
	}

	protected function setup_actions() {
		add_action( 'admin_init', array( self::$instance, 'action_admin_init' ) );
		add_action( 'admin_menu', array( self::$instance, 'action_admin_menu' ) );
	}

	public function get_options() {
		if ( empty( $this->options ) ) {
			$this->options = get_option( self::SLUG );
		}
		return $this->options;
	}

	public function get_option( $key ) {
		$this->get_options();
		return isset( $this->options[ $key ] ) ? $this->options[ $key ] : null;
	}

	public function action_admin_init() {
		register_setting( self::SLUG, self::SLUG, array( self::$instance, 'sanitize_options' ) );
		add_settings_section( 'general', false, '__return_false', self::SLUG );
		add_settings_field( 'notice', __( 'Notice', 'adn' ), array( self::$instance, 'field' ), self::SLUG, 'general', array( 'field' => 'notice', 'type' => 'textarea' ) );
		add_settings_field( 'enabled', __( 'Enabled', 'adn' ), array( self::$instance, 'field' ), self::SLUG, 'general', array( 'field' => 'enabled', 'type' => 'checkbox' ) );
	}

	public function action_admin_menu() {
		add_options_page( __( 'A Dashboard Notice', 'adn' ), __( 'A Dashboard Notice', 'adn' ), $this->options_capability, self::SLUG, array( self::$instance, 'view_settings_page' ) );
	}

	public function field( $args ) {
		$args = wp_parse_args( $args, array(
			'type' => 'text'
		) );

		if ( empty( $args['field'] ) ) {
			return;
		}

		switch ( $args['type'] ) {
			case 'textarea' :
				printf(
					'<textarea name="%s[%s]" cols="50" rows="5">%s</textarea>',
					esc_attr( self::SLUG ),
					esc_attr( $args['field'] ),
					esc_html( $this->get_option( $args['field'] ) )
				);
				break;

			case 'checkbox' :
				printf(
					'<input type="checkbox" name="%s[%s]" value="1" %s />',
					esc_attr( self::SLUG ),
					esc_attr( $args['field'] ),
					checked( $this->get_option( $args['field'] ), true, false )
				);
				break;

			default:
				printf(
					'<input type="%s" name="%s[%s]" value="%s" size="50" />',
					esc_attr( $args['type'] ),
					esc_attr( self::SLUG ),
					esc_attr( $args['field'] ),
					esc_attr( $this->get_option( $args['field'] ) )
				);
				break;
		}
	}

	public function sanitize_options( $in ) {
		$out = array();

		$out['enabled'] = isset( $in['enabled'] ) && $in['enabled'] === '1' ? 1 : 0;
		$out['notice'] = isset( $in['notice'] ) ? sanitize_text_field( $in['notice'] ) : '';

		return $out;
	}

	public function view_settings_page() {
		?>
		<style>
		#adn h1::before {
			content: "\f488";
			display: inline-block;
			-webkit-font-smoothing: antialiased;
			font: normal 23px/1.1 'dashicons';
			margin-right: 5px;
			vertical-align: top;
		}
		</style>
		<div id="adn" class="wrap">
			<h1><?php esc_html_e( 'A Dashboard Notice', 'adn' ); ?></h1>
			<form action="options.php" method="POST">
				<?php settings_fields( self::SLUG ); ?>
				<?php do_settings_sections( self::SLUG ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

}

function ADN_Settings() {
	return ADN_Settings::instance();
}
add_action( 'after_setup_theme', 'ADN_Settings' );

endif;
