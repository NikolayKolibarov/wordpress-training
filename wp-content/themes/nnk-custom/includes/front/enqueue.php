<?php

function nnk_enqueue() {
	wp_register_style('nnk_bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');

	wp_enqueue_style('nnk_bootstrap');
}