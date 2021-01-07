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

				<?php if( $tf_room ) : ?>
				<!-- Room details start -->
				<div class="sr_rooms_table_block">
					<?php foreach ( $tf_room as $key => $room_type ) : ?>
						<?php
						// Array to variable
						extract( $room_type );
						?>
						<div class="room_details">
							<div class="featuredRooms">
								<div class="roomrow_flex">

									<div class="roomName_flex">
										<div class="roomNameInner">
											<div class="room_link">
												<div><strong><?php echo esc_html( $name ); ?></strong></div>
												<div><?php echo $short_desc; ?></div>
											</div>
										</div>
									</div>

									<div class="roomPrice roomPrice_flex sr_discount">
										<div class="prco-ltr-right-align-helper">
											<div class="bui-price-display__value prco-inline-block-maker-helper" aria-hidden="true"><?php echo tf_price_html($price, $sale_price); ?></div>
										</div>
									</div>

								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<!-- Room details end -->

				<div class="availability-btn-area">
					<a href="<?php the_permalink(); ?>" class="button tf_button"><?php esc_html_e( 'See availability', 'tourfic' ); ?></a>
				</div>
				<?php endif; ?>


			</div>
		</div>
	</div>

	<?php
}

function tf_item_review_block(){
	return;
	?>
	<div class="tf_item_review_block">
		<div class="reviewFloater reviewFloaterBadge__container">
		    <div class="sr-review-score">
		        <a class="sr-review-score__link" href="/" target="_blank">
		            <div class="bui-review-score c-score bui-review-score--end">
		                <div class="bui-review-score__badge" aria-label="Scored 9.2 "> 9.2 </div>
		                <div class="bui-review-score__content">
		                    <div class="bui-review-score__title"> Superb </div>
		                    <div class="bui-review-score__text"> 44 reviews </div>
		                </div>
		            </div>
		        </a>
		    </div>
		</div>
	</div>
	<?php
}

function tf_map_link(){
	$location = get_field('formatted_location') ? get_field('formatted_location') : null;
	?>
	<!-- Start map link -->
	<div class="tf_map-link">
		<?php echo tf_get_svg('checkin'); ?> <?php echo esc_html( $location ); ?>
	</div>
	<!-- End map link -->
	<?php
}