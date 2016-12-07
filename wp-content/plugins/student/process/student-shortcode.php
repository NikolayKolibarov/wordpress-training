<?php

function nnk_student_render($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'name' => 'Default name',
            'age' => 'Default age',
            'class' => 'Default class',
            'favorite_subject' => 'Default favorite_subject',
        ), $atts
    );

    return
        '<p>Student shortcode:</h1>' .
        '<p>' . 'Name' . ' : ' . $atts['name'] . '</h1>' .
        '<p>' . 'Age' . ' : ' . $atts['age'] . '</h1>' .
        '<p>' . 'Class' . ' : ' . $atts['class'] . '</h1>' .
        '<p>' . 'Favorite Subject' . ' : ' . $atts['favorite_subject'] . '</p>' ;
}