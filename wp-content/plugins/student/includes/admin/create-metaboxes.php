<?php

function nnk_create_metaboxes() {
	add_meta_box(
		'nnk_student_options_mb',
		__( 'Student Options', 'student' ),
		'nnk_student_options_mb',
		'student',
		'normal',
		'high'
	);
}