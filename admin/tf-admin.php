<?php

/**
 *  Plugin Main Class
 */
if ( ! class_exists( 'Tourfic_Admin_Init' ) ) :
    class Tourfic_Admin_Init{

        /**
         * Constructor
         */
        public function __construct() {

            // Admin action
            add_action('admin_init', array( $this, 'admin_action' ) );

            // Admin script
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts'], 15 );

        }

        /**
         * Admin Action
         */
        function admin_action() {
            require_once( dirname( __FILE__ ) . '/inc/tf-custom-fields.php' );
        }

        /**
         * Admin scripts
         */
        function admin_scripts(){
            $ver = current_time( 'timestamp' );

            wp_enqueue_style( 'tf-admin', TF_ADMIN_URL . 'assets/css/tf-admin.css', null, $ver );
            wp_enqueue_script( 'tf-admin', TF_ADMIN_URL . 'assets/js/tf-admin.js', array('jquery'), $ver );
        }

    }

endif;


/**
* Plugin Initialize
*/
new Tourfic_Admin_Init();