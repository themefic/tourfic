<?php
/**
 * Shortcode Function
 */
function tourfic_destinations_shortcode( $atts, $content = null ){

    // Shortcode extract
    extract(
      shortcode_atts(
        array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 0,
          ),
        $atts
      )
    );

    // Propertise args
    $args = array(
        'post_type' => 'tourfic',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    // 1st search on Destination taxonomy
    $destinations = get_terms( array(
        'taxonomy' => 'destination',
        'orderby' => $orderby,
        'order' => $order,
        'hide_empty' => $hide_empty, //can be 1, '1' too
        'hierarchical' => 0, //can be 1, '1' too
        'search' => '',
        'number' => 5,
        //'name__like' => '',
    ) );

    ob_start();

    if ( $destinations ) : ?>
    <!-- Recommended destinations  -->
    <section id="recomended_section_wrapper">
        <div class="recomended_inner">
        <?php foreach( $destinations as $term ) :
            $image_id = get_term_meta( $term->term_id, 'category-image-id', true );
            $term_link = get_term_link( $term );

            if ( is_wp_error( $term_link ) ) {
                continue;
            }
            ?>

          <div class="single_recomended_item">
            <a href="<?php echo esc_url( $term_link ); ?>">
              <div class="single_recomended_content" style="background-image: url(<?php echo wp_get_attachment_url( $image_id ); ?>);">
                <div class="recomended_place_info_header">
                  <h3><?php _e($term->name); ?></h3>
                  <p><?php printf( esc_html__( "%s properties", 'tourfic' ), $term->count); ?></p>
                </div>
                <?php if( $term->description ): ?>
                    <div class="recomended_place_info_footer">
                        <p><?php echo nl2br($term->description); ?></p>
                    </div>
                <?php endif; ?>
              </div>
            </a>
          </div>

        <?php endforeach; ?>
        </div>
     </section>
    <!-- Recommended destinations  End-->
    <?php endif; ?>
    <?php return ob_get_clean();
}

add_shortcode('tourfic_destinations', 'tourfic_destinations_shortcode');

function tourfic_tours_shortcode( $atts, $content = null ){
  extract(
    shortcode_atts(
      array(
          'style'  => 'populer', //recomended, populer
          'title'  => 'Populer Destinaiton',  //title populer section
          'subtitle'  => 'Populer Destinaiton Subtitle',   // Sub title populer section
          'count'  => 6,
        ),
      $atts
    )
  );

  $args = array(
    'post_type' => 'tourfic',
    'post_status' => 'publish',
    'posts_per_page' => $count,
  );

  ob_start();




    $hotel_loop = new WP_Query( $args );
   ?>

  <!-- Populer Destinaiton -->
  <section id="populer_section_wrapper">
    <div class="populer_inner">

      <div class="populer_section_heading">
        <?php if (!empty($title)){ ?>
          <h3><?php echo esc_html($title) ?></h3>
        <?php }?>
        <?php if (!empty($subtitle)){ ?>
          <p><?php echo esc_html($subtitle) ?></p>
        <?php }?>
      </div>

      <div class="popupler_widget_wrapper">
        <div class="populer_widget_inner">

        <?php if ( $hotel_loop->have_posts() ) : ?>
          <?php while ( $hotel_loop->have_posts() ) : $hotel_loop->the_post(); ?>

          <div class="single_populer_item">
            <a href="<?php the_permalink(); ?>">
              <div class="populer_item_img" style="background-image: url(<?php the_post_thumbnail_url(); ?>);">
              </div>
              <div class="tourfic_location_widget_meta">
                  <p class="tourfic_widget_location_title"><?php the_title(); ?></p>
                  <p href="#" class="tourfic_widget_location_subtitle">Dhaka</p>
                  <p class="price"> Price from <span>USD - </span> 350 </p>
                  <div class="tourfic_review_part">
                      <p class="review_number_wrap"><span class="review_num">9.8</span> . <span class="review_label">Good</span> - <span class="review_count">120 reviews.</span></p>
                  </div>
              </div>
            </a>
          </div>

          <?php endwhile; ?>
        <?php endif;  wp_reset_postdata(); ?>

        </div>
      </div>
    </div>
  </section>

  <script>
    jQuery('.populer_widget_inner').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay:true,
    autoplaySpeed:2500,
    arrows:false,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      }
    ]

  });
  </script>

<?php return ob_get_clean(); }

add_shortcode('tours', 'tourfic_tours_shortcode');


/**
 * Shortcode Function
 */
