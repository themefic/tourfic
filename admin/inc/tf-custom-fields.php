<?php
/**
 * Calls the class on the post edit screen.
 */
function tf_load_metabox() {
    new Tourfic_Metabox_Class();
}

if ( is_admin() ) {
    add_action( 'load-post.php',     'tf_load_metabox' );
    add_action( 'load-post-new.php', 'tf_load_metabox' );
}


/**
 * The Class.
 */
class Tourfic_Metabox_Class {

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post',      array( $this, 'save'         ) );
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box( $post_type ) {
        // Limit meta box to certain post types.
        $post_types = array( 'tourfic' );

        if ( in_array( $post_type, $post_types ) ) {
            add_meta_box(
                'tourfic_options_metabox',
                __( 'Tourfic Options', 'tourfic' ),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save( $post_id ) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( ! isset( $_POST['tourfic_custom_box_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['tourfic_custom_box_nonce'];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'tourfic_custom_box_security' ) ) {
            return $post_id;
        }

        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        /* OK, it's safe for us to save the data now. */


        // Update the meta fields.

        if ( isset( $_POST['formatted_location'] ) ) {
        	update_post_meta( $post_id, 'formatted_location', sanitize_text_field( $_POST['formatted_location'] ) );
        }


		// Set room
		$tf_room = isset( $_POST['tf_room'] ) ? (array) $_POST['tf_room'] : array();
		// Sanitize
		//$tf_room = array_map( 'esc_attr', $tf_room );
 		// Push to post meta
        update_post_meta( $post_id, 'tf_room', (array) $tf_room );


    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'tourfic_custom_box_security', 'tourfic_custom_box_nonce' );

        // Room Data
        $tf_room = get_post_meta( $post->ID, 'tf_room', true );

        // Post meta
        $formatted_location = get_post_meta( $post->ID, 'formatted_location', true );



        // Display the form, using the current value.
        ?>

		<div class="tf-tab-container-wrap">
			<div class="tf-box-head">
				<ul class="tf-tab-nav">
					<li class="active"><a href="#rooms"><?php echo esc_html__( 'Rooms', 'tourfic' ); ?></a></li>
					<li><a href="#gallery"><?php echo esc_html__( 'Gallery', 'tourfic' ); ?></a></li>
					<li><a href="#location"><?php echo esc_html__( 'Location', 'tourfic' ); ?></a></li>
					<li><a href="#information"><?php echo esc_html__( 'Information', 'tourfic' ); ?></a></li>
					<li><a href="#additional-info"><?php echo esc_html__( 'Additional Information', 'tourfic' ); ?></a></li>

				</ul>
			</div>

	   		<div class="tf-box-content">
				<div class="tf-tab-container">

					<div id="rooms" class="tf-tab-content active">

						<h4><?php esc_html_e( 'Room Options', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf_room-fields">
								<?php if ( $tf_room ) {
									foreach ( $tf_room as $key => $room ) {
										echo tf_add_single_room_wrap( array(
											'key' => $key,
											'room' => $room,
										) );
									}
								} ?>
                            </div>
                            <div class="tf_add-room-buttons">
                                <button type="button" class="tf_add-room button"><?php esc_html_e( 'Add Room', 'tourfic' ); ?></button>
                            </div>
						</div>

					</div>

					<div id="gallery" class="tf-tab-content">

						<h4><?php esc_html_e( 'Gallery', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="myplugin_new_field"><?php esc_html_e( 'Description', 'tourfic' ); ?></label>
							</div>

					        <input type="text" id="myplugin_new_field" name="myplugin_new_field" value="<?php echo esc_attr( $value ); ?>" size="25" />
						</div>

					</div>

					<div id="location" class="tf-tab-content">

						<h4><?php esc_html_e( 'Location Options', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="formatted_location"><?php esc_html_e( 'Formatted Location', 'tourfic' ); ?></label>
							</div>

					        <input type="text" id="formatted_location" name="formatted_location" value="<?php echo esc_attr( $formatted_location ); ?>" size="25" />
						</div>

					</div>

					<div id="information" class="tf-tab-content">

						<h4><?php esc_html_e( 'Information', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="formatted_location"><?php esc_html_e( 'Formatted Location', 'tourfic' ); ?></label>
							</div>

					        <input type="text" id="formatted_location" name="formatted_location" value="<?php echo esc_attr( $formatted_location ); ?>" size="25" />
						</div>

					</div>

					<div id="additional-info" class="tf-tab-content">

						<h4><?php esc_html_e( 'Additional Information', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="formatted_location"><?php esc_html_e( 'Formatted Location', 'tourfic' ); ?></label>
							</div>

					        <input type="text" id="formatted_location" name="formatted_location" value="<?php echo esc_attr( $formatted_location ); ?>" size="25" />
						</div>

					</div>

				</div>
			</div>
		</div>

        <?php
    }
}