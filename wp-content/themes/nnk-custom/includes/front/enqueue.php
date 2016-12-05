<?php

function nnk_enqueue() {
	wp_register_style( 'nnk_bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'nnk_bootstrap' );

	wp_register_script( 'nnk_jquery', get_template_directory_uri() . '/assets/js/jquery-3.1.1.js' );
    wp_enqueue_script( 'nnk_jquery' );

    wp_register_script( 'nnk_bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js' );
	wp_enqueue_script( 'nnk_bootstrap' );
}