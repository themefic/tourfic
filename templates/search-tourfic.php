<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tourfic
 */


get_header('tourfic'); ?>

<div class="tourfic-wrap" data-fullwidth="true">
	<?php do_action( 'tf_before_container' ); ?>
	<div class="tf_container">

		<div class="tf_row">
			<!-- Start Content -->
			<div class="tf_content">
				<?php echo do_shortcode("[tf_search_result]"); ?>
			</div>
			<!-- End Content -->

			<!-- Start Sidebar -->
			<div class="tf_sidebar">

				<!-- Start Booking widget -->
				<form class="tf_booking-widget" method="get" autocomplete="off" action="<?php echo tf_booking_search_action(); ?>">
					<div class="tf_widget-title"><?php esc_html_e( 'Search', 'tourfic' ); ?></div>

					<!-- Start form row -->
					<?php tf_booking_widget_field(
						array(
							'type' => 'text',
							'svg_icon' => 'checkin',
							'name' => 'destination',
							'label' => 'Destination/property name:',
							'placeholder' => 'Destination',
							'required' => 'true',
						)
					); ?>
					<!-- End form row -->

					<!-- Start form row -->
					<?php tf_booking_widget_field(
						array(
							'type' => 'text',
							'svg_icon' => 'checkin',
							'name' => 'check-in-date',
							'placeholder' => 'Check-in date',
							'label' => 'Check-in date',
							'required' => 'true',
							'disabled' => 'true',
						)
					); ?>
					<!-- End form row -->

					<!-- Start form row -->
					<?php tf_booking_widget_field(
						array(
							'type' => 'text',
							'svg_icon' => 'checkin',
							'name' => 'check-out-date',
							'placeholder' => 'Check-out date',
							'required' => 'true',
							'disabled' => 'true',
							'label' => 'Check-out date',
						)
					); ?>
					<!-- End form row -->

					<!-- Start form row -->
					<?php tf_booking_widget_field(
						array(
							'type' => 'select',
							'svg_icon' => 'checkin',
							'name' => 'adults',
							'id' => 'adults',
							'options' => array(
								'1' => '1 adult',
								'2' => '2 adults',
								'3' => '3 adults',
								'4' => '4 adults',
								'5' => '5 adults',
								'6' => '6 adults',
							)
						)
					); ?>
					<!-- End form row -->

					<!-- Start form row -->
					<div class="tf_row thin">
						<div class="tf_col-6">
							<?php tf_booking_widget_field(
								array(
									'type' => 'select',
									'svg_icon' => 'checkin',
									'name' => 'room',
									'id' => 'room',
									'options' => array(
										'1' => '1 room',
										'2' => '2 room',
										'3' => '3 room',
										'4' => '4 room',
										'5' => '5 room',
									)
								)
							); ?>
						</div>

						<div class="tf_col-6">
							<?php tf_booking_widget_field(
								array(
									'type' => 'select',
									'svg_icon' => 'checkin',
									'name' => 'children',
									'id' => 'children',
									'options' => array(
										'0' => '0 children',
										'1' => '1 children',
										'2' => '2 childrens',
										'3' => '3 childrens',
										'4' => '4 childrens',
										'5' => '5 childrens',
									)
								)
							); ?>

						</div>
					</div>
					<!-- End form row -->

					<!-- Start form row -->
					<div class="tf_form-row">
						<button class="tf_button tf-submit" type="submit"><?php esc_html_e( 'Search', 'tourfic' ); ?></button>
					</div>
					<!-- End form row -->

				</form>
				<!-- End Booking widget -->

			</div>
			<!-- End Sidebar -->
		</div>
	</div>
	<?php do_action( 'tf_after_container' ); ?>
</div>
<?php
get_footer('tourfic');