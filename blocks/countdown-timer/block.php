<?php
/**
 * Block Name: Countdown Timer
 *
 * Note - if block is not being used, remove from webpack and
 * remove luxon.js from package.json.
 *
 * @author Anthony Vickery-Hartnell <anthony@webassembler.co.uk>
 * @package webassembler-base
 */

$block_id = webassembler_get_block_id( $block, 'webassembler-countdown-timer' );

$data = array(
	'timer_heading'          => get_field( 'countdown_timer_heading', 'option' ),
	'timer_background_image' => get_field( 'countdown_timer_background_image', 'option' ),
);

$block_classes = array(
	'webassembler-block',
	'block-countdown-timer',
	'alignfull',
);

$block_classes = webassembler_get_block_classes( $block, $block_classes );

/**
 * The date in the block is formatted to be an ISO_8601 (which includes
 * the "T" character for Time. This is needed for the Luxon library
 */

$timer_date       = get_field( 'countdown_timer_date', 'option' );
$background_image = $data['timer_background_image'];
// $block_pinned      = $countdown_timer_settings['countdown_timer_pinned'];

$future_date__date = gmdate( 'Y-m-d', strtotime( $timer_date ) );
$future_date__time = gmdate( 'H:i:s', strtotime( $timer_date ) );
$current_date      = gmdate( 'Y-m-d' );
$countdown_iso8601 = $future_date__date . 'T' . $future_date__time;
$show_seconds      = true;

// Hide the block if the future date is now or in the past.
if ( strtotime( $future_date__date ) <= strtotime( $current_date ) ) {
	return;
}

$data['readable_date'] = gmdate( 'd F Y', strtotime( $timer_date ) );
$data['future_date']   = $countdown_iso8601;
$data['show_seconds']  = $show_seconds;

/**
 * Pass the block data into the template part.
 */
get_template_part(
	'blocks/countdown-timer/template',
	null,
	array(
		'block'      => $block,
		'post_id'    => $post_id,
		'data'       => $data,
		'class_name' => $block_classes,
		'block_id'   => $block_id,
	)
);
