<?php

function nnk_admin_enqueue() {
	global $typenow;

	if ( $typenow !== 'student' ) {
		return;
	}

	wp_register_style( 'nnk_bootstrap', plugins_url( '/assets/css/bootstrap.min.css', STUDENT_PLUGIN_URL ) );
	wp_enqueue_style( 'nnk_bootstrap' );

	wp_register_script( 'nnk_jquery', 'https://code.jquery.com/jquery-3.1.1.js' );
	wp_register_script( 'nnk_bootstrap', plugins_url( '/assets/js/bootstrap.min.js', STUDENT_PLUGIN_URL ) );
	wp_enqueue_script( 'nnk_jquery' );
	wp_enqueue_script( 'nnk_bootstrap' );
}