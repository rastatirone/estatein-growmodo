<?php
/**
 * Outro CTA section (ACF Theme Settings).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$estatein_outro_title = get_field( 'outro_title', 'option' );
$estatein_outro_text  = get_field( 'outro_content', 'option' );
$estatein_outro_btn   = get_field( 'outro_button', 'option' );

$estatein_has_btn = is_array( $estatein_outro_btn ) && ! empty( $estatein_outro_btn['url'] );
$estatein_has_any = (
	( is_string( $estatein_outro_title ) && $estatein_outro_title !== '' )
	|| ( is_string( $estatein_outro_text ) && $estatein_outro_text !== '' )
	|| $estatein_has_btn
);

if ( ! $estatein_has_any ) {
	return;
}

$estatein_outro_img_base = get_template_directory_uri() . '/assets/images';
?>
<section class="outro-cta" aria-label="<?php esc_attr_e( 'Call to action', 'estatein-growmodo' ); ?>">
	<div class="outro-cta__abstract outro-cta__abstract--1" aria-hidden="true">
		<img
			class="outro-cta__abstract-img"
			src="<?php echo esc_url( $estatein_outro_img_base . '/abstract-background-1.webp' ); ?>"
			alt=""
			width="560"
			height="420"
			loading="lazy"
			decoding="async"
		>
	</div>
	<div class="outro-cta__abstract outro-cta__abstract--2" aria-hidden="true">
		<img
			class="outro-cta__abstract-img"
			src="<?php echo esc_url( $estatein_outro_img_base . '/abstract-background-2.webp' ); ?>"
			alt=""
			width="560"
			height="420"
			loading="lazy"
			decoding="async"
		>
	</div>
	<div class="container outro-cta__inner">
		<div class="outro-cta__content">
			<?php if ( is_string( $estatein_outro_title ) && $estatein_outro_title !== '' ) : ?>
				<h2><?php echo esc_html( $estatein_outro_title ); ?></h2>
			<?php endif; ?>
			<?php if ( is_string( $estatein_outro_text ) && $estatein_outro_text !== '' ) : ?>
				<?php
				$estatein_outro_trim = trim( $estatein_outro_text );
				if ( strpos( $estatein_outro_trim, '<' ) === false ) :
					?>
					<p class="outro-cta__text"><?php echo nl2br( esc_html( $estatein_outro_text ), false ); ?></p>
				<?php else : ?>
					<div class="outro-cta__text"><?php echo wp_kses_post( $estatein_outro_text ); ?></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php if ( $estatein_has_btn ) : ?>
			<?php
			$estatein_btn_target = ! empty( $estatein_outro_btn['target'] ) ? $estatein_outro_btn['target'] : '_self';
			$estatein_btn_rel    = '_blank' === $estatein_btn_target ? 'noopener noreferrer' : '';
			$estatein_btn_label  = ! empty( $estatein_outro_btn['title'] ) ? $estatein_outro_btn['title'] : __( 'Explore Properties', 'estatein-growmodo' );
			?>
			<div class="outro-cta__action">
				<a class="btn-primary outro-cta__btn" href="<?php echo esc_url( $estatein_outro_btn['url'] ); ?>" target="<?php echo esc_attr( $estatein_btn_target ); ?>"<?php echo $estatein_btn_rel ? ' rel="' . esc_attr( $estatein_btn_rel ) . '"' : ''; ?>>
					<?php echo esc_html( $estatein_btn_label ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
