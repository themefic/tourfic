<?php

add_action( 'wp_ajax_tf_add_new_room', 'tf_add_room_data_action' );
function tf_add_room_data_action(){

	$key = sanitize_text_field( $_POST['key'] );

	ob_start();
	?>
	<div class="tf-add-single-room-wrap">
		<div class="tf-add-single-room-head">
			<div class="tf-room-title"># Room Title</div>

			<span class="room-action-btns">
				<a href="#" class="room-remove"><span class="dashicons dashicons-no-alt"></span></a>
			</span>

			<a href="#" class="room-expend"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
		</div>

		<div class="tf-add-single-room-body">
			<input type="text" name="tf_room[<?php _e( $key ); ?>][name]" id="">
			<input type="text" name="tf_room[<?php _e( $key ); ?>][description]" id="">
		</div>
	</div>

	<?php
	$output = ob_get_clean();

	echo $output;

	die();
}