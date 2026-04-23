<?php
/**
 * Flexible layout: testimonials (card loop).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$estatein_rows = get_sub_field( 'testimonials' );
if ( ! is_array( $estatein_rows ) ) {
	$estatein_rows = array();
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

$estatein_item_count = count( $estatein_rows );
$estatein_id_attr    = $estatein_anchor !== '' ? ' id="' . esc_attr( $estatein_anchor ) . '"' : '';
?>
<section
	class="section-card-loop section-card-loop--testimonials"
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
					<?php foreach ( $estatein_rows as $estatein_post ) : ?>
						<?php
						if ( ! $estatein_post instanceof WP_Post ) {
							continue;
						}
						$estatein_tid   = (int) $estatein_post->ID;
						$estatein_rating = function_exists( 'get_field' ) ? (int) get_field( 'rating', $estatein_tid ) : 5;
						if ( $estatein_rating < 1 ) {
							$estatein_rating = 1;
						}
						if ( $estatein_rating > 5 ) {
							$estatein_rating = 5;
						}
						$estatein_loc = function_exists( 'get_field' ) ? trim( (string) get_field( 'location', $estatein_tid ) ) : '';
						$estatein_quote = wp_strip_all_tags( (string) $estatein_post->post_content );
						$estatein_quote = wp_trim_words( $estatein_quote, 42, '…' );
						$estatein_avatar = get_the_post_thumbnail_url( $estatein_tid, 'thumbnail' );
						$estatein_client = '';
						if ( function_exists( 'get_field' ) ) {
							$estatein_client = trim( (string) get_field( 'client_name', $estatein_tid ) );
						}
						if ( $estatein_client === '' ) {
							$estatein_client = get_the_author_meta( 'display_name', (int) $estatein_post->post_author );
						}
						if ( $estatein_client === '' ) {
							$estatein_client = get_the_title( $estatein_tid );
						}
						?>
						<article class="section-card-loop__card section-card-loop__card--testimonial" role="listitem">
							<div class="section-card-loop__stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d star rating */ _n( '%d star out of 5', '%d stars out of 5', $estatein_rating, 'estatein-growmodo' ), $estatein_rating ) ); ?>">
								<?php for ( $estatein_i = 1; $estatein_i <= 5; $estatein_i++ ) : ?>
									<span class="section-card-loop__star<?php echo $estatein_i <= $estatein_rating ? ' is-filled' : ''; ?>" aria-hidden="true">★</span>
								<?php endfor; ?>
							</div>
							<div class="section-card-loop__card-body">
								<h3 class="section-card-loop__card-title"><?php echo esc_html( get_the_title( $estatein_tid ) ); ?></h3>
								<?php if ( $estatein_quote !== '' ) : ?>
									<p class="section-card-loop__excerpt"><?php echo esc_html( $estatein_quote ); ?></p>
								<?php endif; ?>
								<div class="section-card-loop__author">
									<?php if ( $estatein_avatar ) : ?>
										<img class="section-card-loop__avatar" src="<?php echo esc_url( $estatein_avatar ); ?>" alt="" width="48" height="48" loading="lazy" decoding="async">
									<?php else : ?>
										<span class="section-card-loop__avatar section-card-loop__avatar--placeholder" aria-hidden="true"></span>
									<?php endif; ?>
									<div class="section-card-loop__author-text">
										<span class="section-card-loop__author-name"><?php echo esc_html( $estatein_client ); ?></span>
										<?php if ( $estatein_loc !== '' ) : ?>
											<span class="section-card-loop__author-meta"><?php echo esc_html( $estatein_loc ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<?php get_template_part( 'template-parts/components/section-loop-footer' ); ?>
		<?php endif; ?>
	</div>
</section>
