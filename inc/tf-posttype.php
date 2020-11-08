<?php
function cptui_register_my_cpts_tourfic() {

	/**
	 * Post Type: Tour.
	 */

	$labels = [
		"name" => __( "Tour", "storefront" ),
		"singular_name" => __( "Tours", "storefront" ),
		"menu_name" => __( "Tourfic", "storefront" ),
		"all_items" => __( "All Tour", "storefront" ),
		"add_new" => __( "Add new", "storefront" ),
		"add_new_item" => __( "Add new Tours", "storefront" ),
		"edit_item" => __( "Edit Tours", "storefront" ),
		"new_item" => __( "New Tours", "storefront" ),
		"view_item" => __( "View Tours", "storefront" ),
		"view_items" => __( "View Tour", "storefront" ),
		"search_items" => __( "Search Tour", "storefront" ),
		"not_found" => __( "No Tour found", "storefront" ),
		"not_found_in_trash" => __( "No Tour found in trash", "storefront" ),
		"parent" => __( "Parent Tours:", "storefront" ),
		"featured_image" => __( "Featured image for this Tours", "storefront" ),
		"set_featured_image" => __( "Set featured image for this Tours", "storefront" ),
		"remove_featured_image" => __( "Remove featured image for this Tours", "storefront" ),
		"use_featured_image" => __( "Use as featured image for this Tours", "storefront" ),
		"archives" => __( "Tours archives", "storefront" ),
		"insert_into_item" => __( "Insert into Tours", "storefront" ),
		"uploaded_to_this_item" => __( "Upload to this Tours", "storefront" ),
		"filter_items_list" => __( "Filter Tour list", "storefront" ),
		"items_list_navigation" => __( "Tour list navigation", "storefront" ),
		"items_list" => __( "Tour list", "storefront" ),
		"attributes" => __( "Tour attributes", "storefront" ),
		"name_admin_bar" => __( "Tours", "storefront" ),
		"item_published" => __( "Tours published", "storefront" ),
		"item_published_privately" => __( "Tours published privately.", "storefront" ),
		"item_reverted_to_draft" => __( "Tours reverted to draft.", "storefront" ),
		"item_scheduled" => __( "Tours scheduled", "storefront" ),
		"item_updated" => __( "Tours updated.", "storefront" ),
		"parent_item_colon" => __( "Parent Tours:", "storefront" ),
	];

	$args = [
		"label" => __( "Tour", "storefront" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "tourfic", "with_front" => false ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments" ],
	];

	register_post_type( "tourfic", $args );
}

add_action( 'init', 'cptui_register_my_cpts_tourfic' );
