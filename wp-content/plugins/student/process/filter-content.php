<?php

function nnk_filter_student_content( $content ) {
	if ( is_singular( 'student' ) ) {
		return $content;
	}

	global $post;

	$student_data = get_post_meta( $post->ID, 'student_data', true );

	$student_html = file_get_contents( 'student-template.php', true );
	$student_html = str_replace('NAME_PH', $student_data['name'], $student_html);
	$student_html = str_replace('AGE_PH', $student_data['age'], $student_html);
	$student_html = str_replace('CLASS_PH', $student_data['class'], $student_html);
	$student_html = str_replace('FAVORITE_SUBJECT_PH', $student_data['favorite_subject'], $student_html);
	$student_html = str_replace('ID_PH', $student_data['id'], $student_html);

	return $student_html . $content;
}