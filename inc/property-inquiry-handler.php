<?php
/**
 * Handle property inquiry form POST (admin-post.php).
 *
 * @package estatein-growmodo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register inquiry POST handlers.
 */
function estatein_property_inquiry_handler_bootstrap() {
	add_action( 'admin_post_estatein_property_inquiry', 'estatein_property_inquiry_process' );
	add_action( 'admin_post_nopriv_estatein_property_inquiry', 'estatein_property_inquiry_process' );
}
add_action( 'init', 'estatein_property_inquiry_handler_bootstrap' );

/**
 * Process inquiry form.
 */
function estatein_property_inquiry_process() {
	if ( ! isset( $_POST['estatein_inquiry_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( (string) $_POST['estatein_inquiry_nonce'] ) ), 'estatein_property_inquiry' ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	if ( ! empty( $_POST['estatein_company'] ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$property_id = isset( $_POST['property_id'] ) ? absint( $_POST['property_id'] ) : 0;
	if ( $property_id < 1 || 'property' !== get_post_type( $property_id ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$first = isset( $_POST['inquiry_first_name'] ) ? sanitize_text_field( wp_unslash( (string) $_POST['inquiry_first_name'] ) ) : '';
	$last  = isset( $_POST['inquiry_last_name'] ) ? sanitize_text_field( wp_unslash( (string) $_POST['inquiry_last_name'] ) ) : '';
	$email = isset( $_POST['inquiry_email'] ) ? sanitize_email( wp_unslash( (string) $_POST['inquiry_email'] ) ) : '';
	$phone = isset( $_POST['inquiry_phone'] ) ? sanitize_text_field( wp_unslash( (string) $_POST['inquiry_phone'] ) ) : '';
	$msg   = isset( $_POST['inquiry_message'] ) ? sanitize_textarea_field( wp_unslash( (string) $_POST['inquiry_message'] ) ) : '';

	if ( $first === '' || $last === '' || $email === '' || ! is_email( $email ) ) {
		wp_safe_redirect(
			add_query_arg(
				'inquiry',
				'error',
				get_permalink( $property_id )
			)
		);
		exit;
	}

	$agree = isset( $_POST['inquiry_agree'] ) ? (string) wp_unslash( $_POST['inquiry_agree'] ) : '';
	if ( $agree !== '1' ) {
		wp_safe_redirect(
			add_query_arg(
				'inquiry',
				'error',
				get_permalink( $property_id )
			)
		);
		exit;
	}

	$to = '';
	if ( function_exists( 'get_field' ) ) {
		$acf_mail = get_field( 'inquiry_email', $property_id );
		if ( is_string( $acf_mail ) && is_email( $acf_mail ) ) {
			$to = $acf_mail;
		}
	}
	if ( $to === '' ) {
		$to = (string) get_option( 'admin_email' );
	}

	$title = get_the_title( $property_id );
	/* translators: %s: property title */
	$subject = sprintf( __( '[Estatein] Inquiry about %s', 'estatein-growmodo' ), $title );

	$lines   = array(
		sprintf( "Property: %s (#%d)\n", $title, $property_id ),
		sprintf( "Name: %s %s\n", $first, $last ),
		sprintf( "Email: %s\n", $email ),
		sprintf( "Phone: %s\n", $phone ),
		"\nMessage:\n" . $msg . "\n",
	);
	$body    = implode( '', $lines );
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect(
		add_query_arg(
			'inquiry',
			'sent',
			get_permalink( $property_id )
		)
	);
	exit;
}
