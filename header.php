<?php
/**
 * Theme header
 *
 * @package estatein-growmodo
 */

$estatein_promo_enabled = function_exists( 'get_field' ) && get_field( 'enable_banner', 'option' );
$estatein_promo_text    = function_exists( 'get_field' ) ? (string) get_field( 'banner_text', 'option' ) : '';
$estatein_promo_link    = function_exists( 'get_field' ) ? get_field( 'banner_link', 'option' ) : null;
$estatein_promo_bg      = function_exists( 'get_field' ) ? get_field( 'promo_banner_background_image', 'option' ) : null;
$estatein_promo_bg_url  = '';

if ( is_array( $estatein_promo_bg ) && ! empty( $estatein_promo_bg['url'] ) ) {
	$estatein_promo_bg_url = $estatein_promo_bg['url'];
}

$estatein_has_promo_bar = $estatein_promo_enabled && (
	$estatein_promo_text !== ''
	|| $estatein_promo_bg_url !== ''
	|| ( is_array( $estatein_promo_link ) && ! empty( $estatein_promo_link['url'] ) )
);

$estatein_promo_bar_style = '';
if ( $estatein_promo_bg_url ) {
	$estatein_promo_bar_style = sprintf(
		'background-image: url(%s);',
		esc_url( $estatein_promo_bg_url )
	);
}

$estatein_header_cta = function_exists( 'get_field' ) ? get_field( 'header_cta', 'option' ) : null;
$estatein_site_logo  = function_exists( 'get_field' ) ? get_field( 'site_logo', 'option' ) : null;
$estatein_logo_url   = '';

if ( is_string( $estatein_site_logo ) && $estatein_site_logo !== '' ) {
	$estatein_logo_url = $estatein_site_logo;
} elseif ( is_array( $estatein_site_logo ) && ! empty( $estatein_site_logo['url'] ) ) {
	$estatein_logo_url = $estatein_site_logo['url'];
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'antialiased' ); ?>>
<?php wp_body_open(); ?>
<?php if ( $estatein_has_promo_bar ) : ?>
<script>
try {
	if (localStorage.getItem('estatein_promo_banner_dismissed') === '1') {
		document.documentElement.classList.add('promo-banner-dismissed');
	}
} catch (e) {}
</script>
<?php endif; ?>

<header id="masthead" class="site-header fixed w-full z-50 transition-all duration-300 bg-grey-10 backdrop-blur-md">
	<?php if ( $estatein_has_promo_bar ) : ?>
	<div class="announcement-bar-slot">
		<div class="announcement-bar-slot__inner">
			<div id="promo-announcement" class="announcement-bar"<?php echo $estatein_promo_bar_style ? ' style="' . esc_attr( $estatein_promo_bar_style ) . '"' : ''; ?>>
				<div class="announcement-bar__inner">
					<?php if ( $estatein_promo_text || ( is_array( $estatein_promo_link ) && ! empty( $estatein_promo_link['url'] ) ) ) : ?>
						<p class="announcement-bar__text">
							<?php echo esc_html( $estatein_promo_text ); ?>
							<?php if ( is_array( $estatein_promo_link ) && ! empty( $estatein_promo_link['url'] ) ) : ?>
								<?php
								$estatein_link_target = ! empty( $estatein_promo_link['target'] ) ? $estatein_promo_link['target'] : '_self';
								$estatein_link_rel    = '_blank' === $estatein_link_target ? 'noopener noreferrer' : '';
								$estatein_link_title  = ! empty( $estatein_promo_link['title'] ) ? $estatein_promo_link['title'] : __( 'Learn more', 'estatein-growmodo' );
								?>
								<?php if ( $estatein_promo_text ) : ?>
									<?php echo ' '; ?>
								<?php endif; ?>
								<a class="announcement-bar__link" href="<?php echo esc_url( $estatein_promo_link['url'] ); ?>" target="<?php echo esc_attr( $estatein_link_target ); ?>"<?php echo $estatein_link_rel ? ' rel="' . esc_attr( $estatein_link_rel ) . '"' : ''; ?>><?php echo esc_html( $estatein_link_title ); ?></a>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
				<button type="button" class="announcement-bar__close" aria-label="<?php esc_attr_e( 'Close promotional banner', 'estatein-growmodo' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg-vector-1.svg' ); ?>" width="12" height="12" alt="" decoding="async">
				</button>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<nav class="site-header__nav w-full" aria-label="<?php esc_attr_e( 'Primary', 'estatein-growmodo' ); ?>">
		<div class="container flex items-center justify-between">
			<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
					<?php if ( $estatein_logo_url ) : ?>
						<img src="<?php echo esc_url( $estatein_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="custom-logo" width="93" height="28" loading="eager" decoding="async">
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="custom-logo" width="93" height="28" loading="eager" decoding="async">
					<?php endif; ?>
				</a>
			</div>

			<div class="hidden lg:block">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-header__menu primary-menu',
						'fallback_cb'    => false,
					)
				);
				?>
			</div>

			<div class="header-actions flex items-center gap-4">
				<?php if ( is_array( $estatein_header_cta ) && ! empty( $estatein_header_cta['url'] ) ) : ?>
					<?php
					$estatein_cta_target = ! empty( $estatein_header_cta['target'] ) ? $estatein_header_cta['target'] : '_self';
					$estatein_cta_rel    = '_blank' === $estatein_cta_target ? 'noopener noreferrer' : '';
					$estatein_cta_title  = ! empty( $estatein_header_cta['title'] ) ? $estatein_header_cta['title'] : __( 'Contact', 'estatein-growmodo' );
					?>
					<a class="header-cta hidden lg:inline-flex" href="<?php echo esc_url( $estatein_header_cta['url'] ); ?>" target="<?php echo esc_attr( $estatein_cta_target ); ?>"<?php echo $estatein_cta_rel ? ' rel="' . esc_attr( $estatein_cta_rel ) . '"' : ''; ?>><?php echo esc_html( $estatein_cta_title ); ?></a>
				<?php endif; ?>
				<button type="button" class="mobile-menu-toggle lg:hidden flex items-center justify-center p-0 border-0 bg-transparent cursor-pointer" id="mobile-menu-toggle" aria-expanded="false" aria-controls="mobile-navigation" aria-label="<?php esc_attr_e( 'Toggle Menu', 'estatein-growmodo' ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg-vector-2.svg' ); ?>" alt="" class="mobile-menu-toggle__icon" width="21" height="14" decoding="async" aria-hidden="true">
				</button>
			</div>
		</div>
	</nav>
