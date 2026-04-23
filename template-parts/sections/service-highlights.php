<?php
/**
 * Service Highlights — icon link cards (ACF: Service Highlights).
 *
 * @package estatein-growmodo
 */

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$estatein_sh_cards = get_field( 'service_highlight_cards' );
if ( ! is_array( $estatein_sh_cards ) || $estatein_sh_cards === array() ) {
	return;
}

$estatein_sh_rows = array();
foreach ( $estatein_sh_cards as $estatein_row ) {
	if ( ! is_array( $estatein_row ) ) {
		continue;
	}
	$estatein_t = isset( $estatein_row['title'] ) ? trim( (string) $estatein_row['title'] ) : '';
	if ( $estatein_t === '' ) {
		continue;
	}
	$estatein_sh_rows[] = $estatein_row;
}

if ( $estatein_sh_rows === array() ) {
	return;
}

$estatein_sh_ring = get_template_directory_uri() . '/assets/images/svg-vector-5.svg';
$estatein_sh_arrow = get_template_directory_uri() . '/assets/images/svg-vector-6.svg';
?>
<section class="service-highlights" aria-label="<?php esc_attr_e( 'Service highlights', 'estatein-growmodo' ); ?>">
	<div class="container">
		<div class="service-highlights__panel">
			<ul class="service-highlights__grid" role="list">
				<?php foreach ( $estatein_sh_rows as $estatein_sh_row ) : ?>
					<?php
					$estatein_sh_title = isset( $estatein_sh_row['title'] ) ? trim( (string) $estatein_sh_row['title'] ) : '';
					$estatein_sh_icon  = isset( $estatein_sh_row['icon'] ) && is_array( $estatein_sh_row['icon'] ) ? $estatein_sh_row['icon'] : array();
					$estatein_sh_link  = isset( $estatein_sh_row['link'] ) && is_array( $estatein_sh_row['link'] ) ? $estatein_sh_row['link'] : array();

					$estatein_icon_url = ! empty( $estatein_sh_icon['url'] ) ? $estatein_sh_icon['url'] : '';
					$estatein_icon_alt = '';
					if ( $estatein_icon_url !== '' ) {
						$estatein_icon_alt = isset( $estatein_sh_icon['alt'] ) ? trim( (string) $estatein_sh_icon['alt'] ) : '';
						if ( $estatein_icon_alt === '' ) {
							$estatein_icon_alt = $estatein_sh_title;
						}
					}

					$estatein_href   = ! empty( $estatein_sh_link['url'] ) ? $estatein_sh_link['url'] : '';
					$estatein_target = ! empty( $estatein_sh_link['target'] ) ? $estatein_sh_link['target'] : '_self';
					$estatein_rel      = '_blank' === $estatein_target ? 'noopener noreferrer' : '';
					?>
					<li class="service-highlights__card">
						<?php if ( $estatein_href !== '' ) : ?>
							<a
								class="service-highlights__card-target"
								href="<?php echo esc_url( $estatein_href ); ?>"
								target="<?php echo esc_attr( $estatein_target ); ?>"
								<?php echo $estatein_rel ? ' rel="' . esc_attr( $estatein_rel ) . '"' : ''; ?>
							>
						<?php else : ?>
							<div class="service-highlights__card-target">
						<?php endif; ?>

							<span class="service-highlights__arrow" aria-hidden="true">
								<img
									class="service-highlights__arrow-img"
									src="<?php echo esc_url( $estatein_sh_arrow ); ?>"
									alt=""
									width="24"
									height="24"
									decoding="async"
								>
							</span>

							<span class="service-highlights__icon-wrap">
								<img
									class="service-highlights__decor"
									src="<?php echo esc_url( $estatein_sh_ring ); ?>"
									alt=""
									width="82"
									height="82"
									decoding="async"
								>
								<?php if ( $estatein_icon_url !== '' ) : ?>
									<img
										class="service-highlights__icon"
										src="<?php echo esc_url( $estatein_icon_url ); ?>"
										alt="<?php echo esc_attr( $estatein_icon_alt ); ?>"
										decoding="async"
									>
								<?php endif; ?>
							</span>

							<span class="service-highlights__title"><?php echo esc_html( $estatein_sh_title ); ?></span>

						<?php if ( $estatein_href !== '' ) : ?>
							</a>
						<?php else : ?>
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
