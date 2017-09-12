<?php
/**
 * Stardust Theme Customizer.
 *
 * @package atarr
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function atarr_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Add our social link options.
	$wp_customize->add_section(
		'atarr_social_links_section',
		array(
			'title'       => esc_html__( 'Social Links', 'starry' ),
			'description' => esc_html__( 'These are the settings for social links.', 'starry' ),
			'priority'    => 90,
		)
	);

	// Add our Contact Email field.
	$wp_customize->add_setting(
		'atarr_email_link',
		array(
			'default' => '',
			'sanitize_callback' => 'atarr_sanitize_customizer_email',
		)
	);
	$wp_customize->add_control(
		'atarr_email_link',
		array(
			'label'   => esc_html__( 'Email', 'starry' ),
			'section' => 'atarr_social_links_section',
			'type'    => 'email',
		)
	);

	// Create an array of our social links for ease of setup.
	$social_networks = array( 'Twitter', 'Codepen', 'Github', 'Linkedin' );

	// Loop through our networks to setup our fields.
	foreach ( $social_networks as $network ) {

		$wp_customize->add_setting(
			'atarr_' . $network . '_link',
			array(
				'default' => '',
				'sanitize_callback' => 'atarr_sanitize_customizer_url',
			)
		);
		$wp_customize->add_control(
			'atarr_' . $network . '_link',
			array(
				'label'   => sprintf( esc_html__( '%s Link', 'starry' ), ucwords( $network ) ),
				'section' => 'atarr_social_links_section',
				'type'    => 'text',
			)
		);
	}

	// Add our Footer Customization section section.
	$wp_customize->add_section(
		'atarr_footer_section',
		array(
			'title'    => esc_html__( 'Footer Customization', 'starry' ),
			'priority' => 90,
		)
	);

	// Add our copyright text field.
	$wp_customize->add_setting(
		'atarr_copyright_text',
		array(
			'default' => '',
			'sanitize_callback' => 'atarr_sanitize_copyright_text',
		)
	);
	$wp_customize->add_control(
		'atarr_copyright_text',
		array(
			'label'       => esc_html__( 'Copyright Text', 'starry' ),
			'description' => esc_html__( 'The copyright text will be displayed beneath the menu in the footer.', 'starry' ),
			'section'     => 'atarr_footer_section',
			'type'        => 'text',
			'sanitize'    => 'html',
		)
	);
}
add_action( 'customize_register', 'atarr_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function atarr_customize_preview_js() {
	wp_enqueue_script( 'atarr_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'atarr_customize_preview_js' );

/**
 * Sanitize our customizer text inputs.
 *
 * @param string $input Theme Customizer object.
 */
function atarr_sanitize_customizer_text( $input ) {
	return sanitize_text_field( force_balance_tags( $input ) );
}

/**
 * Sanitize our customizer URL inputs.
 *
 * @param url $input Theme Customizer object.
 */
function atarr_sanitize_customizer_url( $input ) {
	return esc_url( $input );
}
