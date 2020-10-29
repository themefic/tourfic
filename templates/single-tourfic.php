<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header('tourfic'); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
if( function_exists('get_wt_single_page') ){
	//get_wt_single_page();
}


// Get all rooms
$add_room_type = get_field('add_room_type') ? get_field('add_room_type') : array();


?>
<div class="tourfic-wrap" data-fullwidth="true">
	<?php do_action( 'tf_before_container' ); ?>
	<div class="tf_container">
		<div class="tf_row">
			<div class="tf_content tf_content-full mb-15">

				<!-- Start title area -->
				<div class="tf_title-area">
					<h2 class="tf_title"><?php the_title(); ?></h2>
					<div class="tf_title-right">
						<div class="share-tour">
							<a href="#" class="share-toggle"><?php echo tf_get_svg('share'); ?></a>
							<div class="share-tour-content">

							</div>
						</div>
						<div class="reserve-button">
							<a href="#" class="tf_button button"><?php esc_html_e( 'Reserve', 'tourfic' ); ?></a>
						</div>
					</div>
				</div>
				<!-- End title area -->

				<!-- Start map link -->
				<div class="tf_map-link">
					<?php echo tf_get_svg('checkin'); ?> Kakra Beach, Marine Drive Road Near Baitus Salam Jame Mosjid, Ramu, 4700 Samader Bāzār, Bangladesh
				</div>
				<!-- End map link -->
			</div>
		</div>

		<div class="tf_row">
			<!-- Start Content -->
			<div class="tf_content">

				<!-- Start gallery -->
				<div class="tf_gallery-wrap">
					<?php echo tourfic_gallery_slider('tourfic_gallery'); ?>
				</div>
				<!-- End gallery-->

				<!-- Start content -->
				<div class="tf_contents">
					<?php the_content(); ?>
				</div>
				<!-- End content -->


				<?php if( $add_room_type ) : ?>
				<!-- Start Room Type -->
				<div class="tf_room-type">
					<div class="tf_room-type-head">Room Type</div>
					<div class="tf_room-row">

						<!-- Start Single Room -->
						<?php foreach ( $add_room_type as $key => $room_type ) : ?>
							<?php
							// Array to variable
							extract( $room_type );
							?>
							<form class="tf-room" id="tf_room-id-<?php echo esc_attr( $key ); ?>">
								<div class="tf-room-header">
									<div class="tf-room-title"><?php echo esc_html( $room_name ); ?></div>
									<div class="last-booked"><?php echo esc_html__( 'Last booked 6 hrs ago' ); ?></div>
								</div>
								<div class="tf-room-content-wrap">
									<div class="tf-room-content-inner">
										<div class="tf-room-inner-column first">
											<div class="bed-facilities"><?php echo $bed_description; ?></div>
											<div class="tf-sale-tag"><?php esc_html_e( 'Save 53% Today', 'tourfic' ); ?></div>
											<div class="img-price-row">
												<div class="tf-room-image">
													<a href="#" class="room-image-trigger"><?php tf_svg('images'); ?></a>
												</div>
												<div class="tf-price-column">
													<span class="tf-price"><del><?php echo wc_price( $sale_price ); ?></del></span>
													<span class="tf-price"><?php echo wc_price( $price ); ?></span>
													<div class="price-per-night"><?php esc_html_e( 'Price per night as low as', 'tourfic' ); ?></div>
												</div>
											</div>
										</div>
										<div class="tf-room-inner-column tf-short-desc">
											<?php echo $room_description; ?>
										</div>
									</div>
									<div class="room-selection-wrap">
										<select name="room-selected" id="room-selected">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
										</select>
									</div>
									<div class="room-submit-wrap">
										<input type="hidden" name="tour_id" value="<?php echo get_the_ID(); ?>">
										<input type="hidden" name="room_key" value="<?php echo esc_attr( $key ); ?>">
										<?php tf_room_booking_submit_button( 'I\'ll reserve' ); ?>
									</div>
								</div>

							</form>
							<!-- End Single Room -->
						<?php endforeach; ?>
						<?php //ppr( $add_room_type ); ?>
					</div>
				</div>
				<!-- End Room Type -->
				<?php endif; ?>

				<!-- Start Tab Content -->
				<div class="tf_tab-wrap">

					<div class="tf_tab-nav">
						<a href="#description" class="tf_tab-nav-link active">Description</a>
						<a href="#additional-information" class="tf_tab-nav-link">Additional Information</a>
						<a href="#reviews" class="tf_tab-nav-link">Reviews</a>
					</div>

					<div class="tf-tab-container">
						<div class="tf_tab-content active" id="description">
							<?php the_content(); ?>
						</div>
						<div class="tf_tab-content" id="additional-information">
							Gigabyte Z97X-UD3H-BK GA-Z97X-UD3H-BK |  i5 4690K |  HD 4600 Dell Optiplex 9020 MT Q77 Board |  i7 4790 |  AORUS Radeon RX 580 Gigabyte Z68MA-D2H-B3 GA-Z68MA-D2H-B3 |  i3 2105 |  HD 3000 Dell Optiplex 9010 SFF Q77 Board |  i7 3770 |  HD 4000 Dell Optiplex 7010 USFF Q77 Board |  i5 3475S |  HD 4000
						</div>
						<div class="tf_tab-content" id="reviews">
							If you have a Haswell system simply purchase OS X Snow leopard DVD for 19.99 from Apple. Use iBoot Haswell to install Snow Leopard on your I3-4130 system. https://www.tonymacx86.com/threads/install-mac-os-x-10-6-snow-leopard-on-haswell-based-pcs.106903/ If you don't have access to a Mac or CustoMac this is the only way to get macOS from the Mac App Store. Do not get it anywhere else.
						</div>
					</div>

				</div>
				<!-- End Tab Content -->



			</div>
			<!-- End Content -->

			<!-- Start Sidebar -->
			<div class="tf_sidebar">

				<!-- Start Booking widget -->
				<form class="tf_booking-widget" method="post" autocomplete="off" action="<?php echo tf_booking_search_action(); ?>">
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
<?php endwhile; ?>
<?php
get_footer('tourfic');