<?php
/**
 * Property detail page body (desktop-first layout from design).
 *
 * @package estatein-growmodo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = get_the_ID();
if ( $post_id < 1 ) {
	return;
}

$estatein_gallery = function_exists( 'estatein_property_gallery_images' )
	? estatein_property_gallery_images( $post_id )
	: array();

$estatein_price_html = function_exists( 'estatein_card_loop_property_price_html' )
	? estatein_card_loop_property_price_html( $post_id )
	: '';

$estatein_address = function_exists( 'get_field' ) ? (string) get_field( 'address', $post_id ) : '';
$estatein_beds    = function_exists( 'get_field' ) ? get_field( 'bedrooms', $post_id ) : null;
$estatein_baths   = function_exists( 'get_field' ) ? get_field( 'bathrooms', $post_id ) : null;
$estatein_area    = function_exists( 'get_field' ) ? (string) get_field( 'area', $post_id ) : '';

$estatein_features = function_exists( 'get_field' ) ? get_field( 'features', $post_id ) : array();
if ( ! is_array( $estatein_features ) ) {
	$estatein_features = array();
}

$estatein_pricing = function_exists( 'get_field' ) ? get_field( 'pricing_categories', $post_id ) : array();
if ( ! is_array( $estatein_pricing ) ) {
	$estatein_pricing = array();
}

$estatein_faqs = function_exists( 'get_field' ) ? get_field( 'property_faqs', $post_id ) : array();
if ( ! is_array( $estatein_faqs ) ) {
	$estatein_faqs = array();
}

$estatein_desc = get_post_field( 'post_content', $post_id );
$estatein_desc = is_string( $estatein_desc ) ? $estatein_desc : '';

$estatein_inquiry_flag = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( (string) $_GET['inquiry'] ) ) : '';
if ( ! in_array( $estatein_inquiry_flag, array( 'sent', 'error' ), true ) ) {
	$estatein_inquiry_flag = '';
}

$estatein_gallery_json = array();
foreach ( $estatein_gallery as $g ) {
	$estatein_gallery_json[] = array(
		'url'   => $g['url'],
		'thumb' => $g['thumb'],
		'alt'   => $g['alt'],
	);
}

$estatein_main_left  = $estatein_gallery[0] ?? null;
$estatein_main_right = $estatein_gallery[1] ?? $estatein_main_left;
?>
<article <?php post_class( 'property-detail' ); ?>>
	<div class="property-detail__hero">
		<div class="container property-detail__hero-inner">
			<div class="property-detail__hero-text">
				<h1 class="property-detail__title"><?php the_title(); ?></h1>
				<?php if ( $estatein_address !== '' ) : ?>
					<p class="property-detail__address">
						<span class="property-detail__address-icon" aria-hidden="true">
							<svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 0C4.03 0 0 4.1 0 9.17c0 6.51 6.38 11.35 8.24 12.67a1.5 1.5 0 0 0 1.52 0C11.62 20.52 18 15.68 18 9.17 18 4.1 13.97 0 9 0Zm0 13.5c-2.48 0-4.5-2.07-4.5-4.62S6.52 4.25 9 4.25s4.5 2.07 4.5 4.63S11.48 13.5 9 13.5Z" fill="currentColor"/></svg>
						</span>
						<span><?php echo esc_html( $estatein_address ); ?></span>
					</p>
				<?php endif; ?>
			</div>
			<?php if ( $estatein_price_html !== '' ) : ?>
				<p class="property-detail__price"><?php echo esc_html( $estatein_price_html ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $estatein_gallery !== array() ) : ?>
		<section class="property-detail__gallery-wrap" aria-label="<?php esc_attr_e( 'Property photos', 'estatein-growmodo' ); ?>">
			<div class="container">
				<div
					class="property-detail__gallery"
					id="property-detail-gallery"
					data-gallery-count="<?php echo esc_attr( (string) count( $estatein_gallery_json ) ); ?>"
				>
					<script type="application/json" id="property-detail-gallery-json"><?php echo wp_json_encode( $estatein_gallery_json ); ?></script>
					<div class="property-detail__gallery-thumbs" role="tablist" aria-label="<?php esc_attr_e( 'Photo thumbnails', 'estatein-growmodo' ); ?>">
						<?php
						$estatein_tmax = min( 9, count( $estatein_gallery ) );
						for ( $estatein_i = 0; $estatein_i < $estatein_tmax; $estatein_i++ ) :
							$estatein_t = $estatein_gallery[ $estatein_i ];
							?>
							<button
								type="button"
								class="property-detail__gallery-thumb<?php echo 0 === $estatein_i ? ' is-active' : ''; ?>"
								data-gallery-index="<?php echo (int) $estatein_i; ?>"
								aria-label="<?php echo esc_attr( sprintf( /* translators: %d: photo number */ __( 'Show photo %d', 'estatein-growmodo' ), $estatein_i + 1 ) ); ?>"
								aria-selected="<?php echo 0 === $estatein_i ? 'true' : 'false'; ?>"
							>
								<img src="<?php echo esc_url( $estatein_t['thumb'] ); ?>" alt="" loading="<?php echo $estatein_i < 4 ? 'eager' : 'lazy'; ?>" width="120" height="90" decoding="async">
							</button>
						<?php endfor; ?>
					</div>
					<div class="property-detail__gallery-mains">
						<?php if ( $estatein_main_left ) : ?>
							<figure class="property-detail__gallery-main">
								<img
									id="property-detail-main-0"
									src="<?php echo esc_url( $estatein_main_left['url'] ); ?>"
									alt="<?php echo esc_attr( $estatein_main_left['alt'] !== '' ? $estatein_main_left['alt'] : get_the_title() ); ?>"
									loading="eager"
									decoding="async"
									width="800"
									height="520"
								>
							</figure>
						<?php endif; ?>
						<?php if ( $estatein_main_right ) : ?>
							<figure class="property-detail__gallery-main">
								<img
									id="property-detail-main-1"
									src="<?php echo esc_url( $estatein_main_right['url'] ); ?>"
									alt="<?php echo esc_attr( $estatein_main_right['alt'] !== '' ? $estatein_main_right['alt'] : get_the_title() ); ?>"
									loading="eager"
									decoding="async"
									width="800"
									height="520"
								>
							</figure>
						<?php endif; ?>
					</div>
					<div class="property-detail__gallery-footer">
						<button type="button" class="property-detail__gallery-toggle btn-secondary" id="property-detail-view-all-photos" aria-expanded="false">
							<?php esc_html_e( 'View All Photos', 'estatein-growmodo' ); ?>
						</button>
					</div>
					<div class="property-detail__gallery-expanded" id="property-detail-gallery-expanded" hidden>
						<div class="property-detail__gallery-expanded-grid">
							<?php foreach ( $estatein_gallery as $estatein_g ) : ?>
								<figure class="property-detail__gallery-expanded-cell">
									<img src="<?php echo esc_url( $estatein_g['url'] ); ?>" alt="<?php echo esc_attr( $estatein_g['alt'] ); ?>" loading="lazy" decoding="async" width="400" height="260">
								</figure>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="property-detail__split">
		<div class="container property-detail__split-inner">
			<div class="property-detail__split-col property-detail__split-col--main">
				<h2 class="property-detail__section-title"><?php esc_html_e( 'Description', 'estatein-growmodo' ); ?></h2>
				<?php if ( $estatein_desc !== '' ) : ?>
					<div class="property-detail__description entry-content">
						<?php echo apply_filters( 'the_content', $estatein_desc ); ?>
					</div>
				<?php endif; ?>
				<div class="property-detail__stats">
					<?php if ( $estatein_beds !== null && $estatein_beds !== '' ) : ?>
						<div class="property-detail__stat">
							<span class="property-detail__stat-label"><?php esc_html_e( 'Bedrooms', 'estatein-growmodo' ); ?></span>
							<span class="property-detail__stat-value"><?php echo esc_html( estatein_property_stat_display( $estatein_beds ) ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( $estatein_baths !== null && $estatein_baths !== '' ) : ?>
						<div class="property-detail__stat">
							<span class="property-detail__stat-label"><?php esc_html_e( 'Bathrooms', 'estatein-growmodo' ); ?></span>
							<span class="property-detail__stat-value"><?php echo esc_html( estatein_property_stat_display( $estatein_baths ) ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( $estatein_area !== '' ) : ?>
						<div class="property-detail__stat">
							<span class="property-detail__stat-label"><?php esc_html_e( 'Area', 'estatein-growmodo' ); ?></span>
							<span class="property-detail__stat-value"><?php echo esc_html( $estatein_area ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $estatein_features !== array() ) : ?>
				<div class="property-detail__split-col property-detail__split-col--features">
					<h2 class="property-detail__section-title"><?php esc_html_e( 'Key Features and Amenities', 'estatein-growmodo' ); ?></h2>
					<ul class="property-detail__features" role="list">
						<?php foreach ( $estatein_features as $estatein_row ) : ?>
							<?php
							$estatein_fname = is_array( $estatein_row ) && isset( $estatein_row['feature_name'] ) ? (string) $estatein_row['feature_name'] : '';
							if ( $estatein_fname === '' ) {
								continue;
							}
							?>
							<li class="property-detail__feature">
								<span class="property-detail__feature-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 1 3 13h5l-1 6 8-12h-5l1-6Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" fill="none"/></svg>
								</span>
								<span><?php echo esc_html( $estatein_fname ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="property-detail__inquiry" id="property-inquiry">
		<div class="container property-detail__inquiry-inner">
			<div class="property-detail__inquiry-intro">
				<h2 class="property-detail__section-title property-detail__section-title--inquiry">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: property title */
							__( 'Inquire About %s', 'estatein-growmodo' ),
							get_the_title()
						)
					);
					?>
				</h2>
				<p class="property-detail__inquiry-lead">
					<?php esc_html_e( 'Interested in this home? Send a message and our team will get back to you as soon as possible.', 'estatein-growmodo' ); ?>
				</p>
			</div>
			<div class="property-detail__inquiry-form-wrap">
				<?php if ( 'sent' === $estatein_inquiry_flag ) : ?>
					<p class="property-detail__notice property-detail__notice--success" role="status"><?php esc_html_e( 'Thank you — your message has been sent.', 'estatein-growmodo' ); ?></p>
				<?php elseif ( 'error' === $estatein_inquiry_flag ) : ?>
					<p class="property-detail__notice property-detail__notice--error" role="alert"><?php esc_html_e( 'Please fill in all required fields and accept the terms.', 'estatein-growmodo' ); ?></p>
				<?php endif; ?>
				<form class="property-detail__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="estatein_property_inquiry">
					<input type="hidden" name="property_id" value="<?php echo (int) $post_id; ?>">
					<?php wp_nonce_field( 'estatein_property_inquiry', 'estatein_inquiry_nonce' ); ?>
					<p class="property-detail__hp" aria-hidden="true">
						<label><?php esc_html_e( 'Company', 'estatein-growmodo' ); ?> <input type="text" name="estatein_company" value="" tabindex="-1" autocomplete="off"></label>
					</p>
					<div class="property-detail__form-row property-detail__form-row--2">
						<label class="property-detail__field">
							<span class="property-detail__field-label"><?php esc_html_e( 'First Name', 'estatein-growmodo' ); ?></span>
							<input type="text" name="inquiry_first_name" required autocomplete="given-name">
						</label>
						<label class="property-detail__field">
							<span class="property-detail__field-label"><?php esc_html_e( 'Last Name', 'estatein-growmodo' ); ?></span>
							<input type="text" name="inquiry_last_name" required autocomplete="family-name">
						</label>
					</div>
					<div class="property-detail__form-row property-detail__form-row--2">
						<label class="property-detail__field">
							<span class="property-detail__field-label"><?php esc_html_e( 'Email', 'estatein-growmodo' ); ?></span>
							<input type="email" name="inquiry_email" required autocomplete="email">
						</label>
						<label class="property-detail__field">
							<span class="property-detail__field-label"><?php esc_html_e( 'Phone', 'estatein-growmodo' ); ?></span>
							<input type="tel" name="inquiry_phone" autocomplete="tel">
						</label>
					</div>
					<label class="property-detail__field">
						<span class="property-detail__field-label"><?php esc_html_e( 'Selected Property', 'estatein-growmodo' ); ?></span>
						<select name="inquiry_property_title" disabled class="property-detail__select">
							<option selected><?php echo esc_html( get_the_title() ); ?></option>
						</select>
					</label>
					<label class="property-detail__field">
						<span class="property-detail__field-label"><?php esc_html_e( 'Message', 'estatein-growmodo' ); ?></span>
						<textarea name="inquiry_message" rows="5"></textarea>
					</label>
					<label class="property-detail__checkbox">
						<input type="checkbox" name="inquiry_agree" value="1" required>
						<span><?php esc_html_e( 'I agree with Terms of Use and Privacy Policy', 'estatein-growmodo' ); ?></span>
					</label>
					<button type="submit" class="btn-primary property-detail__submit"><?php esc_html_e( 'Send Your Message', 'estatein-growmodo' ); ?></button>
				</form>
			</div>
		</div>
	</section>

	<?php if ( $estatein_pricing !== array() && $estatein_price_html !== '' ) : ?>
		<section class="property-detail__pricing" aria-labelledby="property-pricing-heading">
			<div class="container">
				<header class="property-detail__pricing-header">
					<h2 class="property-detail__section-title" id="property-pricing-heading"><?php esc_html_e( 'Comprehensive Pricing Details', 'estatein-growmodo' ); ?></h2>
					<p class="property-detail__pricing-sub">
						<?php esc_html_e( 'Breakdown of one-time fees, recurring costs, and estimated totals so you can plan with confidence.', 'estatein-growmodo' ); ?>
					</p>
				</header>
				<div class="property-detail__pricing-notice" role="note">
					<?php esc_html_e( 'Figures are estimates for illustration. Final amounts may vary based on lender, insurer, and local regulations.', 'estatein-growmodo' ); ?>
				</div>
				<div class="property-detail__pricing-grid">
					<div class="property-detail__pricing-hero">
						<span class="property-detail__pricing-hero-label"><?php esc_html_e( 'Listing price', 'estatein-growmodo' ); ?></span>
						<p class="property-detail__pricing-hero-value"><?php echo esc_html( $estatein_price_html ); ?></p>
					</div>
					<div class="property-detail__pricing-cards">
						<?php foreach ( $estatein_pricing as $estatein_pi => $estatein_cat ) : ?>
							<?php
							if ( ! is_array( $estatein_cat ) ) {
								continue;
							}
							$estatein_ctitle = isset( $estatein_cat['category_title'] ) ? (string) $estatein_cat['category_title'] : '';
							$estatein_fees   = isset( $estatein_cat['fees'] ) && is_array( $estatein_cat['fees'] ) ? $estatein_cat['fees'] : array();
							if ( $estatein_ctitle === '' && $estatein_fees === array() ) {
								continue;
							}
							$estatein_card_id = 'property-pricing-card-' . (int) $estatein_pi;
							?>
							<div class="property-detail__pricing-card" id="<?php echo esc_attr( $estatein_card_id ); ?>">
								<?php if ( $estatein_ctitle !== '' ) : ?>
									<h3 class="property-detail__pricing-card-title"><?php echo esc_html( $estatein_ctitle ); ?></h3>
								<?php endif; ?>
								<?php if ( $estatein_fees !== array() ) : ?>
									<ul class="property-detail__pricing-fees">
										<?php foreach ( $estatein_fees as $estatein_fi => $estatein_fee ) : ?>
											<?php
											if ( ! is_array( $estatein_fee ) ) {
												continue;
											}
											$estatein_fl = isset( $estatein_fee['fee_label'] ) ? (string) $estatein_fee['fee_label'] : '';
											$estatein_fa = isset( $estatein_fee['amount'] ) ? (string) $estatein_fee['amount'] : '';
											$estatein_fd = isset( $estatein_fee['fee_description'] ) ? (string) $estatein_fee['fee_description'] : '';
											?>
											<li class="property-detail__pricing-fee<?php echo $estatein_fi >= 2 ? ' property-detail__pricing-fee--extra' : ''; ?>"<?php echo $estatein_fi >= 2 ? ' hidden' : ''; ?>>
												<span class="property-detail__pricing-fee-label"><?php echo esc_html( $estatein_fl ); ?></span>
												<?php if ( $estatein_fa !== '' ) : ?>
													<span class="property-detail__pricing-fee-amount"><?php echo esc_html( '$' . ltrim( $estatein_fa, '$' ) ); ?></span>
												<?php endif; ?>
												<?php if ( $estatein_fd !== '' ) : ?>
													<span class="property-detail__pricing-fee-desc"><?php echo esc_html( $estatein_fd ); ?></span>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<?php if ( count( $estatein_fees ) > 2 ) : ?>
									<button type="button" class="property-detail__pricing-toggle" data-pricing-card="<?php echo esc_attr( $estatein_card_id ); ?>" aria-expanded="false">
										<?php esc_html_e( 'View Details', 'estatein-growmodo' ); ?>
									</button>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $estatein_faqs !== array() ) : ?>
		<section class="property-detail__faqs" aria-labelledby="property-faq-heading">
			<div class="container property-detail__faqs-head">
				<h2 class="property-detail__section-title" id="property-faq-heading"><?php esc_html_e( 'Frequently Asked Questions', 'estatein-growmodo' ); ?></h2>
				<?php
				$estatein_props_url = get_post_type_archive_link( 'property' );
				if ( $estatein_props_url ) :
					?>
					<a class="property-detail__faqs-all btn-secondary" href="<?php echo esc_url( $estatein_props_url ); ?>"><?php esc_html_e( 'View All', 'estatein-growmodo' ); ?></a>
				<?php endif; ?>
			</div>
			<div class="container">
				<div class="property-detail__faq-grid">
					<?php foreach ( $estatein_faqs as $estatein_fi => $estatein_faq ) : ?>
						<?php
						if ( ! is_array( $estatein_faq ) ) {
							continue;
						}
						$estatein_q = isset( $estatein_faq['question'] ) ? (string) $estatein_faq['question'] : '';
						$estatein_a = isset( $estatein_faq['answer'] ) ? (string) $estatein_faq['answer'] : '';
						if ( $estatein_q === '' ) {
							continue;
						}
						$estatein_excerpt = wp_trim_words( wp_strip_all_tags( $estatein_a ), 24, '…' );
						$estatein_fid     = 'property-faq-' . (int) $estatein_fi;
						?>
						<div class="property-detail__faq-card" id="<?php echo esc_attr( $estatein_fid ); ?>">
							<h3 class="property-detail__faq-q"><?php echo esc_html( $estatein_q ); ?></h3>
							<?php if ( $estatein_excerpt !== '' ) : ?>
								<p class="property-detail__faq-excerpt"><?php echo esc_html( $estatein_excerpt ); ?></p>
							<?php endif; ?>
							<?php if ( $estatein_a !== '' ) : ?>
								<div class="property-detail__faq-answer" hidden>
									<?php echo wp_kses_post( wpautop( $estatein_a ) ); ?>
								</div>
								<button type="button" class="property-detail__faq-more btn-secondary" data-faq-target="<?php echo esc_attr( $estatein_fid ); ?>" aria-expanded="false">
									<?php esc_html_e( 'Read More', 'estatein-growmodo' ); ?>
								</button>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</article>
