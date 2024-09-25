<?php
/**
 * Register custom shortcodes
 *
 * @package webassembler-base
 */

/**
 * Display contact address from Website Options
 */
add_shortcode(
	'primary_address',
	function( $atts = null ) {
		$footer_company_details = get_field( 'company_details', 'option' );
		if ( empty( $footer_company_details['primary_address'] ) ) {
			return;
		}
		return sprintf(
			'<span class="%s">%s</span>',
			esc_attr( 'p sc__primary_address' ),
			wp_kses(
				$footer_company_details['primary_address'],
				array(
					'br' => array(),
				)
			)
		);
	}
);

/**
 * Display contact email from Website Options
 */
add_shortcode(
	'contact_email',
	function( $atts = null, $text = null ) {
		$footer_company_details = get_field( 'company_details', 'option' );
		if ( empty( $footer_company_details['contact_email'] ) ) {
			return;
		}
		return sprintf(
			'<span class="%s"><a href="mailto:%s">%s</a></span>',
			esc_attr( 'p sc__contact_email' ),
			esc_attr( $footer_company_details['contact_email'] ),
			esc_html( wp_strip_all_tags( $footer_company_details['contact_email'] ) ),
		);
	}
);

/**
 * Display contact tel from Website Options
 */
add_shortcode(
	'contact_phone_number',
	function( $atts = null, $text = null ) {
		$footer_company_details = get_field( 'company_details', 'option' );
		if ( empty( $footer_company_details['contact_phone_number'] ) ) {
			return;
		}
		$atts = shortcode_atts(
			array(
				'icon' => false,
			),
			$atts,
			'contact_phone_number'
		);

		$phone_number = str_replace( ' ', '', $footer_company_details['contact_phone_number'] );
		return sprintf(
			'%s<a class="%s" href="tel:%s">%s</a>',
			( true === $atts['icon'] ) ?
				sprintf(
					'<span class="%s"></span>',
					esc_attr( 'icon-mobile' )
				) : null,
			esc_attr( 'p sc__contact_phone_number' ),
			esc_attr( trim( $phone_number ) ),
			wp_kses(
				$footer_company_details['contact_phone_number'],
				array(
					'br' => array(),
				)
			)
		);
	}
);

/**
 * Display social media icons from Website Options
 */
add_shortcode(
	'social_icons',
	function( $atts = null, $text = null ) {
		$icon_urls = get_field( 'social_media_details', 'option' );
		if ( empty( $icon_urls ) ) {
			return;
		}

		$atts = shortcode_atts(
			array(
				'mode' => 'light',
			),
			$atts,
			'social_icons'
		);

		$icon_html = '';
		if ( ! empty( $icon_urls ) ) {
			foreach ( $icon_urls as $platform => $icon_url ) {
				if ( 'instagram_url' === $platform ) {
					$icon_html .= sprintf(
						'<a href="%s" aria-label="%s" target="_blank" rel="noopener noreferrer">
						<span class="%s"></span></a>',
						esc_url( $icon_url ),
						esc_attr( 'Instagram' ),
						esc_attr( 'icon-instagram' ),
					);
				}
				if ( 'facebook_url' === $platform ) {
					$icon_html .= sprintf(
						'<a href="%s" aria-label="%s" target="_blank" rel="noopener noreferrer">
						<span class="%s"></span></a>',
						esc_url( $icon_url ),
						esc_attr( 'Facebook' ),
						esc_attr( 'icon-facebook' ),
					);
				}
				if ( 'twitter_url' === $platform ) {
					$icon_html .= sprintf(
						'<a href="%s" aria-label="%s" target="_blank" rel="noopener noreferrer">
						<span class="%s"></span></a>',
						esc_url( $icon_url ),
						esc_attr( 'Twitter' ),
						esc_attr( 'icon-twitter' ),
					);
				}
			}
		}

		$social_icons_wrapper_class  = 'social_icon__wrapper';
		$social_icons_wrapper_class .= ' mode--' . $atts['mode'];

		return sprintf(
			'<div class="%s">%s</div>',
			esc_attr( $social_icons_wrapper_class ),
			$icon_html,
		);
	}
);

