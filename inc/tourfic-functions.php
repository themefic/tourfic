<?php

if ( !function_exists('get_field') ) {
	function get_field( $selector, $post_id = false, $format_value = true ) {

		// if not $post_id, load queried object
		if( !$post_id ) {
			// try for global post (needed for setup_postdata)
			$post_id = (int) get_the_ID();
			// try for current screen
			if( !$post_id ) {
				$post_id = get_queried_object();
			}

		}

		// format value
		if( $post_id ) {
			// get value for field
			$value = get_post_meta( $post_id, $selector, true );
		}

		// return
		return ($value) ? $value : null;

	}
}


/**
 * Review form
 */
function get_tf_review_form( ){
	//Declare Vars
	$comment_send = __( 'Submit', 'tourfic' );
	$comment_reply = __( 'Leave a Review', 'tourfic' );
	$comment_reply_to = __( 'Reply', 'tourfic' );

	$comment_author = 'Name';
	$comment_email = 'E-Mail';
	$comment_body = 'Comment';
	$comment_url = 'Website';
	$comment_cookies_1 = ' By commenting you accept the';
	$comment_cookies_2 = ' Privacy Policy';

	$comment_before = 'Registration isn\'t required.';

	$comment_cancel = 'Cancel Reply';

	//Array
	$comments_args = array(
	    //Define Fields
	    'fields' => array(
	        //Author field
	        'author' => '<p class="comment-form-author"><br /><input id="author" name="author" aria-required="true" placeholder="' . $comment_author .'"></input></p>',
	        //Email Field
	        'email' => '<p class="comment-form-email"><br /><input id="email" name="email" placeholder="' . $comment_email .'"></input></p>',
	        //URL Field
	        'url' => '<p class="comment-form-url"><br /><input id="url" name="url" placeholder="' . $comment_url .'"></input></p>',
	        //Cookies
	        'cookies' => '<input type="checkbox" required>' . $comment_cookies_1 . '<a href="' . get_privacy_policy_url() . '">' . $comment_cookies_2 . '</a>',
	    ),
	    // Change the title of send button
	    'label_submit' => $comment_send,
	    // Change the title of the reply section
	    'title_reply' => $comment_reply,
	    // Change the title of the reply section
	    'title_reply_to' => $comment_reply_to,
	    //Cancel Reply Text
	    'cancel_reply_link' => $comment_cancel,
	    // Redefine your own textarea (the comment body).
	    'comment_field' => '<p class="comment-form-comment"><br /><textarea id="comment" name="comment" aria-required="true" placeholder="' . $comment_body .'"></textarea></p>',
	    //Message Before Comment
	    'comment_notes_before' => $comment_before,
	    // Remove "Text or HTML to be displayed after the set of comment fields".
	    'comment_notes_after' => '',
	    //Submit Button ID
	    'id_submit' => 'comment-submit',
	);

	comment_form( $comments_args );

}

/**
 * Sample template tag function for outputting a cmb2 file_list
 *
 * @param  string  $file_list_meta_key The field meta key. ('wiki_test_file_list')
 * @param  string  $img_size           Size of image to show
 */
function tourfic_gallery_slider( $file_list_meta_key = array(), $post_id = null ) {

	if ( !$file_list_meta_key ) {
		return;
	}

	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	// Get the list of files
	$tf_gallery_ids = get_post_meta( $post_id, $file_list_meta_key, 1 );

	// Comma seperated list to array
	$files = explode(',', $tf_gallery_ids);

	?>
	<div class="list-single-main-media fl-wrap" id="sec1">
	    <div class="single-slider-wrapper fl-wrap">
	        <div class="tf_slider-for fl-wrap">
				<?php foreach ( $files as $attachment_id ) {
					echo '<div class="slick-slide-item">';
						echo wp_get_attachment_image( $attachment_id, 'full' );
					echo '</div>';
				} ?>
	        </div>
	        <div class="swiper-button-prev sw-btn"><i class="fa fa-angle-left"></i></div>
	        <div class="swiper-button-next sw-btn"><i class="fa fa-angle-right"></i></div>
	    </div>
	    <div class="single-slider-wrapper fl-wrap">
	        <div class="tf_slider-nav fl-wrap">
	        	<?php foreach ( (array) $files as $attachment_id ) {
					echo '<div class="slick-slide-item">';
						echo wp_get_attachment_image( $attachment_id, 'thumbnail' );
					echo '</div>';
				} ?>

	        </div>
	    </div>
	</div>
	<?php
}


function tf_booking_widget_field( $args ){
	$defaults = array (
        'type' => '',
        'svg_icon' => '',
        'id' => '',
        'name' => '',
        'default' => '',
        'options' => array(),
        'required' => false,
        'label' => '',
        'placeholder' => '',
        'class' => false,
        'disabled' => false,
        'echo' => TRUE
    );
	$args = wp_parse_args( $args, $defaults );

	$svg_icon     = esc_attr( $args['svg_icon'] );
	$type     = esc_attr( $args['type'] );
	$name     = esc_attr( $args['name'] );
    $class    = esc_attr( $args['class'] );

    $id       = $args['id'] ? esc_attr( $args['id'] ) : $name;
    $required = $args['required'] ? 'required' : '';

    $label = $args['label'] ? "<span class='tf-label'>".$args['label']."</span>" : '';

    $disabled = $args['disabled'] ? "onkeypress='return false;" : '';

    $placeholder = esc_attr( $args['placeholder'] );

    $default_val =  isset( $_POST[$name] ) ? $_POST[$name] : tf_getcookie( $name );
    $default = $args['default'] ? esc_attr( $args['default'] ) : $default_val;

    if ( !$name ) {
    	return;
    }

    $output = '';

    if ( $type == 'select' ) {

    	$output .= "<div class='tf_form-row'>";
	    	$output .= "<label class='tf_label-row'>";
	    		$output .= "<div class='tf_form-inner'>";
	    		$output .= "<span class='icon'>";
	    			$output .= tf_get_svg('checkin');
	    		$output .= "</span>";
	    		$output .= "<select $required name='$name' id='$id' class='$class'>";

	    		foreach ( $args['options'] as $key => $value) {
	    			$output .= "<option value='$key' ".selected( $default, $key, false ).">{$value}</option>";
	    		}

				$output .= "</select>
				</div>
			</label>
		</div>";

    } else {

    	$output .= "<div class='tf_form-row'>";
	    	$output .= "<label class='tf_label-row'>";
	    		$output .= $label;
	    		$output .= "<div class='tf_form-inner'>";
	    			$output .= "<span class='icon'>";
	    				$output .= tf_get_svg('checkin');
	    			$output .= "</span>";

					$output .= "<input type='text' name='$name' $required  id='$id' $disabled class='$class' placeholder='$placeholder' value='$default' />";

				$output .= "</div>
			</label>
		</div>";

    }

    if ( $args['echo'] ) {
        echo $output;
    }

    return $output;

}

