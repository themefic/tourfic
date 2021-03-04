<?php

/**
 * Archive post layout
 */
function tourfic_archive_single() {
	$tf_room = get_field('tf_room') ? get_field('tf_room') : array();
	?>
	<div class="single-tour-wrap">
		<div class="single-tour-inner">
			<div class="tourfic-single-left">
				<?php if( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail('full'); ?>
				<?php endif;?>
			</div>
			<div class="tourfic-single-right">
				<!-- Title area Start -->
				<div class="tf_property_block_main_row">
					<div class="tf_item_main_block">
						<div class="tf-hotel__title-wrap">
							<a href="<?php the_permalink(); ?>"><h3 class="tourfic_hotel-title"><?php the_title(); ?></h3></a>
						</div>
						<?php tf_map_link(); ?>
					</div>
					<?php tf_item_review_block(); ?>
				</div>
				<!-- Title area End -->

				<?php if( $tf_room ) : $i = 0; ?>
				<!-- Room details start -->
				<div class="sr_rooms_table_block">
					<?php foreach ( $tf_room as $key => $room_type ) : ?>
						<?php
						if(++$i > 1){
							break;
						}
						// Array to variable
						extract( $room_type );
						?>
						<div class="room_details">
							<div class="featuredRooms">
								<div class="roomrow_flex">

									<div class="roomName_flex">
										<div class="roomNameInner">
											<div class="room_link">
												<div class="tf-archive-roomname"><strong><?php echo esc_html( $name ); ?></strong> <span class="dash">-</span> <span><?php tf_pax( $pax ); ?></span></div>
												<ul class="tf-archive-desc"><?php echo do_shortcode( $desc ); ?></ul>
												<div class="bui-price-display__value prco-inline-block-maker-helper" aria-hidden="true"><?php echo tf_price_html($price, $sale_price); ?></div>
											</div>
										</div>
									</div>

									<div class="roomPrice roomPrice_flex sr_discount">
										<div class="prco-ltr-right-align-helper">
											<div class="tf-archive-shortdesc"><?php echo do_shortcode( $short_desc ); ?></div>
										</div>
									</div>

								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<!-- Room details end -->

				<div class="availability-btn-area">
					<a href="<?php the_permalink(); ?>" class="button tf_button"><?php esc_html_e( 'Book Now', 'tourfic' ); ?></a>
				</div>
				<?php endif; ?>


			</div>
		</div>
	</div>

	<?php
}

// Review block
function tf_item_review_block(){

	$comments = get_comments( array( 'post_id' => get_the_ID() ) );

	$tf_overall_rate = array();
	$tf_overall_rate['review'] = null;

	$tf_extr_html = '';

	foreach ( $comments as $comment ) {

	    $tf_comment_meta = get_comment_meta( $comment->comment_ID, 'tf_comment_meta', true );

	    if( $tf_comment_meta ) {
	    	foreach ($tf_comment_meta as $key => $value) {
	    		$tf_overall_rate[$key][] = $value ? $value : "5";
	    	}
	    } else {
	    	$tf_overall_rate['review'][] = "5";
	    	$tf_overall_rate['sleep'][] = "5";
	    	$tf_overall_rate['location'][] = "5";
	    	$tf_overall_rate['services'][] = "5";
	    	$tf_overall_rate['cleanliness'][] = "5";
	    	$tf_overall_rate['rooms'][] = "5";
	    }
	}

	?>
	<div class="tf_item_review_block">
		<div class="reviewFloater reviewFloaterBadge__container">
		    <div class="sr-review-score">
		        <a class="sr-review-score__link" href="<?php the_permalink(); ?>" target="_blank">
		            <div class="bui-review-score c-score bui-review-score--end">
		                <div class="bui-review-score__badge"> <?php _e( tf_avg_ratings($tf_overall_rate['review']) ); ?> </div>
		                <div class="bui-review-score__content">
		                    <div class="bui-review-score__title"> <?php esc_html_e( 'Review score', 'tourfic' ); ?> </div>
		                    <div class="bui-review-score__text">
							<?php
							$comments_title = apply_filters(
								'tf_comment_form_title',
								sprintf( // WPCS: XSS OK.
									/* translators: 1: number of comments */
									esc_html( _nx( '%1$s review', '%1$s reviews', get_comments_number(), 'comments title', 'tourfic' ) ),
									number_format_i18n( get_comments_number() ),
								)
							);

							echo esc_html( $comments_title );
							?>
		                    </div>
		                </div>
		            </div>
		        </a>
		    </div>
		</div>
	</div>
	<?php
}

// Map Link
function tf_map_link(){
	$location = get_field('formatted_location') ? get_field('formatted_location') : null;

	if ( !$location ) {
		return;
	}
	?>
	<!-- Start map link -->
	<div class="tf_map-link">
		<?php echo tf_get_svg('checkin'); ?> <a title="<?php echo esc_attr( $location ); ?>" href="https://www.google.com/maps/search/<?php _e( $location ); ?>" target="_blank"><?php echo esc_html( $location ); ?></a>

	</div>
	<!-- End map link -->
	<?php
}

// Sidebar
function get_tf_sidebar( $placement = 'single' ){
	?>

	<!-- Start Booking widget -->
	<form class="tf_booking-widget" method="get" autocomplete="off" action="<?php echo tf_booking_search_action(); ?>">
		<div class="tf_widget-title"><?php esc_html_e( 'Search', 'tourfic' ); ?></div>

		<!-- Start form row -->
		<?php tf_booking_widget_field(
			array(
				'type' => 'text',
				'svg_icon' => 'search',
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
				'type' => 'select',
				'svg_icon' => 'person',
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

		<?php tf_booking_widget_field(
			array(
				'type' => 'select',
				'svg_icon' => 'checkin',
				'name' => 'room',
				'id' => 'room',
				'options' => array(
					'1' => '1 room',
					'2' => '2 rooms',
					'3' => '3 rooms',
					'4' => '4 rooms',
					'5' => '5 rooms',
				)
			)
		); ?>

		<?php tf_booking_widget_field(
			array(
				'type' => 'select',
				'svg_icon' => 'people_outline',
				'name' => 'children',
				'id' => 'children',
				'options' => array(
					'0' => '0 child',
					'1' => '1 child',
					'2' => '2 childrens',
					'3' => '3 childrens',
					'4' => '4 childrens',
					'5' => '5 childrens',
				)
			)
		); ?>


		<div class="tf_booking-dates">
			<!-- Start form row -->
			<?php tf_booking_widget_field(
				array(
					'type' => 'text',
					'svg_icon' => 'calendar_today',
					'name' => 'check-in-out-date',
					'placeholder' => 'Check-in/Check-out date',
					'label' => 'Check-in/Check-out date',
					'required' => 'true',
					'disabled' => 'true',
				)
			); ?>
			<!-- End form row -->

			<div class="screen-reader-text">
				<!-- Start form row -->
				<?php tf_booking_widget_field(
					array(
						'type' => 'text',
						'svg_icon' => 'calendar_today',
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
						'svg_icon' => 'calendar_today',
						'name' => 'check-out-date',
						'placeholder' => 'Check-out date',
						'required' => 'true',
						'disabled' => 'true',
						'label' => 'Check-out date',
					)
				); ?>
			</div>
			<!-- End form row -->
		</div>

		<!-- Start form row -->
		<div class="tf_form-row">
			<button class="tf_button tf-submit" type="submit"><?php esc_html_e( 'Search', 'tourfic' ); ?></button>
		</div>
		<!-- End form row -->

	</form>
	<!-- End Booking widget -->

	<!-- Start map tour widget -->
	<div class="tf-map-tour-wrap">
		<?php $location = get_field('formatted_location') ? get_field('formatted_location') : null; ?>
		<div class="map-bg"><img src="<?php echo TF_PLUGIN_URL; ?>/assets/map.png"></div>
		<div class="map-buttons">
			<a href="https://www.google.com/maps/search/<?php _e( $location ); ?>" target="_blank" class="button tf_button"><?php esc_html_e( 'Show on map', 'tourfic' ); ?></a>
		</div>
	</div>
	<!-- End map tour widget -->

	<!-- Start similar tour widget -->
	<div class="tf-similar-tour-wrap">
		<div class="not-impressive"><?php esc_html_e( 'Not impressive?', 'tourfic' ); ?></div>
		<div class="ni-buttons">
			<a href="#" class="button tf_button btn-outline"><?php esc_html_e( 'Show more hotels', 'tourfic' ); ?></a>
		</div>
	</div>
	<!-- End similar tour widget -->

	<!-- Start ask ques tour widget -->
	<div class="tf-gotq-tour-wrap">
		<div class="gotq-top">
			<h4><?php esc_html_e( 'Got a question?', 'tourfic' ); ?></h4>
			<p><?php esc_html_e( 'Find more info in the FAQ section.', 'tourfic' ); ?></p>
		</div>
		<div class="ni-buttons">
			<a href="#" id="tf-ask-question-trigger" class="button tf_button btn-outline"><?php esc_html_e( 'Ask a question', 'tourfic' ); ?></a>
		</div>
	</div>
	<!-- End ask ques tour widget -->
	<?php if ( $placement == 'archive' ) : ?>
		<?php if ( is_active_sidebar( 'tf_single_booking_sidebar' ) ) { ?>
		    <div id="tf__booking_sidebar">
		        <?php dynamic_sidebar('tf_single_booking_sidebar'); ?>
		    </div>
		<?php } ?>
	<?php else: ?>
		<?php if ( is_active_sidebar( 'tf_archive_booking_sidebar' ) ) { ?>
		    <div id="tf__booking_sidebar">
		        <?php dynamic_sidebar('tf_archive_booking_sidebar'); ?>
		    </div>
		<?php } ?>
	<?php endif; ?>
	<?php
}