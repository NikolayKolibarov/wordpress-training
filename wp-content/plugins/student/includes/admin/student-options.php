<?php

function nnk_student_options_mb( $post ) {
	$student_data = get_post_meta( $post->ID, 'student_data', true );

	if ( ! $student_data ) {
		$student_data = array(
			'name'             => '',
			'age'              => '',
			'class'            => '',
			'favorite_subject' => ''
		);
	}

	?>
	<div class="form-group">
		<label for="">Name</label>
		<input type="text" class="form-control" name="nnk_name" value="<?php echo $student_data['name']; ?>">
	</div>
	<div class="form-group">
		<label for="">Age</label>
		<input type="text" class="form-control" name="nnk_age" value="<?php echo $student_data['age']; ?>">
	</div>
	<div class="form-group">
		<label for="">Class</label>
		<input type="text" class="form-control" name="nnk_class" value="<?php echo $student_data['class']; ?>">
	</div>
	<div class="form-group">
		<label for="">Favorite Subject</label>
		<input type="text" class="form-control" name="nnk_favorite_subject"
		       value="<?php echo $student_data['favorite_subject']; ?>">
	</div>
	<?php
}