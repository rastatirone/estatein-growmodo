<?php
/**
 * Flexible layout: faq_cards (card loop).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$estatein_items_raw = get_sub_field( 'faq_items' );
$estatein_items    = array();
if ( is_array( $estatein_items_raw ) ) {
	foreach ( $estatein_items_raw as $estatein_r ) {
		if ( ! is_array( $estatein_r ) ) {
			continue;
		}
		$estatein_qt = isset( $estatein_r['question'] ) ? trim( (string) $estatein_r['question'] ) : '';
		if ( $estatein_qt !== '' ) {
			$estatein_items[] = $estatein_r;
		}
	}
}

$estatein_per_view = (int) get_sub_field( 'cards_per_view' );
if ( $estatein_per_view < 1 || $estatein_per_view > 6 ) {
	$estatein_per_view = 3;
}

$estatein_anchor = get_sub_field( 'section_html_id' );
$estatein_anchor = is_string( $estatein_anchor ) ? sanitize_title( trim( $estatein_anchor ) ) : '';

set_query_var(
	'estatein_section_header',
	array(
		'section_title'   => get_sub_field( 'section_title' ),
		'section_subtext' => get_sub_field( 'section_subtext' ),
		'section_cta'     => get_sub_field( 'section_cta' ),
	)
);

$estatein_item_count = count( $estatein_items );
$estatein_id_attr    = $estatein_anchor !== '' ? ' id="' . esc_attr( $estatein_anchor ) . '"' : '';
?>
<section
	class="section-card-loop section-card-loop--faq-cards"
	<?php echo $estatein_id_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-per-view-desktop="<?php echo (int) $estatein_per_view; ?>"
	data-per-view-mobile="1"
	data-item-count="<?php echo (int) $estatein_item_count; ?>"
>
	<div class="container">
		<?php get_template_part( 'template-parts/components/section-loop-header' ); ?>

		<?php if ( $estatein_item_count > 0 ) : ?>
			<div class="section-card-loop__viewport">
				<div class="section-card-loop__track" role="list">
					<?php foreach ( $estatein_items as $estatein_row ) : ?>
						<?php
						$estatein_q = isset( $estatein_row['question'] ) ? trim( (string) $estatein_row['question'] ) : '';
						$estatein_excerpt = isset( $estatein_row['excerpt'] ) ? trim( (string) $estatein_row['excerpt'] ) : '';
						$estatein_link    = isset( $estatein_row['read_more'] ) && is_array( $estatein_row['read_more'] ) ? $estatein_row['read_more'] : array();
						?>
						<article class="section-card-loop__card section-card-loop__card--faq" role="listitem">
							<div class="section-card-loop__card-body">
								<h3 class="section-card-loop__card-title"><?php echo esc_html( $estatein_q ); ?></h3>
								<?php if ( $estatein_excerpt !== '' ) : ?>
									<div class="section-card-loop__excerpt section-card-loop__excerpt--faq">
										<?php echo wp_kses_post( wpautop( $estatein_excerpt ) ); ?>
									</div>
								<?php endif; ?>
								<?php if ( estatein_card_loop_link_is_usable( $estatein_link ) ) : ?>
									<?php
									$estatein_lm_target = ! empty( $estatein_link['target'] ) ? $estatein_link['target'] : '_self';
									$estatein_lm_rel    = '_blank' === $estatein_lm_target ? 'noopener noreferrer' : '';
									$estatein_lm_label  = ! empty( $estatein_link['title'] ) ? $estatein_link['title'] : __( 'Read More', 'estatein-growmodo' );
									?>
									<a
										class="section-card-loop__faq-cta"
										href="<?php echo esc_url( $estatein_link['url'] ); ?>"
										target="<?php echo esc_attr( $estatein_lm_target ); ?>"
										<?php echo $estatein_lm_rel ? ' rel="' . esc_attr( $estatein_lm_rel ) . '"' : ''; ?>
									><?php echo esc_html( $estatein_lm_label ); ?></a>
								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<?php get_template_part( 'template-parts/components/section-loop-footer' ); ?>
		<?php endif; ?>
	</div>
</section>
