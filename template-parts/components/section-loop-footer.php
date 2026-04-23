<?php
/**
 * Pagination + prev/next for card-loop sections (updated by JS).
 * Optional section CTA (mobile): query var `estatein_toolbar_cta` (same shape as ACF link array).
 *
 * @package estatein-growmodo
 */

$estatein_toolbar_cta = get_query_var( 'estatein_toolbar_cta', array() );
$estatein_nav_icon_uri = get_template_directory_uri() . '/assets/images/svg-vector-17.svg';
?>
<footer class="section-card-loop__toolbar">
	<?php if ( function_exists( 'estatein_card_loop_link_is_usable' ) && estatein_card_loop_link_is_usable( $estatein_toolbar_cta ) ) : ?>
		<?php
		$estatein_tb_target = ! empty( $estatein_toolbar_cta['target'] ) ? $estatein_toolbar_cta['target'] : '_self';
		$estatein_tb_rel    = '_blank' === $estatein_tb_target ? 'noopener noreferrer' : '';
		$estatein_tb_label  = ! empty( $estatein_toolbar_cta['title'] ) ? $estatein_toolbar_cta['title'] : __( 'View all', 'estatein-growmodo' );
		?>
		<div class="section-card-loop__toolbar-cta">
			<a
				class="section-card-loop__section-cta"
				href="<?php echo esc_url( $estatein_toolbar_cta['url'] ); ?>"
				target="<?php echo esc_attr( $estatein_tb_target ); ?>"
				<?php echo $estatein_tb_rel ? ' rel="' . esc_attr( $estatein_tb_rel ) . '"' : ''; ?>
			><?php echo esc_html( $estatein_tb_label ); ?></a>
		</div>
	<?php endif; ?>
	<div
		class="section-card-loop__toolbar-controls"
		role="group"
		aria-label="<?php esc_attr_e( 'Carousel controls', 'estatein-growmodo' ); ?>"
	>
		<p class="section-card-loop__pagination" aria-live="polite">
			<span class="section-card-loop__page-current">01</span>
			<span class="section-card-loop__pagination-sep"><?php esc_html_e( 'of', 'estatein-growmodo' ); ?></span>
			<span class="section-card-loop__page-total">01</span>
		</p>
		<div class="section-card-loop__toolbar-arrows">
			<button type="button" class="section-card-loop__arrow section-card-loop__arrow--prev" aria-label="<?php esc_attr_e( 'Previous slides', 'estatein-growmodo' ); ?>">
				<img
					class="section-card-loop__arrow-icon"
					src="<?php echo esc_url( $estatein_nav_icon_uri ); ?>"
					alt=""
					width="21"
					height="18"
					decoding="async"
				>
			</button>
			<button type="button" class="section-card-loop__arrow section-card-loop__arrow--next" aria-label="<?php esc_attr_e( 'Next slides', 'estatein-growmodo' ); ?>">
				<img
					class="section-card-loop__arrow-icon section-card-loop__arrow-icon--flip"
					src="<?php echo esc_url( $estatein_nav_icon_uri ); ?>"
					alt=""
					width="21"
					height="18"
					decoding="async"
				>
			</button>
		</div>
	</div>
</footer>
