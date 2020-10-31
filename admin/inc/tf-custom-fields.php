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

        // Sanitize the user input.
        $mydata = sanitize_text_field( $_POST['myplugin_new_field'] );

        // Update the meta field.
        update_post_meta( $post_id, '_my_meta_value_key', $mydata );
    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'tourfic_custom_box_security', 'tourfic_custom_box_nonce' );

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta( $post->ID, '_my_meta_value_key', true );

        // Display the form, using the current value.
        ?>

		<div class="tf-tab-container-wrap">
			<div class="tf-box-head">
				<ul class="tf-tab-nav">
					<li class="active"><a href="#rooms"><?php echo esc_html__( 'Rooms', 'tourfic' ); ?></a></li>
					<li><a href="#gallery"><?php echo esc_html__( 'Gallery', 'tourfic' ); ?></a></li>
					<li><a href="#location"><?php echo esc_html__( 'Location', 'tourfic' ); ?></a></li>

				</ul>
			</div>

	   		<div class="tf-box-content">
				<div class="tf-tab-container">

					<div id="rooms" class="tf-tab-content active">

						<h4><?php esc_html_e( 'Room Options', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf_room-fields">

                            </div>
                            <div class="tf_add-room-buttons">
                                <button type="button" class="tf_add-room button">Add Room</button>
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
								<label for="tf_formatted-field"><?php esc_html_e( 'Formatted Location', 'tourfic' ); ?></label>
							</div>

					        <input type="text" id="tf_formatted-field" name="tf_formatted-field" value="<?php echo esc_attr( $value ); ?>" size="25" />
						</div>

					</div>

				</div>
			</div>
		</div>

        <?php
    }
}