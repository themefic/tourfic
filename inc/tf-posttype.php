<?php
/**
 * Post Type: Tour.
 */
function cptui_register_my_cpts_tourfic() {

	$labels = [
		"name" => __( "Tour", "tourfic" ),
		"singular_name" => __( "Tours", "tourfic" ),
		"menu_name" => __( "Tourfic", "tourfic" ),
		"all_items" => __( "All Tour", "tourfic" ),
		"add_new" => __( "Add new", "tourfic" ),
		"add_new_item" => __( "Add new Tours", "tourfic" ),
		"edit_item" => __( "Edit Tours", "tourfic" ),
		"new_item" => __( "New Tours", "tourfic" ),
		"view_item" => __( "View Tours", "tourfic" ),
		"view_items" => __( "View Tour", "tourfic" ),
		"search_items" => __( "Search Tour", "tourfic" ),
		"not_found" => __( "No Tour found", "tourfic" ),
		"not_found_in_trash" => __( "No Tour found in trash", "tourfic" ),
		"parent" => __( "Parent Tours:", "tourfic" ),
		"featured_image" => __( "Featured image for this Tours", "tourfic" ),
		"set_featured_image" => __( "Set featured image for this Tours", "tourfic" ),
		"remove_featured_image" => __( "Remove featured image for this Tours", "tourfic" ),
		"use_featured_image" => __( "Use as featured image for this Tours", "tourfic" ),
		"archives" => __( "Tours archives", "tourfic" ),
		"insert_into_item" => __( "Insert into Tours", "tourfic" ),
		"uploaded_to_this_item" => __( "Upload to this Tours", "tourfic" ),
		"filter_items_list" => __( "Filter Tour list", "tourfic" ),
		"items_list_navigation" => __( "Tour list navigation", "tourfic" ),
		"items_list" => __( "Tour list", "tourfic" ),
		"attributes" => __( "Tour attributes", "tourfic" ),
		"name_admin_bar" => __( "Tours", "tourfic" ),
		"item_published" => __( "Tours published", "tourfic" ),
		"item_published_privately" => __( "Tours published privately.", "tourfic" ),
		"item_reverted_to_draft" => __( "Tours reverted to draft.", "tourfic" ),
		"item_scheduled" => __( "Tours scheduled", "tourfic" ),
		"item_updated" => __( "Tours updated.", "tourfic" ),
		"parent_item_colon" => __( "Parent Tours:", "tourfic" ),
	];

	$args = [
		"label" => __( "Tour", "tourfic" ),
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

/**
 * Taxonomy: Destination.
 */
function cptui_register_my_taxes_destination() {

    $labels = [
        "name" => __( "Destination", "tourfic" ),
        "singular_name" => __( "Destinations", "tourfic" ),
        "menu_name" => __( "Destination", "tourfic" ),
        "all_items" => __( "All Destination", "tourfic" ),
        "edit_item" => __( "Edit Destinations", "tourfic" ),
        "view_item" => __( "View Destinations", "tourfic" ),
        "update_item" => __( "Update Destinations name", "tourfic" ),
        "add_new_item" => __( "Add new Destinations", "tourfic" ),
        "new_item_name" => __( "New Destinations name", "tourfic" ),
        "parent_item" => __( "Parent Destinations", "tourfic" ),
        "parent_item_colon" => __( "Parent Destinations:", "tourfic" ),
        "search_items" => __( "Search Destination", "tourfic" ),
        "popular_items" => __( "Popular Destination", "tourfic" ),
        "separate_items_with_commas" => __( "Separate Destination with commas", "tourfic" ),
        "add_or_remove_items" => __( "Add or remove Destination", "tourfic" ),
        "choose_from_most_used" => __( "Choose from the most used Destination", "tourfic" ),
        "not_found" => __( "No Destination found", "tourfic" ),
        "no_terms" => __( "No Destination", "tourfic" ),
        "items_list_navigation" => __( "Destination list navigation", "tourfic" ),
        "items_list" => __( "Destination list", "tourfic" ),
        "back_to_items" => __( "Back to Destination", "tourfic" ),
    ];
    $args = [
        "label" => __( "Destination", "tourfic" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'destination', 'with_front' => true, ],
        "show_admin_column" => true,
        "show_in_rest" => true,
        "rest_base" => "destination",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => true,
            ];
    register_taxonomy( "destination", [ "tourfic" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_destination' );
