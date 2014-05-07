<?php

/**
 * Get the notice.
 *
 * @return string|bool The text, or false if none exists or the notice is disabled.
 */
function adn_get_notice() {
	if ( $settings = get_option( ADN_Settings::SLUG ) ) {
		if ( $settings['enabled'] && ! empty( $settings['notice'] ) ) {
			return $settings['notice'];
		}
	}

	return false;
}

/**
 * Display the notice.
 *
 * @return void.
 */
function adn_display_notice() {
	if ( $notice = adn_get_notice() ) :
		?>
		<div class="error">
			<p><?php echo make_clickable( esc_html( $notice ) ); ?></p>
		</div>
		<?php
	endif;
}
add_action( 'admin_notices', 'adn_display_notice' );
