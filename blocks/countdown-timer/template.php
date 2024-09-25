<?php
/**
 * Block Name: Countdown Timer
 *
 * @author Anthony Vickery-Hartnell <anthony@webassembler.co.uk>
 * @package itij
 * @since version 1.0
 */

$block      = $args['block'];
$data       = $args['data'];
$block_id   = $args['block_id'];
$class_name = $args['class_name'];

?>
<div id="<?php echo esc_attr( sanitize_title( $block_id ) ); ?>" class="<?php echo esc_attr( $class_name ); ?>"
	<?php
	if ( ! empty( $data['future_date'] ) ) {
		printf(
			' data-countdown="%s"',
			esc_attr( $data['future_date'] ),
		);
	}

	// if ( true === $block_pinned ) {
	// 	print( ' data-block-pinned="true"' );
	// } else {
	// 	print( ' data-block-pinned="false"' );
	// }
	?>
	>
	<div class="countdown_timer__wrapper">
		<?php
		if ( $data['timer_background_image'] ) {
			echo wp_get_attachment_image( $data['timer_background_image'], 'full' );
		}
		?>
		<div class="countdown_timer__content">
			<?php if ( $data['timer_heading'] ) : ?>
				<h3 class="wp-block-heading has-text-color has-white-color"><?php echo esc_html( $data['timer_heading'] ); ?></h3>
			<?php endif; ?>

			<?php if ( $data['readable_date'] ) : ?>
				<p class="readible_date heading--special">
					<?php echo esc_html( $data['readable_date'] ); ?>
				</p>
			<?php endif; ?>

			<div class="countdown_timer__counter">
				<div class="countdown_timer__times">
					<div class="timer__item timer__item--day">
						<span class="timer__value day"></span>
						<span class="timer__title"></span>
					</div>
					<div class="timer__item timer__item--hour">
						<span class="timer__value hour"></span>
						<span class="timer__title"></span>
					</div>
					<div class="timer__item timer__item--minute">
						<span class="timer__value minute"></span>
						<span class="timer__title"></span>
					</div>
					<?php if ( $data['show_seconds'] ) : ?>
						<div class="timer__item timer__item--second">
							<span class="timer__value second"></span>
							<span class="timer__title"></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