</header>

<?php /* Drawer outside header: header uses backdrop-blur which creates a fixed-position containing block and would clip the overlay to header height. */ ?>
<div id="mobile-navigation" class="mobile-navigation lg:hidden" aria-hidden="true">
	<div class="mobile-navigation__backdrop" aria-hidden="true"></div>
	<div class="mobile-navigation__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'estatein-growmodo' ); ?>">
		<div class="mobile-navigation__head">
			<div class="mobile-navigation__brand">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-navigation__logo-link">
					<?php if ( $estatein_logo_url ) : ?>
						<img src="<?php echo esc_url( $estatein_logo_url ); ?>" alt="" class="mobile-navigation__logo" width="93" height="28" loading="lazy" decoding="async">
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' ); ?>" alt="" class="mobile-navigation__logo" width="93" height="28" loading="lazy" decoding="async">
					<?php endif; ?>
				</a>
				<span class="mobile-navigation__title"><?php esc_html_e( 'Menu', 'estatein-growmodo' ); ?></span>
			</div>
			<button type="button" class="mobile-navigation__close" aria-label="<?php esc_attr_e( 'Close menu', 'estatein-growmodo' ); ?>">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/svg-vector-1.svg' ); ?>" alt="" width="12" height="12" decoding="async" aria-hidden="true">
			</button>
		</div>
		<div class="mobile-navigation__body">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'mobile-navigation__menu',
						'fallback_cb'    => false,
					)
				);
				?>
			<?php else : ?>
				<p class="mobile-navigation__empty"><?php esc_html_e( 'Assign a menu to the Primary location under Appearance → Menus.', 'estatein-growmodo' ); ?></p>
			<?php endif; ?>
			<?php if ( is_array( $estatein_header_cta ) && ! empty( $estatein_header_cta['url'] ) ) : ?>
				<?php
				$estatein_mcta_target = ! empty( $estatein_header_cta['target'] ) ? $estatein_header_cta['target'] : '_self';
				$estatein_mcta_rel    = '_blank' === $estatein_mcta_target ? 'noopener noreferrer' : '';
				$estatein_mcta_title  = ! empty( $estatein_header_cta['title'] ) ? $estatein_header_cta['title'] : __( 'Contact', 'estatein-growmodo' );
				?>
				<a class="header-cta mobile-navigation__cta" href="<?php echo esc_url( $estatein_header_cta['url'] ); ?>" target="<?php echo esc_attr( $estatein_mcta_target ); ?>"<?php echo $estatein_mcta_rel ? ' rel="' . esc_attr( $estatein_mcta_rel ) . '"' : ''; ?>><?php echo esc_html( $estatein_mcta_title ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<main id="primary" class="site-main <?php echo $estatein_has_promo_bar ? 'site-main--header-promo' : 'site-main--header-no-promo'; ?>">
