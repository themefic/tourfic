<?php
/**
 * Plugin Name: Tourfic - Tour / Travel / Trip Booking for WooCommerce
 * Plugin URI: https://psdtowpservice.com/tourfic
 * Github Plugin URI: http://github.com/themefic/tourfic
 * Description:
 * Author: BootPeople
 * Text Domain: tourfic
 * Domain Path: /lang/
 * Author URI: https://psdtowpservice.com
 * Tags:
 * Version: 1.0.24
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Define WI_VERSION.
if ( ! defined( 'TOURFIC_VERSION' ) ) {
	define( 'TOURFIC_VERSION', '1.0.1' );
}

define( 'TF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TF_TEMPLATES_URL', TF_PLUGIN_URL.'templates/' );
define( 'TF_ADMIN_URL', TF_PLUGIN_URL.'admin/' );

/**
* Including Plugin file for security
* Include_once
*
* @since 1.0.0
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function ppr( $ppr ){
	echo "<pre>";
	print_r( $ppr  );
	echo "</pre>";
}


/**
 *	Main Class
 *
 */
if( !class_exists('Tourfic_WordPress_Plugin') ) :
class Tourfic_WordPress_Plugin{

	public function __construct() {
		add_action('plugins_loaded', [ $this, 'load_text_domain' ], 10, 2);

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 100 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_datepicker' ] );

		add_filter( 'single_template', [ $this, 'tourfic_single_page_template' ] );
		add_filter('template_include', [ $this, 'tourfic_archive_page_template' ]);
		add_filter ('theme_page_templates', [ $this, 'page_templates' ], 10, 4 );
		add_filter ('page_template', [ $this, 'load_page_templates' ]);

		add_filter('comments_template', [ $this, 'load_comment_template' ]);

		// Admin Notice
		add_filter('admin_notices', [ $this, 'admin_notices' ]);



	}

	public function includes(){

		/**
		 *	Custom Meta Fields
		 */
		require_once( dirname( __FILE__ ) . '/admin/tf-admin.php' );

		/**
		 *	Layouts Function
		 */
		require_once( dirname( __FILE__ ) . '/inc/tf-layouts.php' );

		/**
		 *	Post type
		 */
		require_once( dirname( __FILE__ ) . '/inc/tf-posttype.php' );

		/**
		 *	Post type
		 */
		require_once( dirname( __FILE__ ) . '/inc/tourfic-functions.php' );

		/**
		 *	SVG Icons
		 */
		require_once( dirname( __FILE__ ) . '/inc/svg-icons.php' );

		/**
		 *	Shortcodes
		 */
		require_once( dirname( __FILE__ ) . '/inc/shortcodes.php' );

		/**
		 *	WooCommerce booking
		 */
		require_once( dirname( __FILE__ ) . '/inc/tf-woocommerce-class.php' );
	}

	/**
	* Loading Text Domain
	*
	*/
	public function load_text_domain() {
		$this->includes();
		//Internationalization
		load_plugin_textdomain( 'tourfic', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );


		//Redux Framework calling
		if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/inc/redux-framework/ReduxCore/framework.php' ) ) {
		    require_once( dirname( __FILE__ ) . '/inc/redux-framework/ReduxCore/framework.php' );
		}

