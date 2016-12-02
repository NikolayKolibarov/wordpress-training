<?php

function nnk_save_post_admin( $post_id, $post, $update ) {
	if ( ! $update ) {
		return;
	}

	$student_data                     = array();
	$student_data['name']             = sanitize_text_field( $_POST['nnk_name'] );
	$student_data['age']              = sanitize_text_field( $_POST['nnk_age'] );
	$student_data['class']            = sanitize_text_field( $_POST['nnk_class'] );
	$student_data['favorite_subject'] = sanitize_text_field( $_POST['nnk_favorite_subject'] );
	$student_data['id']               = generateRandomString();

	update_post_meta( $post_id, 'student_data', $student_data );
}

function generateRandomString( $length = 10 ) {
	$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString     = '';
	for ( $i = 0; $i < $length; $i ++ ) {
		$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
	}

	return $randomString;
}