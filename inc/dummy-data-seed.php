<?php
/**
 * One-off dummy content for Properties, Testimonials, and Team Members (ACF-aligned).
 *
 * @package estatein-growmodo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATEIN_DUMMY_SEED_VERSION', '2' );

/**
 * Whether a seed-related query flag is enabled (accepts 1, true, yes, on).
 *
 * @param string $key Query parameter name.
 * @return bool
 */
function estatein_dummy_seed_query_flag( $key ) {
	if ( ! isset( $_GET[ $key ] ) ) {
		return false;
	}
	$v = strtolower( sanitize_text_field( wp_unslash( (string) $_GET[ $key ] ) ) );
	return in_array( $v, array( '1', 'true', 'yes', 'on' ), true );
}

/**
 * Demo property rows (ACF-aligned). First three shipped in seed v1; indexes 3–8 are the v2 additions.
 *
 * @return array<int, array<string, mixed>>
 */
function estatein_dummy_seed_property_definitions() {
	return array(
		array(
			'title'              => 'Seaside Serenity Villa',
			'content'            => 'A stunning 4-bedroom villa with a private pool and breathtaking ocean views. Wake up to the soothing melody of waves.',
			'price'              => 1250000,
			'address'            => '123 Ocean Drive, Malibu, CA',
			'bedrooms'           => 4,
			'bathrooms'          => 3,
			'area'               => '2,500 Sq. Ft.',
			'inquiry_email'      => 'hello@estatein.com',
			'features'           => array(
				array( 'feature_name' => 'Expansive oceanfront terrace with outdoor dining' ),
				array( 'feature_name' => 'Gourmet kitchen with top-of-the-line appliances' ),
				array( 'feature_name' => 'Private beach access for morning strolls and relaxation' ),
				array( 'feature_name' => 'Master suite with a spa-inspired bathroom and ocean-facing balcony' ),
				array( 'feature_name' => 'Private garage with space for three vehicles' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Additional Fees',
					'fees'           => array(
						array( 'fee_label' => 'Property Transfer Tax', 'amount' => '2,500', 'fee_description' => 'Based on the assessed value and local regulations' ),
						array( 'fee_label' => 'Legal Fees', 'amount' => '3,000', 'fee_description' => 'Approximate cost for legal services, including title transfer' ),
						array( 'fee_label' => 'Home Inspection', 'amount' => '500', 'fee_description' => 'Recommended for due diligence' ),
						array( 'fee_label' => 'Property Insurance', 'amount' => '1,200', 'fee_description' => 'Annual cost for comprehensive coverage' ),
						array( 'fee_label' => 'Mortgage Fees', 'amount' => 'Varies', 'fee_description' => 'If applicable, consult with your lender for specific details' ),
					),
				),
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'Property Taxes', 'amount' => '1,250', 'fee_description' => 'Approximate monthly property tax based on the sale price and local rates' ),
						array( 'fee_label' => 'Homeowners\' Association Fee', 'amount' => '300', 'fee_description' => 'Monthly fee for common area maintenance and security' ),
					),
				),
				array(
					'category_title' => 'Total Initial Costs',
					'fees'           => array(
						array( 'fee_label' => 'Listing Price', 'amount' => '1,250,000', 'fee_description' => '' ),
						array( 'fee_label' => 'Additional Fees', 'amount' => '29,700', 'fee_description' => 'Property transfer tax, legal fees, inspection, insurance' ),
						array( 'fee_label' => 'Down Payment (20%)', 'amount' => '250,000', 'fee_description' => '' ),
						array( 'fee_label' => 'Mortgage Amount', 'amount' => '1,000,000', 'fee_description' => 'If applicable' ),
					),
				),
				array(
					'category_title' => 'Monthly Expenses',
					'fees'           => array(
						array( 'fee_label' => 'Property Taxes', 'amount' => '1,250', 'fee_description' => '' ),
						array( 'fee_label' => 'Homeowners\' Association Fee', 'amount' => '300', 'fee_description' => '' ),
						array( 'fee_label' => 'Mortgage Payment', 'amount' => 'Varies', 'fee_description' => 'Based on terms and interest rate (If applicable)' ),
						array( 'fee_label' => 'Property Insurance', 'amount' => '100', 'fee_description' => 'Approximate monthly cost' ),
					),
				),
			),
			'property_faqs'      => array(
				array(
					'question' => 'How do I book a viewing for this property?',
					'answer'   => 'You can easily book a viewing by filling out the inquiry form below or contacting our agents directly via phone.',
				),
				array(
					'question' => 'What documents do I need to buy this property?',
					'answer'   => 'You will need proof of identity, proof of funds or a mortgage pre-approval, and a signed purchase agreement.',
				),
				array(
					'question' => 'How can I contact an Estatein agent?',
					'answer'   => 'Our agents are available 24/7. Use the "Contact Us" page or the inquiry form on this listing to get in touch instantly.',
				),
			),
		),
		array(
			'title'              => 'Metropolitan Haven',
			'content'            => 'Immerse yourself in the energy of the city. This modern apartment offers luxury and convenience.',
			'price'              => 650000,
			'address'            => '456 Urban Avenue, Metropolis, NY',
			'bedrooms'           => 2,
			'bathrooms'          => 2,
			'area'               => '1,200 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Smart Home System' ),
				array( 'feature_name' => '24/7 Security and Concierge' ),
				array( 'feature_name' => 'Rooftop Lounge Access' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'HOA Fees', 'amount' => '450', 'fee_description' => 'Includes water, trash, and building maintenance' ),
					),
				),
			),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Rustic Retreat Cottage',
			'content'            => 'Find tranquility in the countryside. This charming cottage offers a peaceful escape from the hustle and bustle.',
			'price'              => 350000,
			'address'            => '789 Countryside Lane, Asheville, NC',
			'bedrooms'           => 3,
			'bathrooms'          => 2,
			'area'               => '1,800 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Wood-burning fireplace' ),
				array( 'feature_name' => 'Wraparound porch' ),
				array( 'feature_name' => 'Large private garden' ),
			),
			'pricing_categories' => array(),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Skyline Loft Penthouse',
			'content'            => 'Soaring ceilings and floor-to-ceiling glass frame the downtown skyline. A chef\'s kitchen and private elevator access make this loft unforgettable.',
			'price'              => 920000,
			'address'            => '2100 Rio Grande Street, Austin, TX',
			'bedrooms'           => 3,
			'bathrooms'          => 3,
			'area'               => '2,050 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Private elevator to unit' ),
				array( 'feature_name' => 'Dual terraces with city views' ),
				array( 'feature_name' => 'Wine wall and integrated sound system' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'HOA Fees', 'amount' => '620', 'fee_description' => 'Concierge, pool, and fitness center' ),
					),
				),
			),
			'property_faqs'      => array(
				array(
					'question' => 'Is parking included?',
					'answer'   => 'Two reserved garage spaces are included with the sale.',
				),
			),
		),
		array(
			'title'              => 'Garden Lane Townhome',
			'content'            => 'Tree-lined streets meet modern finishes in this end-unit townhome with a fenced patio ideal for entertaining.',
			'price'              => 515000,
			'address'            => '1440 Garden Lane, Portland, OR',
			'bedrooms'           => 2,
			'bathrooms'          => 2,
			'area'               => '1,340 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'End unit with extra windows' ),
				array( 'feature_name' => 'EV-ready garage' ),
				array( 'feature_name' => 'Low-maintenance yard with irrigation' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'HOA Fees', 'amount' => '185', 'fee_description' => 'Exterior maintenance and landscaping' ),
					),
				),
			),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Harborview Condominium',
			'content'            => 'Watch ferries glide across the water from this corner unit with upgraded finishes and a walkable waterfront neighborhood.',
			'price'              => 780000,
			'address'            => '88 Elliott Bay Terrace, Seattle, WA',
			'bedrooms'           => 2,
			'bathrooms'          => 2,
			'area'               => '1,410 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Corner layout with panoramic views' ),
				array( 'feature_name' => 'Heated floors in primary bath' ),
				array( 'feature_name' => 'Storage locker and bike room' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'HOA Fees', 'amount' => '540', 'fee_description' => 'Waterfront building maintenance and reserves' ),
					),
				),
			),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Maple Ridge Estate',
			'content'            => 'A classic New England estate on rolling acres with a barn, pond, and guest wing—perfect for multi-generational living or a weekend retreat.',
			'price'              => 1850000,
			'address'            => '62 Maple Ridge Road, Stowe, VT',
			'bedrooms'           => 5,
			'bathrooms'          => 4,
			'area'               => '4,200 Sq. Ft.',
			'inquiry_email'      => 'hello@estatein.com',
			'features'           => array(
				array( 'feature_name' => 'Guest wing with separate entrance' ),
				array( 'feature_name' => 'Heated barn and workshop' ),
				array( 'feature_name' => 'Stone fireplace in great room' ),
				array( 'feature_name' => 'Whole-home generator' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Additional Fees',
					'fees'           => array(
						array( 'fee_label' => 'Septic inspection', 'amount' => '350', 'fee_description' => 'Recommended at closing' ),
					),
				),
			),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Desert Bloom Adobe',
			'content'            => 'Authentic adobe construction meets contemporary solar and rainwater systems in this efficient desert sanctuary.',
			'price'              => 425000,
			'address'            => '401 Arroyo Seco, Santa Fe, NM',
			'bedrooms'           => 2,
			'bathrooms'          => 2,
			'area'               => '1,560 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Courtyard with native plantings' ),
				array( 'feature_name' => 'Rooftop solar array (owned)' ),
				array( 'feature_name' => 'Radiant heat throughout' ),
			),
			'pricing_categories' => array(),
			'property_faqs'      => array(),
		),
		array(
			'title'              => 'Lakeside Glass Cabin',
			'content'            => 'Minimalist glass walls bring the lake indoors. A private dock slip and sauna round out this modern mountain escape.',
			'price'              => 1100000,
			'address'            => '9 Pinecone Point, Lake Tahoe, CA',
			'bedrooms'           => 3,
			'bathrooms'          => 2,
			'area'               => '2,240 Sq. Ft.',
			'inquiry_email'      => '',
			'features'           => array(
				array( 'feature_name' => 'Private dock slip' ),
				array( 'feature_name' => 'Sauna and cold plunge' ),
				array( 'feature_name' => 'Snow-melt driveway' ),
			),
			'pricing_categories' => array(
				array(
					'category_title' => 'Monthly Costs',
					'fees'           => array(
						array( 'fee_label' => 'HOA / road maintenance', 'amount' => '275', 'fee_description' => 'Private road and shared pier upkeep' ),
					),
				),
			),
			'property_faqs'      => array(
				array(
					'question' => 'Is the dock transferable?',
					'answer'   => 'Yes—the slip transfers with the deed subject to HOA approval.',
				),
			),
		),
	);
}

