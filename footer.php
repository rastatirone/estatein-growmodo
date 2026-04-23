<?php
/**
 * Theme footer
 *
 * @package estatein-growmodo
 */

$estatein_footer_locations = array(
	'footer_menu_1',
	'footer_menu_2',
	'footer_menu_3',
	'footer_menu_4',
	'footer_menu_5',
);

$estatein_site_logo = function_exists( 'get_field' ) ? get_field( 'site_logo', 'option' ) : null;
$estatein_logo_url   = '';

if ( is_string( $estatein_site_logo ) && $estatein_site_logo !== '' ) {
	$estatein_logo_url = $estatein_site_logo;
} elseif ( is_array( $estatein_site_logo ) && ! empty( $estatein_site_logo['url'] ) ) {
	$estatein_logo_url = $estatein_site_logo['url'];
}

$estatein_social_rows = function_exists( 'get_field' ) ? get_field( 'global_social_links', 'option' ) : array();
if ( ! is_array( $estatein_social_rows ) ) {
	$estatein_social_rows = array();
}

$estatein_year = (int) gmdate( 'Y' );

$estatein_footer_icons_uri = get_template_directory_uri() . '/assets/images/';

$estatein_copyright_acf = function_exists( 'get_field' ) ? get_field( 'copyright_text', 'option' ) : '';
$estatein_terms_label   = function_exists( 'get_field' ) ? get_field( 'footer_terms_label', 'option' ) : '';
$estatein_terms_url_raw = function_exists( 'get_field' ) ? get_field( 'footer_terms_url', 'option' ) : '';

$estatein_terms_label = is_string( $estatein_terms_label ) ? trim( $estatein_terms_label ) : '';
if ( $estatein_terms_label === '' ) {
	$estatein_terms_label = __( 'Terms & Conditions', 'estatein-growmodo' );
}

$estatein_terms_url = '';
if ( is_string( $estatein_terms_url_raw ) && $estatein_terms_url_raw !== '' ) {
	$estatein_terms_url = $estatein_terms_url_raw;
} else {
	$estatein_terms_url = apply_filters( 'estatein_footer_terms_url', '#' );
}
?>
</main>

<?php get_template_part( 'template-parts/sections/outro-cta' ); ?>

