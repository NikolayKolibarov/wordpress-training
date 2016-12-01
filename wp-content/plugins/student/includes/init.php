<?php

function student_init() {
    $labels = array(
        'name'               => _x( 'Students', 'post type general name', 'student' ),
        'singular_name'      => _x( 'Student', 'post type singular name', 'student' ),
        'menu_name'          => _x( 'Students', 'admin menu', 'student' ),
        'name_admin_bar'     => _x( 'Student', 'add new on admin bar', 'student' ),
        'add_new'            => _x( 'Add New', 'student', 'student' ),
        'add_new_item'       => __( 'Add New Student', 'student' ),
        'new_item'           => __( 'New Student', 'student' ),
        'edit_item'          => __( 'Edit Student', 'student' ),
        'view_item'          => __( 'View Student', 'student' ),
        'all_items'          => __( 'All Students', 'student' ),
        'search_items'       => __( 'Search Students', 'student' ),
        'parent_item_colon'  => __( 'Parent Students:', 'student' ),
        'not_found'          => __( 'No students found.', 'student' ),
        'not_found_in_trash' => __( 'No students found in Trash.', 'student' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'CPT for students.', 'student' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'student' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'         => array('category', 'post_tag')
    );

    register_post_type( 'student', $args );

}