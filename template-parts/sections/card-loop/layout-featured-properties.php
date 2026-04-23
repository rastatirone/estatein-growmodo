<?php
/**
 * Flexible layout: featured_properties (card loop).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_sub_field' ) ) {
	return;
}

$estatein_props = get_sub_field( 'properties' );
if ( ! is_array( $estatein_props ) ) {
	$estatein_props = array();
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

$estatein_item_count   = count( $estatein_props );
$estatein_id_attr      = $estatein_anchor !== '' ? ' id="' . esc_attr( $estatein_anchor ) . '"' : '';
$estatein_pill_icon_uri = get_template_directory_uri() . '/assets/images';
?>
<section
	class="section-card-loop section-card-loop--featured-properties"
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
					<?php foreach ( $estatein_props as $estatein_post ) : ?>
						<?php
						if ( ! $estatein_post instanceof WP_Post ) {
							continue;
						}
						$estatein_pid = (int) $estatein_post->ID;
						$estatein_img = function_exists( 'estatein_card_loop_property_card_image_url' )
							? estatein_card_loop_property_card_image_url( $estatein_pid )
							: get_the_post_thumbnail_url( $estatein_pid, 'large' );
						$estatein_bed = function_exists( 'get_field' ) ? get_field( 'bedrooms', $estatein_pid ) : null;
						$estatein_bath = function_exists( 'get_field' ) ? get_field( 'bathrooms', $estatein_pid ) : null;
						$estatein_type = estatein_card_loop_property_type_label( $estatein_pid );
						$estatein_price = estatein_card_loop_property_price_html( $estatein_pid );
						$estatein_excerpt = get_the_excerpt( $estatein_pid );
						if ( $estatein_excerpt === '' ) {
							$estatein_excerpt = wp_trim_words( wp_strip_all_tags( (string) $estatein_post->post_content ), 22, '…' );
						}
						?>
						<article class="section-card-loop__card section-card-loop__card--property" role="listitem">
							<?php if ( $estatein_img ) : ?>
								<a class="section-card-loop__media" href="<?php echo esc_url( get_permalink( $estatein_pid ) ); ?>">
									<img
										class="section-card-loop__media-img"
										src="<?php echo esc_url( $estatein_img ); ?>"
										alt="<?php echo esc_attr( sprintf( /* translators: %s: property title */ __( 'Photo: %s', 'estatein-growmodo' ), get_the_title( $estatein_pid ) ) ); ?>"
										loading="eager"
										fetchpriority="low"
										decoding="async"
										width="310"
										height="210"
									>
								</a>
							<?php else : ?>
								<div class="section-card-loop__media section-card-loop__media--placeholder" aria-hidden="true"></div>
							<?php endif; ?>

							<div class="section-card-loop__card-body">
								<h3 class="section-card-loop__card-title">
									<a href="<?php echo esc_url( get_permalink( $estatein_pid ) ); ?>"><?php echo esc_html( get_the_title( $estatein_pid ) ); ?></a>
								</h3>
								<?php if ( $estatein_excerpt !== '' ) : ?>
									<div class="section-card-loop__excerpt-row">
										<p class="section-card-loop__excerpt section-card-loop__excerpt--property"><?php echo esc_html( $estatein_excerpt ); ?></p>
										<a class="section-card-loop__read-more" href="<?php echo esc_url( get_permalink( $estatein_pid ) ); ?>"><?php esc_html_e( 'Read More', 'estatein-growmodo' ); ?></a>
									</div>
								<?php endif; ?>

								<ul class="section-card-loop__pills" role="list">
									<?php if ( $estatein_bed !== null && $estatein_bed !== '' ) : ?>
										<li class="section-card-loop__pill">
											<img
												class="section-card-loop__pill-icon"
												src="<?php echo esc_url( $estatein_pill_icon_uri . '/svg-vector-14.svg' ); ?>"
												alt=""
												width="20"
												height="20"
												loading="lazy"
												decoding="async"
											>
											<span class="section-card-loop__pill-label"><?php echo esc_html( sprintf( '%d-Bedroom', (int) $estatein_bed ) ); ?></span>
										</li>
									<?php endif; ?>
									<?php if ( $estatein_bath !== null && $estatein_bath !== '' ) : ?>
										<li class="section-card-loop__pill">
											<img
												class="section-card-loop__pill-icon"
												src="<?php echo esc_url( $estatein_pill_icon_uri . '/svg-vector-15.svg' ); ?>"
												alt=""
												width="20"
												height="20"
												loading="lazy"
												decoding="async"
											>
											<span class="section-card-loop__pill-label"><?php echo esc_html( sprintf( '%d-Bathroom', (int) $estatein_bath ) ); ?></span>
										</li>
									<?php endif; ?>
									<?php if ( $estatein_type !== '' ) : ?>
										<li class="section-card-loop__pill">
											<img
												class="section-card-loop__pill-icon"
												src="<?php echo esc_url( $estatein_pill_icon_uri . '/svg-vector-16.svg' ); ?>"
												alt=""
												width="20"
												height="20"
												loading="lazy"
												decoding="async"
											>
											<span class="section-card-loop__pill-label"><?php echo esc_html( $estatein_type ); ?></span>
										</li>
									<?php endif; ?>
								</ul>

								<div class="section-card-loop__card-footer">
									<div class="section-card-loop__price-block">
										<span class="section-card-loop__price-label"><?php esc_html_e( 'Price', 'estatein-growmodo' ); ?></span>
										<span class="section-card-loop__price-value"><?php echo $estatein_price !== '' ? esc_html( $estatein_price ) : esc_html( '—' ); ?></span>
									</div>
									<a class="section-card-loop__card-cta btn-primary" href="<?php echo esc_url( get_permalink( $estatein_pid ) ); ?>">
										<?php esc_html_e( 'View Property Details', 'estatein-growmodo' ); ?>
									</a>
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
