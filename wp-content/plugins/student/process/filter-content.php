<?php

function nnk_render_single_template($single)
{

    global $wp_query, $post;

    /* Checks for single template by post type */
    if ($post->post_type == "student") {
        if (file_exists(STUDENT_PLUGIN_URL . '/process/single-student.php'))
            return STUDENT_PLUGIN_URL . '/process/single-student.php';
    }
    return $single;
}

function nnk_include_template($template_path)
{
    if (get_post_type() == 'student') {
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array('single-student.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(STUDENT_PLUGIN_URL) . '/process/single-student.php';
            }
        }
    }

    return $template_path;
}