<?php

add_action( 'wp_ajax_tf_add_new_room', 'tf_add_room_data_action' );
function tf_add_room_data_action(){

	$key = sanitize_text_field( $_POST['key'] );

	ob_start();

	echo tf_add_single_room_wrap( array(
		'key' => $key,
	) );

	$output = ob_get_clean();

	echo $output;

	die();
}

// Single room data
function tf_add_single_room_wrap( $args ){
    $defaults = array (
        'key' => '',
        'room' => '',
    );

    // Parse incoming $args into an array and merge it with $defaults
    $args = wp_parse_args( $args, $defaults );

    // Let's extract the array
    extract( $args['room'] );

    // Array key
    $key =  isset( $args['key'] ) ? $args['key'] : "";

    $room_title = ( $name ) ? $name : __( '# Room Title', 'tourfic' );

	ob_start();
	?>
	<div class="tf-add-single-room-wrap">
		<div class="tf-add-single-room-head">
			<div class="tf-room-title"><?php echo esc_html( $room_title ); ?></div>

			<span class="room-action-btns">
				<a href="#" class="room-remove"><span class="dashicons dashicons-no-alt"></span></a>
			</span>

			<a href="#" class="room-expend"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
		</div>

		<div class="tf-add-single-room-body">
			<div class="tf-room-field-holder">

				<div class="tf-field-wrap label-left">
					<div class="tf-label">
						<label for="tf_room-name-<?php _e( $key ); ?>"><?php esc_html_e( 'Room Name', 'tourfic' ); ?></label>
					</div>
				     <input type="text" name="tf_room[<?php _e( $key ); ?>][name]" class="tf_room-name" id="tf_room-name-<?php _e( $key ); ?>" value="<?php echo esc_attr( $name ); ?>">
				</div>

				<div class="tf-field-wrap label-left">
					<div class="tf-label">
						<label for="tf_room-short_desc-<?php _e( $key ); ?>"><?php esc_html_e( 'Short Description', 'tourfic' ); ?></label>
					</div>
				    <textarea name="tf_room[<?php _e( $key ); ?>][short_desc]" class="tf_room-short_desc" id="tf_room-short_desc-<?php _e( $key ); ?>" rows="5"><?php _e( $short_desc ); ?></textarea>
				</div>

				<div class="tf-field-wrap label-left">
					<div class="tf-label">
						<label for="tf_room-desc-<?php _e( $key ); ?>"><?php esc_html_e( 'Description', 'tourfic' ); ?></label>
					</div>
				    <textarea name="tf_room[<?php _e( $key ); ?>][desc]" class="tf_room-desc" rows="5" id="tf_room-desc-<?php _e( $key ); ?>"><?php _e( $short_desc ); ?></textarea>
				</div>

				<div class="tf-row">
					<div class="tf-col-6">
						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="tf_room-price-<?php _e( $key ); ?>"><?php esc_html_e( 'Price', 'tourfic' ); ?></label>
							</div>
						    <input type="number" step="any" min="0" name="tf_room[<?php _e( $key ); ?>][price]" class="tf_room-price" id="tf_room-price-<?php _e( $key ); ?>" value="<?php echo esc_attr( $price ); ?>">
						</div>
					</div>
					<div class="tf-col-6">
						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="tf_room-sale_price-<?php _e( $key ); ?>"><?php esc_html_e( 'Sale Price',  'tourfic' ); ?></label>
							</div>
						    <input type="number" step="any" min="0" name="tf_room[<?php _e( $key ); ?>][sale_price]" class="tf_room-sale_price" id="tf_room-sale-price-<?php _e( $key ); ?>" value="<?php echo esc_attr( $sale_price ); ?>">
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<?php
	$output = ob_get_clean();

	return $output;

}