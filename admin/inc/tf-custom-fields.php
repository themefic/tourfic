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
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 0 );
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

        if ( isset( $_POST['tf_gallery_ids'] ) ) {
        	update_post_meta( $post_id, 'tf_gallery_ids', sanitize_text_field( $_POST['tf_gallery_ids'] ) );
        }

        if ( isset( $_POST['information'] ) ) {
            update_post_meta(
                $post_id,
                'information',
                implode( "\n", array_map( 'sanitize_textarea_field', explode( "\n", $_POST['information'] ) ) )
            );
        }

        if ( isset( $_POST['additional_information'] ) ) {
            update_post_meta( $post_id, 'additional_information', $_POST['additional_information'] );
        }

        if ( isset( $_POST['terms_and_conditions'] ) ) {
            update_post_meta( $post_id, 'terms_and_conditions', $_POST['terms_and_conditions'] );
        }

		// Set room
		$tf_room = isset( $_POST['tf_room'] ) ? (array) $_POST['tf_room'] : array();
		// Sanitize
		//$tf_room = array_map( 'esc_attr', $tf_room );
 		// Push to post meta
        update_post_meta( $post_id, 'tf_room', (array) $tf_room );

        // Set faq
        $tf_faqs = isset( $_POST['tf_faqs'] ) ? (array) $_POST['tf_faqs'] : array();
        // Sanitize
        //$tf_faqs = array_map( 'esc_attr', $tf_faqs );
        // Push to post meta
        update_post_meta( $post_id, 'tf_faqs', (array) $tf_faqs );

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
        $tf_room = ( get_post_meta( $post->ID, 'tf_room', true ) ) ? get_post_meta( $post->ID, 'tf_room', true ) : array();
        $tf_faqs = ( get_post_meta( $post->ID, 'tf_faqs', true ) ) ? get_post_meta( $post->ID, 'tf_faqs', true ) : array();

        // Get Post meta
        $formatted_location = get_post_meta( $post->ID, 'formatted_location', true );
        $tf_gallery_ids = get_post_meta( $post->ID, 'tf_gallery_ids', true );
        $information = get_post_meta( $post->ID, 'information', true );
        $additional_information = get_post_meta( $post->ID, 'additional_information', true );
        $terms_and_conditions = get_post_meta( $post->ID, 'terms_and_conditions', true );

        // Display the form, using the current value.
        ?>

		<div class="tf-tab-container-wrap">
			<div class="tf-box-head">
				<ul class="tf-tab-nav">
                    <li class="active"><a href="#highlights-tab"><?php echo esc_html__( 'Highlights', 'tourfic' ); ?></a></li>
					<li><a href="#rooms"><?php echo esc_html__( 'Rooms', 'tourfic' ); ?></a></li>
					<li><a href="#gallery"><?php echo esc_html__( 'Gallery', 'tourfic' ); ?></a></li>
					<li><a href="#location"><?php echo esc_html__( 'Location', 'tourfic' ); ?></a></li>
					<li><a href="#tf_information"><?php echo esc_html__( 'Property Description', 'tourfic' ); ?></a></li>
                    <li><a href="#faqs-tab"><?php echo esc_html__( 'FAQs', 'tourfic' ); ?></a></li>
                    <li><a href="#tos-tab"><?php echo esc_html__( 'Terms & Conditions', 'tourfic' ); ?></a></li>
				</ul>
			</div>

	   		<div class="tf-box-content">
				<div class="tf-tab-container">

					<div id="rooms" class="tf-tab-content">

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

						<div class="tf-field-wrap tf_gallery-field-wrap">
							<div class="tf_gallery-images">
								<?php if ( $tf_gallery_ids ) {

									// Comma seperated list to array
									$tf_gallery_id_arr = explode(',', $tf_gallery_ids);

									foreach ( $tf_gallery_id_arr as $key => $id ) {
										echo '<span class="tf_gallery-img" id="'.$id.'">';
										echo wp_get_attachment_image( $id, 'full' );
										echo '</span>';
									}
								} ?>
                            </div>
                            <input type="hidden" name="tf_gallery_ids" class="tf_gallery_ids_push" value="<?php echo esc_attr( $tf_gallery_ids ); ?>">
                            <div class="tf_add-gallery-buttons">
                                <button type="button" class="tf_add-gallery button"><?php esc_html_e( 'Add Gallery Images', 'tourfic' ); ?></button>
                            </div>
						</div>
					</div>

					<div id="location" class="tf-tab-content">

						<h4><?php esc_html_e( 'Location Options', 'tourfic' ); ?></h4>

						<div class="tf-field-wrap">
							<div class="tf-label">
								<label for="formatted_location"><?php esc_html_e( 'Formatted Location', 'tourfic' ); ?></label>
							</div>

					        <input type="text" class="wfull" id="formatted_location" name="formatted_location" value="<?php echo esc_attr( $formatted_location ); ?>" size="25" />
						</div>

					</div>

					<div id="highlights-tab" class="tf-tab-content active">
                        <h4><?php esc_html_e( 'Highlights', 'tourfic' ); ?></h4>
                        <div class="tf-field-wrap">

                            <?php
                                $content   = $additional_information;
                                $editor_id = 'additional_information';

                                $settings = array(
                                    'quicktags' => array('buttons' => 'em,strong,link',),
                                    'quicktags' => true,
                                    'tinymce' => 1,
                                    'textarea_rows' => 20,
                                    'media_buttons' => 0,
                                );

                                wp_editor( $content, $editor_id, $settings );

                            ?>
                        </div>

					</div>

                    <div id="tf_information" class="tf-tab-content">

                        <h4><?php esc_html_e( 'Information', 'tourfic' ); ?></h4>

                        <div class="tf-field-wrap">
                            <div class="tf-label">
                                <label for="information"><?php esc_html_e( 'Add Property Description', 'tourfic' ); ?></label>
                            </div>
                            <textarea name="information" class="wfull" rows="5" id="information"><?php _e( $information ); ?></textarea>
                        </div>

                    </div>

                    <div id="faqs-tab" class="tf-tab-content">

                        <h4><?php esc_html_e( 'Frequently Asked Questions', 'tourfic' ); ?></h4>

                        <div class="tf-field-wrap">
                            <div class="tf_faqs-fields">
                                <?php if ( $tf_faqs ) {
                                    foreach ( $tf_faqs as $key => $faq ) {
                                        echo tf_add_single_faq( array(
                                            'key' => $key,
                                            'faq' => $faq,
                                        ) );
                                    }
                                } ?>
                            </div>
                            <div class="tf_add-faq-buttons">
                                <button type="button" class="tf_add-faq button"><?php esc_html_e( 'Add FAQ', 'tourfic' ); ?></button>
                            </div>
                        </div>

                    </div>

                    <div id="tos-tab" class="tf-tab-content">
                        <h4><?php esc_html_e( 'Add Terms & Conditions', 'tourfic' ); ?></h4>
                        <div class="tf-field-wrap">

                            <?php
                                $content   = $terms_and_conditions;
                                $editor_id = 'terms_and_conditions';

                                $settings = array(
                                    'quicktags' => array('buttons' => 'em,strong,link',),
                                    'quicktags' => true,
                                    'tinymce' => 1,
                                    'textarea_rows' => 20,
                                    //'media_buttons' => 0,
                                );

                                wp_editor( $content, $editor_id, $settings );

                            ?>
                        </div>

                    </div>

				</div>
			</div>
		</div>

        <?php
    }
}