/**
 * Insert property posts from demo definitions.
 *
 * @param array<int, array<string, mixed>> $properties Rows from estatein_dummy_seed_property_definitions().
 * @param int                                $author_id  WordPress user ID.
 */
function estatein_dummy_seed_insert_properties( $properties, $author_id ) {
	foreach ( $properties as $prop ) {
		$post_id = wp_insert_post(
			array(
				'post_title'   => $prop['title'],
				'post_content' => $prop['content'],
				'post_status'  => 'publish',
				'post_type'    => 'property',
				'post_author'  => $author_id,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		update_field( 'price', $prop['price'], $post_id );
		update_field( 'address', $prop['address'], $post_id );
		update_field( 'bedrooms', $prop['bedrooms'], $post_id );
		update_field( 'bathrooms', $prop['bathrooms'], $post_id );
		update_field( 'area', $prop['area'], $post_id );
		update_field( 'inquiry_email', $prop['inquiry_email'], $post_id );
		update_field( 'features', $prop['features'], $post_id );
		update_field( 'pricing_categories', $prop['pricing_categories'], $post_id );
		update_field( 'property_faqs', $prop['property_faqs'], $post_id );
	}
}

/**
 * Sites seeded with v1 (three properties) automatically get six more when an admin loads the dashboard.
 */
function estatein_dummy_seed_migrate_v1_demo_properties() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( '1' !== get_option( 'estatein_dummy_data_seeded_version', '' ) ) {
		return;
	}
	if ( '2' !== ESTATEIN_DUMMY_SEED_VERSION ) {
		return;
	}
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$author_id = get_current_user_id();
	if ( $author_id < 1 ) {
		$author_id = 1;
	}

	$defs  = estatein_dummy_seed_property_definitions();
	$extra = array_slice( $defs, 3 );
	if ( $extra === array() ) {
		return;
	}

	estatein_dummy_seed_insert_properties( $extra, $author_id );
	update_option( 'estatein_dummy_data_seeded_version', '2' );

	estatein_dummy_seed_set_notice(
		'success',
		__( 'Estatein demo: added 6 more sample properties (demo data updated to v2).', 'estatein-growmodo' )
	);
}

/**
 * Register admin hooks for dummy seeding.
 */
function estatein_dummy_seed_bootstrap() {
	add_action( 'admin_init', 'estatein_dummy_seed_migrate_v1_demo_properties', 0 );
	add_action( 'admin_init', 'estatein_maybe_seed_dummy_data', 1 );
	add_action( 'admin_notices', 'estatein_dummy_seed_admin_notices' );
	add_action( 'admin_menu', 'estatein_dummy_seed_register_tools_page' );
}
add_action( 'after_setup_theme', 'estatein_dummy_seed_bootstrap' );

/**
 * Tools screen with a one-click link (correct nonce + admin context).
 */
function estatein_dummy_seed_register_tools_page() {
	add_management_page(
		__( 'Estatein demo data', 'estatein-growmodo' ),
		__( 'Estatein demo data', 'estatein-growmodo' ),
		'manage_options',
		'estatein-dummy-seed',
		'estatein_dummy_seed_render_tools_page'
	);
}

/**
 * Tools → Estatein demo data.
 */
function estatein_dummy_seed_render_tools_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$seeded = ESTATEIN_DUMMY_SEED_VERSION === get_option( 'estatein_dummy_data_seeded_version', '' );
	$run    = wp_nonce_url( admin_url( 'index.php?seed_estatein_data=1' ), 'estatein_seed_dummy' );
	$force  = wp_nonce_url( admin_url( 'index.php?seed_estatein_data=1&estatein_seed_force=1' ), 'estatein_seed_dummy' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Estatein demo data', 'estatein-growmodo' ); ?></h1>
		<p><?php esc_html_e( 'Creates nine sample properties, testimonials, and team members. Requires Advanced Custom Fields.', 'estatein-growmodo' ); ?></p>
		<?php if ( $seeded ) : ?>
			<div class="notice notice-info inline"><p><?php esc_html_e( 'Demo data has already been seeded for this site version.', 'estatein-growmodo' ); ?></p></div>
			<p><a class="button button-primary" href="<?php echo esc_url( $run ); ?>"><?php esc_html_e( 'Run again (same version — will show a warning)', 'estatein-growmodo' ); ?></a></p>
			<p><a class="button" href="<?php echo esc_url( $force ); ?>"><?php esc_html_e( 'Force run (creates duplicate posts)', 'estatein-growmodo' ); ?></a></p>
		<?php else : ?>
			<p><a class="button button-primary" href="<?php echo esc_url( $run ); ?>"><?php esc_html_e( 'Run demo seeder', 'estatein-growmodo' ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Run seeder when requested via query args + nonce + capability.
 */
function estatein_maybe_seed_dummy_data() {
	if ( ! is_admin() || ! estatein_dummy_seed_query_flag( 'seed_estatein_data' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		estatein_dummy_seed_set_notice( 'error', __( 'Estatein seed: you need administrator rights.', 'estatein-growmodo' ) );
		estatein_dummy_seed_redirect_after_attempt();
	}

	if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( (string) $_GET['_wpnonce'] ) ), 'estatein_seed_dummy' ) ) {
		estatein_dummy_seed_set_notice(
			'error',
			__( 'Estatein seed: invalid or missing security token. Use Tools → Estatein demo data, or a fresh wp_nonce_url() link while logged in.', 'estatein-growmodo' )
		);
		estatein_dummy_seed_redirect_after_attempt();
	}

	if ( ! function_exists( 'update_field' ) ) {
		estatein_dummy_seed_set_notice( 'error', __( 'ACF is not active — fields were not saved.', 'estatein-growmodo' ) );
		estatein_dummy_seed_redirect_after_attempt();
	}

	$force = estatein_dummy_seed_query_flag( 'estatein_seed_force' );
	if ( ! $force && ESTATEIN_DUMMY_SEED_VERSION === get_option( 'estatein_dummy_data_seeded_version', '' ) ) {
		estatein_dummy_seed_set_notice( 'warning', __( 'Dummy data was already seeded. Add &estatein_seed_force=1 to run again (may create duplicate posts).', 'estatein-growmodo' ) );
		estatein_dummy_seed_redirect_after_attempt();
	}

	$author_id = get_current_user_id();
	if ( $author_id < 1 ) {
		$author_id = 1;
	}

	estatein_dummy_seed_insert_properties( estatein_dummy_seed_property_definitions(), $author_id );

	$testimonials = array(
		array(
			'title'       => 'Exceptional Service',
			'content'     => 'Our experience with Estatein was outstanding. Their team was dedicated and professional.',
			'client_name' => 'Wade Warren',
			'location'    => 'USA, California',
			'rating'      => 5,
		),
		array(
			'title'       => 'Efficient and Reliable',
			'content'     => 'Estatein provided us with top-notch service. They helped us sell our property quickly and at a great price.',
			'client_name' => 'Emelie Thomson',
			'location'    => 'USA, Florida',
			'rating'      => 5,
		),
		array(
			'title'       => 'Trusted Advisors',
			'content'     => 'The Estatein team guided us through the entire buying process. Their knowledge and experience were invaluable.',
			'client_name' => 'John Mans',
			'location'    => 'USA, Nevada',
			'rating'      => 4,
		),
	);

	foreach ( $testimonials as $test ) {
		$post_id = wp_insert_post(
			array(
				'post_title'   => $test['title'],
				'post_content' => $test['content'],
				'post_status'  => 'publish',
				'post_type'    => 'testimonial',
				'post_author'  => $author_id,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		update_field( 'client_name', $test['client_name'], $post_id );
		update_field( 'location', $test['location'], $post_id );
		update_field( 'rating', $test['rating'], $post_id );
	}

	$team_members = array(
		array( 'title' => 'Max Mitchell', 'role' => 'Founder' ),
		array( 'title' => 'Sarah Johnson', 'role' => 'Chief Real Estate Officer' ),
		array( 'title' => 'David Brown', 'role' => 'Head of Property Management' ),
		array( 'title' => 'Michael Turner', 'role' => 'Legal Counsel' ),
	);

	foreach ( $team_members as $member ) {
		$post_id = wp_insert_post(
			array(
				'post_title'  => $member['title'],
				'post_status' => 'publish',
				'post_type'   => 'team_member',
				'post_author' => $author_id,
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		update_field( 'role', $member['role'], $post_id );
	}

	update_option( 'estatein_dummy_data_seeded_version', ESTATEIN_DUMMY_SEED_VERSION );

	estatein_dummy_seed_set_notice(
		'success',
		__( 'Estatein dummy data seeded: nine sample properties, testimonials, and team members.', 'estatein-growmodo' )
	);
	estatein_dummy_seed_redirect_after_attempt();
}

/**
 * @param string $type notice-success|notice-error|notice-warning.
 * @param string $message Plain text.
 */
function estatein_dummy_seed_set_notice( $type, $message ) {
	$key = 'estatein_seed_notice_' . get_current_user_id();
	set_transient(
		$key,
		array(
			'type'    => $type,
			'message' => $message,
		),
		120
	);
}

/**
 * Redirect to strip seed query args (avoid accidental re-run on refresh).
 */
function estatein_dummy_seed_redirect_after_attempt() {
	$target = remove_query_arg(
		array( 'seed_estatein_data', '_wpnonce', 'estatein_seed_force' ),
		admin_url()
	);
	wp_safe_redirect( $target );
	exit;
}

/**
 * Flash admin notices after redirect.
 */
function estatein_dummy_seed_admin_notices() {
	$key  = 'estatein_seed_notice_' . get_current_user_id();
	$data = get_transient( $key );
	if ( ! is_array( $data ) || empty( $data['message'] ) ) {
		return;
	}
	delete_transient( $key );

	$class = 'notice-info';
	if ( 'success' === ( $data['type'] ?? '' ) ) {
		$class = 'notice-success';
	} elseif ( 'error' === ( $data['type'] ?? '' ) ) {
		$class = 'notice-error';
	} elseif ( 'warning' === ( $data['type'] ?? '' ) ) {
		$class = 'notice-warning';
	}

	printf(
		'<div class="notice %1$s is-dismissible"><p>%2$s</p></div>',
		esc_attr( $class ),
		esc_html( (string) $data['message'] )
	);
}