function tourfic_search_shortcode( $atts, $content = null ){
    extract(
      shortcode_atts(
        array(
            'style'  => 'default', //recomended, populer
            'title'  => '',  //title populer section
            'subtitle'  => '',   // Sub title populer section
            'classes'  => '',
          ),
        $atts
      )
    );

    if ( $style == 'default' ) {
        $classes = " default-form ";
    }

  ob_start(); ?>

    <!-- Start Booking widget -->
    <form class="tf_booking-widget <?php esc_attr_e( $classes ); ?>" method="get" autocomplete="off" action="<?php echo tf_booking_search_action(); ?>">

        <?php if( $title ): ?>
            <div class="tf_widget-title"><?php esc_html_e( $title ); ?></div>
        <?php endif; ?>

        <?php if( $subtitle ): ?>
            <div class="tf_widget-subtitle"><?php esc_html_e( $subtitle ); ?></div>
        <?php endif; ?>


        <div class="tf_homepage-booking">

            <div class="tf_destination-wrap">
                <div class="tf_input-inner">
                    <!-- Start form row -->
                    <?php tf_booking_widget_field(
                        array(
                            'type' => 'text',
                            'svg_icon' => 'search',
                            'name' => 'destination',
                            'label' => 'Destination/property name:',
                            'placeholder' => 'Destination',
                            'required' => 'true',
                        )
                    ); ?>
                    <!-- End form row -->
                </div>
            </div>

            <div class="tf_selectdate-wrap">

                <div class="tf_input-inner">
                    <span class="tf_date-icon">
                        <?php echo tf_get_svg('calendar_today'); ?>
                    </span>
                    <div class="checkin-date-text">
                        Check-in
                    </div>
                    <div class="date-sep">
                        --
                    </div>
                    <div class="checkout-date-text">
                        Check-in
                    </div>
                </div>

                <div class="tf_date-wrap-srt screen-reader-text">
                <!-- Start form row -->
                <?php tf_booking_widget_field(
                    array(
                        'type' => 'text',
                        'svg_icon' => '',
                        'name' => 'check-in-date',
                        'placeholder' => 'Check-in date',
                        'label' => 'Check-in date',
                        'required' => 'true',
                        'disabled' => 'true',
                    )
                ); ?>

                <?php tf_booking_widget_field(
                    array(
                        'type' => 'text',
                        'svg_icon' => '',
                        'name' => 'check-out-date',
                        'placeholder' => 'Check-out date',
                        'required' => 'true',
                        'disabled' => 'true',
                        'label' => 'Check-out date',
                    )
                ); ?>
                </div>

            </div>

            <div class="tf_selectperson-wrap">

                <div class="tf_input-inner">
                    <span class="tf_date-icon">
                        <?php echo tf_get_svg('person'); ?>
                    </span>
                    <div class="adults-text">2 Adults</div>
                    <div class="person-sep">.</div>
                    <div class="child-text">0 Childreen</div>
                    <div class="person-sep">.</div>
                    <div class="room-text">1 Room</div>
                </div>

                <div class="tf_acrselection-wrap">
                    <div class="tf_acrselection-inner">

                        <div class="tf_acrselection">
                            <div class="acr-label">Adults</div>
                            <div class="acr-select">
                                <div class="acr-dec">-</div>
                                <input type="number" name="adults" id="adults" min="1" value="2">
                                <div class="acr-inc">+</div>
                            </div>
                        </div>
                        <div class="tf_acrselection">
                            <div class="acr-label">Children</div>
                            <div class="acr-select">
                                <div class="acr-dec">-</div>
                                <input type="number" name="children" id="children" min="0" value="0">
                                <div class="acr-inc">+</div>
                            </div>
                        </div>
                        <div class="tf_acrselection">
                            <div class="acr-label">Rooms</div>
                            <div class="acr-select">
                                <div class="acr-dec">-</div>
                                <input type="number" name="room" id="room" min="1" value="1">
                                <div class="acr-inc">+</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tf_submit-wrap">
                <button class="tf_button tf-submit" type="submit"><?php esc_html_e( 'Search', 'tourfic' ); ?></button>
            </div>

        </div>

    </form>
    <!-- End Booking widget -->

  <?php return ob_get_clean(); }

add_shortcode('tf_search', 'tourfic_search_shortcode');

/**
 * Shortcode Function
 */
function tourfic_search_result_shortcode( $atts, $content = null ){

    // Unwanted Slashes Remove
    if ( isset( $_GET ) ) {
        $_GET = array_map( 'stripslashes_deep', $_GET );
    }

    // Shortcode extract
    extract(
      shortcode_atts(
        array(
            'style'  => 'default',
            'max'  => '50',
            'search' => isset( $_GET['destination'] ) ? $_GET['destination'] : '',
          ),
        $atts
      )
    );

    // Propertise args
    $args = array(
        'post_type' => 'tourfic',
        'post_status' => 'publish',
        'posts_per_page' => $max,
    );

    // 1st search on Destination taxonomy
    $destinations = get_terms( array(
        'taxonomy' => 'destination',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 0, //can be 1, '1' too
        'hierarchical' => 0, //can be 1, '1' too
        'search' => $search,
        //'name__like' => '',
    ) );

    if ( $destinations ) {
        // Define Featured Category IDs first
        $destinations_ids = array();

        // Creating loop to insert IDs to array.
        foreach( $destinations as $cat ) {
            $destinations_ids[] = $cat->term_id;
        }

        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'destination',
                'terms'    => $destinations_ids,
            )
        );
    } else {
        $args['s'] = $search;
    }

    $loop = new WP_Query( $args );

    ob_start(); ?>

    <!-- Start Content -->
    <div class="tf_search_result">

        <div class="archive_ajax_result">
            <?php if ( $loop->have_posts() ) : ?>
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <?php tourfic_archive_single(); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            <?php endif; ?>
        </div>
        <div class="tf_posts_navigation">
            <?php tf_posts_navigation(); ?>
        </div>

    </div>
    <!-- End Content -->

    <?php wp_reset_postdata(); ?>
    <?php return ob_get_clean();
}

add_shortcode('tf_search_result', 'tourfic_search_result_shortcode');