// Pagination
function tf_posts_navigation(){
	global $wp_query;
	$max_num_pages = $wp_query->max_num_pages;
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	echo "<div id='am_posts_navigation'>";
	echo paginate_links( array(
		//'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
	    'format'  => 'page/%#%',
	    'current' => $paged,
	    'total'   => $max_num_pages,
	    'mid_size'        => 2,
	    'prev_next'       => false,
	) );
	echo "</div>";
}


/**
 * Set Cookie Data
 */
function tf_setcookie( $cookie = null, $value = null ){

    $expiry = strtotime('+15 day');

	if ( $cookie && $value ) {
	    setcookie( $cookie, $value, $expiry, COOKIEPATH, COOKIE_DOMAIN );
	    return true;
	} else {
		return false;
	}
}

/**
 * Get Cookie Data
 */
function tf_getcookie( $cookie = null ){
	if ( $cookie && isset( $_COOKIE[$cookie] ) ) {
		return $_COOKIE[$cookie];
	} else {
		return false;
	}
}

/**
 * Sitewide Set Cookie Function
 *
 */
function tourfic_setcookie_sitewide(){

	if ( is_admin() ) {
		return;
	}

    $user_id = get_current_user_id();

    if( isset( $_POST['destination'] ) ) {

    	foreach ( $_POST as $key => $value ) {
    		tf_setcookie( $key, $value );
    	}

    }

}
add_action('init', 'tourfic_setcookie_sitewide', 5 );
//add_action('template_redirect', 'tourfic_setcookie_sitewide', 5 );

/**
 * Get Cookie Data
 */
function tf_delete_cookie( $cookie = null ){

    $expiry = strtotime('-1 day');

	if ( $cookie && isset( $_COOKIE[$cookie] ) ) {
	    unset( $_COOKIE[$cookie] );

	    setcookie($cookie, '', $expiry, COOKIEPATH, COOKIE_DOMAIN);
	    setcookie($cookie, '', $expiry, "/");

	    return true;
	} else {
		return false;
	}
}

/**
 * Submit button data
 */
function tf_room_booking_submit_button( $label = null ){

	$booking_fields = array(
		'destination',
		'check-in-date',
		'check-out-date',
		'adults',
		'room',
		'children',
	);

	foreach ( $booking_fields as $key ) {

		$value = isset( $_POST[$key] ) ? $_POST[$key] : tf_getcookie( $key );

		echo "<input type='hidden' placeholder='{$key}' name='{$key}' value='{$value}'>";
	}

	?>
	<button class="tf_button" type="submit"><?php esc_html_e( $label ); ?></button>
	<?php
}

// Protected Pass
function tf_proctected_product_pass(){
	return "111111";
}

// Notice wrapper
function tf_notice_wrapper(){
	?>
	<div class="tf_container">
		<div class="tf_notice_wrapper"></div>
	</div>
	<?php
}
add_action( 'tf_before_container', 'tf_notice_wrapper', 10 );

// Booking Form Action Link
function tf_booking_search_action(){
	return apply_filters( 'tf_booking_search_action', esc_url( get_post_type_archive_link('tourfic') ) );
}

/**
 * Pre get posts [tourfic]
 */
add_action('pre_get_posts','tourfic_search_pre_get_posts_filter', 999);
function tourfic_search_pre_get_posts_filter( $query ) {

	if ( !isset( $_POST['destination'] ) ) {
		return $query;
	}

	if ( $query->is_main_query() && ! is_admin() ) {
		if ( $query->is_post_type_archive( 'tourfic' ) ) {

			//$query->set( 'orderby', 'meta_value title' );
			//$query->set( 'order', 'ASC' );
			$query->set( 's', $_POST['destination'] );

		}
	}

  	return $query;
}

function tf_price_html( $price = null, $sale_price = null ) {
	if ( !$price ) {
		return;
	}
	ob_start();
	?>
	<?php if ( $sale_price > 0 ) { ?>
		<span class="tf-price"><del><?php echo wc_price( $sale_price ); ?></del></span>
	<?php } ?>

	<span class="tf-price"><?php echo wc_price( $price ); ?></span>
	<div class="price-per-night"><?php esc_html_e( 'Price per night as low as', 'tourfic' ); ?></div>
	<?php
	return ob_get_clean();
}

// return only raw price
function tf_price_raw( $price = null, $sale_price = null ) {
	if ( !$price ) {
		return;
	}

	if ( $sale_price > 0 ) {
		return $sale_price;
	}

	return $price;
}