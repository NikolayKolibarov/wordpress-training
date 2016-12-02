<?php

function student_admin_init() {
	include( 'create-metaboxes.php' );
	include( 'student-options.php' );
	include( 'enqueue.php' );

	add_action( 'add_meta_boxes_student', 'nnk_create_metaboxes' );
	add_action( 'admin_enqueue_scripts', 'nnk_admin_enqueue' );
}