	    // Load the plugin options
	    if ( class_exists( 'ReduxFramework' ) ) {
	        require_once dirname( __FILE__ ) . '/inc/options.php';
	    }
	}

	/**
	 *	Enqueue  scripts
	 *
	 */
	public function enqueue_scripts(){

		$TOURFIC_VERSION = current_time('timestamp');

		wp_enqueue_style('tourfic-styles', plugin_dir_url( __FILE__ ) . 'assets/css/tourfic-styles.min.css', null, $TOURFIC_VERSION );

	    wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . 'assets/slick/slick.min.js', array('jquery'), $TOURFIC_VERSION );

	    wp_enqueue_script( 'tourfic-script', plugin_dir_url( __FILE__ ) . 'assets/js/tourfic-script.js', array('jquery'), $TOURFIC_VERSION, true );

		wp_localize_script( 'tourfic-script', 'tf_params',
			array(
		        'nonce' => wp_create_nonce( 'tf_ajax_nonce' ),
		        'ajax_url' => admin_url( 'admin-ajax.php' )
		    )
	    );
	}

	/**
	 * Load jQuery datepicker.
	 *
	 */
	public function enqueue_datepicker() {

	    wp_enqueue_style('daterangepicker', plugin_dir_url( __FILE__ ) . 'assets/daterangepicker/daterangepicker.css', null, TOURFIC_VERSION );

	    wp_enqueue_script( 'moment', plugin_dir_url( __FILE__ ) . 'assets/daterangepicker/moment.min.js', array('jquery'), TOURFIC_VERSION, true );
	    wp_enqueue_script( 'daterangepicker', plugin_dir_url( __FILE__ ) . 'assets/daterangepicker/daterangepicker.js', array('jquery'), TOURFIC_VERSION, true );


	}

	// Show Page Template
	public function page_templates ($templates, $wp_theme, $post, $post_type) {
	    $templates['tf_search-result'] = 'Torufic - Search Result';
	    return $templates;
	}

	// Load Page Template
	public function load_page_templates ($page_template) {

		if ( get_page_template_slug() == 'tf_search-result' ) {
		    $theme_files = array('search-tourfic.php', 'templates/search-tourfic.php');
		    $exists_in_theme = locate_template($theme_files, false);
		    if ( $exists_in_theme != '' ) {
		      	return $exists_in_theme;
		    } else {
		      	return dirname( __FILE__ ) . '/templates/search-tourfic.php';
		    }
		}
		return $page_template;
	}

	// Single Template
	public function tourfic_single_page_template( $single_template ) {
		global $post;
		if ( 'tourfic' === $post->post_type ) {
		    $theme_files = array('single-tourfic.php', 'templates/single-tourfic.php');
		    $exists_in_theme = locate_template($theme_files, false);
		    if ( $exists_in_theme != '' ) {
		      	return $exists_in_theme;
		    } else {
		      	return dirname( __FILE__ ) . '/templates/single-tourfic.php';
		    }
		}
		return $single_template;
	}

	// Archive Template
	public function tourfic_archive_page_template( $template ) {
	  if ( is_post_type_archive('tourfic') ) {

	    $theme_files = array('archive-tourfic.php', 'templates/archive-tourfic.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if ( $exists_in_theme != '' ) {
	      	return $exists_in_theme;
	    } else {
	      	return dirname( __FILE__ ) . '/templates/archive-tourfic.php';
	    }

	  }
	  return $template;
	}

	// Review form load
	public function load_comment_template( $comment_template ) {
	    global $post;

	    if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
	       // leave the standard comments template for standard post types
	       return;
	    }

		if ( 'tourfic' === $post->post_type ) {
		    $theme_files = array('review.php', 'templates/review.php');
		    $exists_in_theme = locate_template($theme_files, false);
		    if ( $exists_in_theme != '' ) {
		      	return $exists_in_theme;
		    } else {
		      	return dirname( __FILE__ ) . '/templates/review.php';
		    }
		}

		return $comment_template;

	}

	/**
	 * Notice if WooCommerce is inactive
	 */
	public function admin_notices() {
		if ( !class_exists( 'WooCommerce' ) ) { ?>
		    <div class="notice notice-warning is-dismissible">
		        <p>
		        	<strong><?php esc_html_e( 'Tourfic requires WooCommerce to be activated ', 'tourfic' ); ?> <a href="<?php echo esc_url( admin_url('/plugin-install.php?s=slug:woocommerce&tab=search&type=term') ); ?>">Install Now</a></strong>
		        </p>
		    </div> <?php
	    }
	}


}
new Tourfic_WordPress_Plugin;
endif;