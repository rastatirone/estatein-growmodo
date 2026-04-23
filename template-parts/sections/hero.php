<?php
/**
 * Page hero (ACF: Hero Configuration).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$estatein_hero_title_field = get_field( 'hero_title' );
$estatein_hero_description = get_field( 'hero_description' );
$estatein_hero_image       = get_field( 'hero_image' );
$estatein_hero_stats       = get_field( 'hero_stats' );
$estatein_hero_show_search = get_field( 'hero_show_search' );
$estatein_hero_show_ctas   = get_field( 'hero_show_ctas' );
$estatein_hero_cta_left    = get_field( 'hero_cta_left' );
$estatein_hero_cta_right   = get_field( 'hero_cta_right' );

$estatein_hero_title_explicit = is_string( $estatein_hero_title_field ) && trim( $estatein_hero_title_field ) !== '';
$estatein_hero_desc_ok        = is_string( $estatein_hero_description ) && trim( $estatein_hero_description ) !== '';
$estatein_hero_has_image      = is_array( $estatein_hero_image ) && ! empty( $estatein_hero_image['url'] );
$estatein_hero_stats_rows     = is_array( $estatein_hero_stats ) ? $estatein_hero_stats : array();
$estatein_hero_has_stats      = count( $estatein_hero_stats_rows ) > 0;
$estatein_hero_search_on      = (bool) $estatein_hero_show_search;
$estatein_hero_ctas_on        = (bool) $estatein_hero_show_ctas;
$estatein_hero_cta_left_ok    = is_array( $estatein_hero_cta_left ) && ! empty( $estatein_hero_cta_left['url'] );
$estatein_hero_cta_right_ok   = is_array( $estatein_hero_cta_right ) && ! empty( $estatein_hero_cta_right['url'] );
$estatein_hero_ctas_visible   = $estatein_hero_ctas_on && ( $estatein_hero_cta_left_ok || $estatein_hero_cta_right_ok );

$estatein_show_hero = (
	$estatein_hero_title_explicit
	|| $estatein_hero_desc_ok
	|| $estatein_hero_has_image
	|| $estatein_hero_has_stats
	|| $estatein_hero_search_on
	|| $estatein_hero_ctas_visible
);

if ( ! $estatein_show_hero ) {
	return;
}

$estatein_hero_heading = $estatein_hero_title_explicit
	? trim( $estatein_hero_title_field )
	: get_the_title();

$estatein_hero_img_url    = $estatein_hero_has_image ? $estatein_hero_image['url'] : '';
$estatein_hero_img_w      = isset( $estatein_hero_image['width'] ) ? (int) $estatein_hero_image['width'] : 0;
$estatein_hero_img_h      = isset( $estatein_hero_image['height'] ) ? (int) $estatein_hero_image['height'] : 0;
$estatein_hero_img_alt     = '';
if ( $estatein_hero_has_image ) {
	$estatein_hero_img_alt = isset( $estatein_hero_image['alt'] ) ? trim( (string) $estatein_hero_image['alt'] ) : '';
}

$estatein_hero_section_class = 'site-hero';
if ( $estatein_hero_has_image ) {
	$estatein_hero_section_class .= ' site-hero--has-image';
}
?>
<section id="hero_section" class="<?php echo esc_attr( $estatein_hero_section_class ); ?>" aria-label="<?php esc_attr_e( 'Introduction', 'estatein-growmodo' ); ?>">
	<div class="site-hero__inner">
		<div class="site-hero__grid">
			<div class="site-hero__copy">
				<div class="site-hero__copy-rail">
					<div class="site-hero__copy-inner">
				<?php if ( $estatein_hero_heading !== '' ) : ?>
					<h1 class="site-hero__title"><?php echo esc_html( $estatein_hero_heading ); ?></h1>
				<?php endif; ?>

				<?php if ( $estatein_hero_desc_ok ) : ?>
					<div class="site-hero__description">
						<?php echo wp_kses_post( wpautop( trim( $estatein_hero_description ) ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $estatein_hero_ctas_visible ) : ?>
					<div class="site-hero__ctas">
						<?php if ( $estatein_hero_cta_left_ok ) : ?>
							<?php
							$estatein_hcl = $estatein_hero_cta_left;
							$estatein_hcl_target = ! empty( $estatein_hcl['target'] ) ? $estatein_hcl['target'] : '_self';
							$estatein_hcl_rel    = '_blank' === $estatein_hcl_target ? 'noopener noreferrer' : '';
							$estatein_hcl_title  = ! empty( $estatein_hcl['title'] ) ? $estatein_hcl['title'] : __( 'Learn more', 'estatein-growmodo' );
							?>
							<a
								class="site-hero__cta site-hero__cta--dark"
								href="<?php echo esc_url( $estatein_hcl['url'] ); ?>"
								target="<?php echo esc_attr( $estatein_hcl_target ); ?>"
								<?php echo $estatein_hcl_rel ? ' rel="' . esc_attr( $estatein_hcl_rel ) . '"' : ''; ?>
							><?php echo esc_html( $estatein_hcl_title ); ?></a>
						<?php endif; ?>
						<?php if ( $estatein_hero_cta_right_ok ) : ?>
							<?php
							$estatein_hcr = $estatein_hero_cta_right;
							$estatein_hcr_target = ! empty( $estatein_hcr['target'] ) ? $estatein_hcr['target'] : '_self';
							$estatein_hcr_rel    = '_blank' === $estatein_hcr_target ? 'noopener noreferrer' : '';
							$estatein_hcr_title  = ! empty( $estatein_hcr['title'] ) ? $estatein_hcr['title'] : __( 'Browse properties', 'estatein-growmodo' );
							?>
							<a
								class="site-hero__cta site-hero__cta--purple btn-primary"
								href="<?php echo esc_url( $estatein_hcr['url'] ); ?>"
								target="<?php echo esc_attr( $estatein_hcr_target ); ?>"
								<?php echo $estatein_hcr_rel ? ' rel="' . esc_attr( $estatein_hcr_rel ) . '"' : ''; ?>
							><?php echo esc_html( $estatein_hcr_title ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( $estatein_hero_has_stats ) : ?>
					<ul class="site-hero__stats" role="list">
						<?php foreach ( $estatein_hero_stats_rows as $estatein_stat_row ) : ?>
							<?php
							if ( ! is_array( $estatein_stat_row ) ) {
								continue;
							}
							$estatein_sv = isset( $estatein_stat_row['stat_value'] ) ? trim( (string) $estatein_stat_row['stat_value'] ) : '';
							$estatein_sl = isset( $estatein_stat_row['stat_label'] ) ? trim( (string) $estatein_stat_row['stat_label'] ) : '';
							if ( $estatein_sv === '' && $estatein_sl === '' ) {
								continue;
							}
							?>
							<li class="site-hero__stat">
								<?php if ( $estatein_sv !== '' ) : ?>
									<span class="site-hero__stat-value"><?php echo esc_html( $estatein_sv ); ?></span>
								<?php endif; ?>
								<?php if ( $estatein_sl !== '' ) : ?>
									<span class="site-hero__stat-label"><?php echo esc_html( $estatein_sl ); ?></span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $estatein_hero_search_on ) : ?>
					<form class="site-hero__search" action="#" method="get" aria-label="<?php esc_attr_e( 'Property search (preview)', 'estatein-growmodo' ); ?>">
						<div class="site-hero__search-fields">
							<label class="sr-only" for="site-hero-search-location"><?php esc_html_e( 'Location', 'estatein-growmodo' ); ?></label>
							<input
								id="site-hero-search-location"
								class="site-hero__search-input"
								type="text"
								name="hero_location"
								placeholder="<?php esc_attr_e( 'Location', 'estatein-growmodo' ); ?>"
								disabled
							>
							<label class="sr-only" for="site-hero-search-type"><?php esc_html_e( 'Property type', 'estatein-growmodo' ); ?></label>
							<input
								id="site-hero-search-type"
								class="site-hero__search-input"
								type="text"
								name="hero_type"
								placeholder="<?php esc_attr_e( 'Type', 'estatein-growmodo' ); ?>"
								disabled
							>
							<label class="sr-only" for="site-hero-search-price"><?php esc_html_e( 'Price range', 'estatein-growmodo' ); ?></label>
							<input
								id="site-hero-search-price"
								class="site-hero__search-input"
								type="text"
								name="hero_price"
								placeholder="<?php esc_attr_e( 'Price', 'estatein-growmodo' ); ?>"
								disabled
							>
						</div>
						<button type="button" class="btn-primary site-hero__search-submit" disabled>
							<?php esc_html_e( 'Find Property', 'estatein-growmodo' ); ?>
						</button>
					</form>
				<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( $estatein_hero_has_image ) : ?>
				<div class="site-hero__media">
					<div class="site-hero__media-inner">
						<img
							class="site-hero__img"
							src="<?php echo esc_url( $estatein_hero_img_url ); ?>"
							alt="<?php echo esc_attr( $estatein_hero_img_alt ); ?>"
							<?php echo $estatein_hero_img_w > 0 ? ' width="' . (int) $estatein_hero_img_w . '"' : ''; ?>
							<?php echo $estatein_hero_img_h > 0 ? ' height="' . (int) $estatein_hero_img_h . '"' : ''; ?>
							decoding="async"
							fetchpriority="high"
						>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