<footer class="site-footer" role="contentinfo">
	<div class="site-footer__main">
		<div class="container site-footer__grid">
			<div class="site-footer__col site-footer__col--brand">
				<div class="site-footer__logo-wrap">
					<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php elseif ( $estatein_logo_url ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo-link">
							<img src="<?php echo esc_url( $estatein_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="site-footer__logo-img" loading="lazy" decoding="async">
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo-link">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="site-footer__logo-img" loading="lazy" decoding="async">
						</a>
					<?php endif; ?>
				</div>

				<form class="site-footer__newsletter" action="#" method="post" autocomplete="off">
					<div class="site-footer__newsletter-inner" tabindex="0" role="group" aria-label="<?php esc_attr_e( 'Newsletter signup', 'estatein-growmodo' ); ?>" aria-describedby="footer-newsletter-hint">
						<span id="footer-newsletter-hint" class="site-footer__newsletter-tooltip"><?php esc_html_e( 'Integration coming soon', 'estatein-growmodo' ); ?></span>
						<span class="site-footer__newsletter-icon" aria-hidden="true">
							<img src="<?php echo esc_url( $estatein_footer_icons_uri . 'svg-vector-4.svg' ); ?>" alt="" width="20" height="20" decoding="async">
						</span>
						<input type="email" id="footer-newsletter-email" name="newsletter_email" class="site-footer__newsletter-input" placeholder="<?php esc_attr_e( 'Enter Your Email', 'estatein-growmodo' ); ?>" aria-label="<?php esc_attr_e( 'Email address', 'estatein-growmodo' ); ?>" disabled>
						<button type="button" class="site-footer__newsletter-submit" aria-label="<?php esc_attr_e( 'Subscribe to newsletter', 'estatein-growmodo' ); ?>" disabled>
							<img src="<?php echo esc_url( $estatein_footer_icons_uri . 'svg-vector-3.svg' ); ?>" alt="" width="24" height="24" class="site-footer__newsletter-submit-img" decoding="async" aria-hidden="true">
						</button>
					</div>
				</form>
			</div>

			<div class="site-footer__nav-cluster">
				<?php /* Left column (mobile): menus 1, 3, 5 — avoids grid row stretch vs taller right column. */ ?>
				<div class="site-footer__nav-stack site-footer__nav-stack--left">
					<?php
					foreach ( array( 0, 2, 4 ) as $estatein_footer_nav_idx ) :
						if ( ! isset( $estatein_footer_locations[ $estatein_footer_nav_idx ] ) ) {
							continue;
						}
						$estatein_loc                  = $estatein_footer_locations[ $estatein_footer_nav_idx ];
						$estatein_footer_nav_display  = $estatein_footer_nav_idx + 1;
						?>
						<div class="site-footer__col site-footer__col--nav" data-footer-nav-index="<?php echo (int) $estatein_footer_nav_display; ?>">
							<?php
							if ( function_exists( 'estatein_render_footer_nav_column' ) ) {
								estatein_render_footer_nav_column( $estatein_loc );
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="site-footer__nav-stack site-footer__nav-stack--right">
					<?php
					foreach ( array( 1, 3 ) as $estatein_footer_nav_idx ) :
						if ( ! isset( $estatein_footer_locations[ $estatein_footer_nav_idx ] ) ) {
							continue;
						}
						$estatein_loc                  = $estatein_footer_locations[ $estatein_footer_nav_idx ];
						$estatein_footer_nav_display  = $estatein_footer_nav_idx + 1;
						?>
						<div class="site-footer__col site-footer__col--nav" data-footer-nav-index="<?php echo (int) $estatein_footer_nav_display; ?>">
							<?php
							if ( function_exists( 'estatein_render_footer_nav_column' ) ) {
								estatein_render_footer_nav_column( $estatein_loc );
							}
							?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="site-footer__bottom">
		<div class="container site-footer__bottom-inner">
			<?php if ( ! empty( $estatein_social_rows ) ) : ?>
				<ul class="site-footer__social" role="list">
					<?php foreach ( $estatein_social_rows as $estatein_row ) : ?>
						<?php
						if ( ! is_array( $estatein_row ) ) {
							continue;
						}
						$estatein_plat_name = isset( $estatein_row['platform_name'] ) ? (string) $estatein_row['platform_name'] : '';
						$estatein_plat_url  = isset( $estatein_row['platform_url'] ) ? (string) $estatein_row['platform_url'] : '';
						$estatein_plat_icon = isset( $estatein_row['platform_icon'] ) ? (string) $estatein_row['platform_icon'] : '';
						if ( $estatein_plat_url === '' ) {
							continue;
						}
						$estatein_label = $estatein_plat_name !== '' ? $estatein_plat_name : __( 'Social profile', 'estatein-growmodo' );
						?>
						<li class="site-footer__social-item">
							<a class="site-footer__social-link" href="<?php echo esc_url( $estatein_plat_url ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="site-footer__social-icon" aria-hidden="true">
									<?php
									$estatein_icon_html = estatein_footer_social_icon_html( $estatein_plat_icon );
									if ( $estatein_icon_html !== '' ) {
										echo $estatein_icon_html;
									} else {
										?>
										<span class="site-footer__social-dot"></span>
										<?php
									}
									?>
								</span>
								<span class="sr-only"><?php echo esc_html( $estatein_label ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<div class="site-footer__legal">
				<span class="site-footer__copyright">
					<?php
					if ( is_string( $estatein_copyright_acf ) && $estatein_copyright_acf !== '' ) {
						echo esc_html( $estatein_copyright_acf );
					} else {
						printf(
							/* translators: %d: current year */
							esc_html__( '@%d Estatein. All Rights Reserved.', 'estatein-growmodo' ),
							$estatein_year
						);
					}
					?>
				</span>
				<a class="site-footer__terms" href="<?php echo esc_url( $estatein_terms_url ); ?>"><?php echo esc_html( $estatein_terms_label ); ?></a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
