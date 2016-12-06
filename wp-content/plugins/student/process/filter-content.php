<?php

function nnk_include_single_template($template_path)
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

function nnk_include_archive_template($template_path)
{
    if (get_post_type() == 'student') {
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array('archive-student.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(STUDENT_PLUGIN_URL) . '/process/archive-student.php';
            }
        }
    }

    return $template_path;
}