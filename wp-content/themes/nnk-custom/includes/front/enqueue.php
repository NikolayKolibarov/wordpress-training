<?php

function nnk_enqueue() {
	wp_register_style( 'nnk_bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'nnk_bootstrap' );

	wp_register_script( 'nnk_jquery', 'https://code.jquery.com/jquery-3.1.1.js' );
	wp_register_script( 'nnk_bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js' );
	wp_enqueue_script( 'nnk_jquery' );
	wp_enqueue_script( 'nnk_bootstrap' );
}