<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header('tourfic'); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php

// Get all rooms
$tf_room = get_field('tf_room') ? get_field('tf_room') : array();
$information = get_field('information') ? get_field('information') : null;
$additional_information = get_field('additional_information') ? get_field('additional_information') : null;
$share_text = get_the_title();
$share_link = esc_url( home_url("/?p=").get_the_ID() );
$location = get_field('formatted_location') ? get_field('formatted_location') : null;

?>
<div class="tourfic-wrap style-2" data-fullwidth="true">
	<?php do_action( 'tf_before_container' ); ?>
	<div class="tf_container">
		<div class="tf_row">
			<div class="tf_content tf_content-full mb-15">

				<!-- Start title area -->
				<div class="tf_title-area">
					<h2 class="tf_title"><?php the_title(); ?></h2>
					<div class="tf_title-right">
						<div class="share-tour">
							<a href="#dropdown_share_center" class="share-toggle" data-toggle="true"><?php echo tf_get_svg('share'); ?></a>
							<div id="dropdown_share_center" class="share-tour-content">
 								<ul class="tf-dropdown__content">
									<li>
									    <a href="http://www.facebook.com/share.php?u=<?php _e( $share_link ); ?>" class="tf-dropdown__item" target="_blank">
									        <span class="tf-dropdown__item-content"><?php echo tf_get_svg('facebook'); ?> <?php esc_html_e( 'Share on Facebook', 'tourfic' ); ?></span>
									    </a>
									</li>
									<li>
									    <a href="http://twitter.com/share?text=<?php _e( $share_text ); ?>&url=<?php _e( $share_link ); ?>" class="tf-dropdown__item" target="_blank">
									        <span class="tf-dropdown__item-content"><?php echo tf_get_svg('twitter'); ?> <?php esc_html_e( 'Share on Twitter', 'tourfic' ); ?></span>
									    </a>
									</li>
									<li>
									    <div class="share_center_copy_form tf-dropdown__item" title="Share this link" aria-controls="share_link_button">
									        <label class="share_center_copy_label" for="share_link_input"><?php esc_html_e( 'Share this link', 'tourfic' ); ?></label>
									        <input type="text" id="share_link_input" class="share_center_url share_center_url_input" value="<?php _e( $share_link ); ?>" readonly>
									        <button id="share_link_button" class="share_center_copy_cta" tabindex="0" role="button">
									        	<span class="tf-button__text share_center_copy_message"><?php esc_html_e( 'Copy link', 'tourfic' ); ?></span>
									            <span class="tf-button__text share_center_copied_message"><?php esc_html_e( 'Copied!', 'tourfic' ); ?></span>
									        </button>
									    </div>
									</li>
								</ul>
							</div>
						</div>
						<div class="show-on-map">
							<a href="https://www.google.com/maps/search/<?php _e( $location ); ?>" target="_blank" class="tf_button btn-outline button"><?php esc_html_e( 'Show on map', 'tourfic' ); ?></a>
						</div>
						<div class="reserve-button">
							<a href="#rooms" class="tf_button button"><?php esc_html_e( 'Reserve', 'tourfic' ); ?></a>
						</div>
					</div>
				</div>
				<!-- End title area -->

				<!-- Start map link -->
				<div class="tf_map-link">
					<?php tf_map_link(); ?>
				</div>
				<!-- End map link -->
			</div>
		</div>

		<div class="tf_row">
			<!-- Start Content -->
			<div class="tf_content">

				<!-- Start gallery -->
				<div class="tf_gallery-wrap">
					<?php echo tourfic_gallery_slider('tf_gallery_ids'); ?>
				</div>
				<!-- End gallery-->

				<!-- Start content -->
				<div class="tf_contents">
					<?php the_content(); ?>
				</div>
				<!-- End content -->


				<?php if( $tf_room ) : ?>
				<!-- Start Room Type -->
				<div class="tf_room-type" id="rooms">
					<div class="tf_room-type-head"><?php esc_html_e( 'All Available Rooms', 'tourfic' ); ?></div>
					<div class="tf_room-row">

						<!-- Start Single Room -->
						<?php foreach ( $tf_room as $key => $room_type ) : ?>
							<?php
							// Array to variable
							extract( $room_type );
							?>
							<form class="tf-room" id="tf_room-id-<?php echo esc_attr( $key ); ?>">
								<div class="tf-room-header">
									<div class="tf-room-title"><?php echo esc_html( $name ); ?></div>
									<div class="last-booked"><?php echo esc_html__( 'Last booked 6 hrs ago' ); ?></div>
								</div>
								<div class="tf-room-content-wrap">
									<div class="tf-room-content-inner">
										<div class="tf-room-inner-column first">
											<div class="bed-facilities"><?php echo $short_desc; ?></div>
											<?php echo tf_sale_tag($price, $sale_price); ?>
											<div class="img-price-row">
												<div class="tf-room-image">
													<a href="#" class="room-image-trigger"><?php tf_svg('images'); ?></a>
												</div>
												<div class="tf-price-column">
													<?php echo tf_price_html($price, $sale_price); ?>
												</div>
											</div>
										</div>
										<div class="tf-room-inner-column tf-short-desc">
											<?php echo $desc; ?>
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
						<a href="#description" class="tf_tab-nav-link active"><?php esc_html_e( 'Description', 'tourfic' ); ?></a>
						<a href="#additional-information" class="tf_tab-nav-link"><?php esc_html_e( 'Additional Information', 'tourfic' ); ?></a>
						<a href="#reviews" class="tf_tab-nav-link"><?php esc_html_e( 'Reviews', 'tourfic' ); ?></a>
					</div>

					<div class="tf-tab-container">
						<div class="tf_tab-content active" id="description">
							<?php _e($information); ?>
						</div>
						<div class="tf_tab-content" id="additional-information">
							<?php _e($additional_information); ?>
						</div>
						<div class="tf_tab-content" id="reviews">
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>

						</div>
					</div>

				</div>
				<!-- End Tab Content -->

			</div>
			<!-- End Content -->

			<!-- Start Sidebar -->
			<div class="tf_sidebar">
				<?php get_tf_sidebar(); ?>
			</div>
			<!-- End Sidebar -->
		</div>
	</div>
	<?php do_action( 'tf_after_container' ); ?>
</div>
<?php endwhile; ?>
<?php
get_footer('tourfic');