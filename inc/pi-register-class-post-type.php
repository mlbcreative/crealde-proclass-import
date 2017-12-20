<?php
	function proclass_post_type() {

	$labels = array(
		'name'                  => _x( 'Classes', 'Post Type General Name', 'proclass-class-import' ),
		'singular_name'         => _x( 'Class', 'Post Type Singular Name', 'proclass-class-import' ),
		'menu_name'             => __( 'Classes', 'proclass-class-import' ),
		'name_admin_bar'        => __( 'Classes', 'proclass-class-import' ),
		'archives'              => __( 'Class Archives', 'proclass-class-import' ),
		'attributes'            => __( 'Class Attributes', 'proclass-class-import' ),
		'parent_item_colon'     => __( 'Parent Class:', 'proclass-class-import' ),
		'all_items'             => __( 'All Classes', 'proclass-class-import' ),
		'add_new_item'          => __( 'Add New Class', 'proclass-class-import' ),
		'add_new'               => __( 'Add New', 'proclass-class-import' ),
		'new_item'              => __( 'New Class', 'proclass-class-import' ),
		'edit_item'             => __( 'Edit Class', 'proclass-class-import' ),
		'update_item'           => __( 'Update Class', 'proclass-class-import' ),
		'view_item'             => __( 'View Class', 'proclass-class-import' ),
		'view_items'            => __( 'View Classes', 'proclass-class-import' ),
		'search_items'          => __( 'Search Class', 'proclass-class-import' ),
		'not_found'             => __( 'Not found', 'proclass-class-import' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'proclass-class-import' ),
		'featured_image'        => __( 'Featured Image', 'proclass-class-import' ),
		'set_featured_image'    => __( 'Set featured image', 'proclass-class-import' ),
		'remove_featured_image' => __( 'Remove featured image', 'proclass-class-import' ),
		'use_featured_image'    => __( 'Use as featured image', 'proclass-class-import' ),
		'insert_into_item'      => __( 'Insert into Class', 'proclass-class-import' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Class', 'proclass-class-import' ),
		'items_list'            => __( 'Classes list', 'proclass-class-import' ),
		'items_list_navigation' => __( 'Classes list navigation', 'proclass-class-import' ),
		'filter_items_list'     => __( 'Filter Classes list', 'proclass-class-import' ),
	);
	$args = array(
		'label'                 => __( 'Class', 'proclass-class-import' ),
		'description'           => __( 'The Custom Post Type for Classes', 'proclass-class-import' ),
		'labels'                => $labels,
		'supports'              => array( 'thumbnail', 'title', 'editor' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite' => array(
                'slug' => 'classes'
            )
	);
	register_post_type( 'proclass', $args );

}
add_action( 'init', 'proclass_post_type', 0 );