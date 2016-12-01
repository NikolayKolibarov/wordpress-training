<?php
/*
 * Plugin Name: Student
 * Description: Simple WordPress plugin.
 * Version: 1.0
 * Author: Nikolay
 * Text Domain: student
 */

if (!function_exists('add_action')) {
    echo 'Not allowed. Do not call me directly.';
    exit();
}

// Setup

// Includes
include('includes/activate.php');

// Hooks
register_activation_hook(__FILE__, 'nnk_activate_plugin');

// Shortcodes