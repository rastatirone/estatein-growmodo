<?php
/**
 * Shared header for card-loop sections (section graphics WEBP, title, subtext, right CTA).
 *
 * Expects `get_query_var( 'estatein_section_header' )` as an array:
 * section_title (string), section_subtext (string), section_cta (link array|null).
 *
 * @package estatein-growmodo
 */

$h = get_query_var( 'estatein_section_header', array() );
if ( ! is_array( $h ) ) {
	$h = array();
}

$estatein_title = isset( $h['section_title'] ) ? trim( (string) $h['section_title'] ) : '';
$estatein_sub   = isset( $h['section_subtext'] ) ? trim( (string) $h['section_subtext'] ) : '';
$estatein_cta   = isset( $h['section_cta'] ) && is_array( $h['section_cta'] ) ? $h['section_cta'] : array();

set_query_var( 'estatein_toolbar_cta', array() );

if ( $estatein_title === '' && $estatein_sub === '' && ! estatein_card_loop_link_is_usable( $estatein_cta ) ) {
	return;
}

$estatein_section_graphics_uri = get_template_directory_uri() . '/assets/images';
?>
<header class="section-card-loop__header">
	<div class="section-card-loop__header-main">
		<div class="section-card-loop__sparkles" aria-hidden="true">
			<img
				class="section-card-loop__sparkle section-card-loop__sparkle--lg"
				src="<?php echo esc_url( $estatein_section_graphics_uri . '/graphic-20.webp' ); ?>"
				alt=""
				width="40"
				height="40"
				loading="eager"
				decoding="async"
			>
			<img
				class="section-card-loop__sparkle section-card-loop__sparkle--md"
				src="<?php echo esc_url( $estatein_section_graphics_uri . '/graphic-21.webp' ); ?>"
				alt=""
				width="24"
				height="24"
				loading="eager"
				decoding="async"
			>
			<img
				class="section-card-loop__sparkle section-card-loop__sparkle--sm"
				src="<?php echo esc_url( $estatein_section_graphics_uri . '/graphic-22.webp' ); ?>"
				alt=""
				width="14"
				height="14"
				loading="eager"
				decoding="async"
			>
		</div>
		<?php if ( $estatein_title !== '' ) : ?>
			<h2 class="section-card-loop__heading"><?php echo esc_html( $estatein_title ); ?></h2>
		<?php endif; ?>
		<?php if ( $estatein_sub !== '' ) : ?>
			<div class="section-card-loop__subtext">
				<p><?php echo nl2br( esc_html( $estatein_sub ), false ); ?></p>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( estatein_card_loop_link_is_usable( $estatein_cta ) ) : ?>
		<?php
		$estatein_cta_target = ! empty( $estatein_cta['target'] ) ? $estatein_cta['target'] : '_self';
		$estatein_cta_rel    = '_blank' === $estatein_cta_target ? 'noopener noreferrer' : '';
		$estatein_cta_label  = ! empty( $estatein_cta['title'] ) ? $estatein_cta['title'] : __( 'View all', 'estatein-growmodo' );
		?>
		<div class="section-card-loop__header-cta">
			<a
				class="section-card-loop__section-cta"
				href="<?php echo esc_url( $estatein_cta['url'] ); ?>"
				target="<?php echo esc_attr( $estatein_cta_target ); ?>"
				<?php echo $estatein_cta_rel ? ' rel="' . esc_attr( $estatein_cta_rel ) . '"' : ''; ?>
			><?php echo esc_html( $estatein_cta_label ); ?></a>
		</div>
		<?php set_query_var( 'estatein_toolbar_cta', $estatein_cta ); ?>
	<?php endif; ?>
</header>
