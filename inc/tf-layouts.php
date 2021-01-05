<?php

/**
 * Archive post layout
 */
function tourfic_archive_single() {
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

				<!-- Room details start -->
				<div class="sr_rooms_table_block">
					<div class="room_details">
						<div class="featuredRooms">
							<div class="roomrow_flex">

								<div class="roomName_flex">
									<div class="roomNameInner">
										<div class="room_link">
											<div><strong>Deluxe Double Room</strong> - <span class="c-occupancy-icons"></span></div>
											<div>1 bed(<span class="sr_gr_bed_type">1 large double</span>)</div>
										</div>
									</div>
								</div>

								<div class="roomPrice roomPrice_flex sr_discount">
									<div class="prco-ltr-right-align-helper">
										<div class="bui-price-display__label prco-inline-block-maker-helper">1 night, 2 adults</div>
									</div>
									<div class="prco-ltr-right-align-helper">
										<div class="bui-price-display__value prco-inline-block-maker-helper" aria-hidden="true">BDT&nbsp;5,129</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<!-- Room details end -->
				<div class="availability-btn-area">
					<a href="<?php the_permalink(); ?>" class="button tf_button"><?php esc_html_e( 'See availability', 'tourfic' ); ?></a>
				</div>


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