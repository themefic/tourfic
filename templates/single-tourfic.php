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
$features = array();

?>
<div class="tourfic-wrap default-style" data-fullwidth="true">
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

				<?php if( $additional_information ): ?>
				<!-- Start highlights content -->
				<div class="tf_contents highlights">
					<div class="highlights-title">
						<h4><?php esc_html_e( 'Highlights', 'tourfic' ); ?></h4>
					</div>
					<?php _e( $additional_information ); ?>
				</div>
				<!-- End highlights content -->
				<?php endif; ?>

				<!-- Start content -->
				<div class="tf_contents">
					<div class="listing-title">
						<h4><?php esc_html_e( 'Listing Description', 'tourfic' ); ?></h4>
					</div>
					<?php the_content(); ?>
				</div>
				<!-- End content -->

				<?php if( $features ) : ?>
				<!-- Start features -->
				<div class="tf_features">

				</div>
				<!-- End features -->
				<?php endif; ?>


				<?php if( $tf_room ) : ?>
				<!-- Start Room Type -->
				<div class="tf_room-type" id="rooms">
					<div class="listing-title">
						<h4><?php esc_html_e( 'Availability', 'tourfic' ); ?></h4>
					</div>
					<div class="tf_room-row">
						<table class="availability-table">
							<thead>
							    <tr>
							      <th><?php esc_html_e( 'Room Type', 'tourfic' ); ?></th>
							      <th><?php esc_html_e( 'Pax', 'tourfic' ); ?></th>
							      <th><?php esc_html_e( 'Total Price', 'tourfic' ); ?></th>
							      <th><?php esc_html_e( 'Select Rooms', 'tourfic' ); ?></th>
							    </tr>
							</thead>
							<tbody>
							<!-- Start Single Room -->
							<?php foreach ( $tf_room as $key => $room_type ) : ?>
								<?php
								// Array to variable
								extract( $room_type );
								?>
								<tr>
							      <td>
							      	<div class="tf-room-type">
										<div class="tf-room-title"><?php echo esc_html( $name ); ?></div>
										<div class="bed-facilities"><?php echo $short_desc; ?></div>

										<div class="room-features">
											<h5><?php esc_html_e( 'Room Features', 'tourfic' ); ?></h5>
											<ul class="room-feature-list">
												<li></li>
											</ul>
										</div>
									</div>
							      </td>

							      <td>$100</td>
							      <td>$100</td>
							      <td>$100</td>
							    </tr>
							<?php endforeach; ?>
							</tbody>
						</table>

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