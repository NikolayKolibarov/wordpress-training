<?php

function nnk_admin_enqueue() {
	global $typenow;

	if ( $typenow !== 'student') {
		return;
	}

	wp_register_style('nnk_bootstrap', plugins_url('/assets/css/bootstrap.css', STUDENT_PLUGIN_URL));
	wp_enqueue_style('nnk_bootstrap');

	wp_register_script('nnk_bootstrap', plugins_url('/assets/js/bootstrap.js', STUDENT_PLUGIN_URL));
	wp_enqueue_script('nnk_bootstrap');
}