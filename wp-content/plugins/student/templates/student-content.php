<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
		<?php
		echo ! empty( $student_data['name'] ) ? '<strong>Student name:' . esc_html( $student_data['name'] ) . '</strong>' . '<br>' : '';

		echo ! empty( $student_data['age'] ) ? '<strong>Student age:' . esc_html( $student_data['age'] ) . '</strong>' . '<br>' : '';

		echo ! empty( $student_data['class'] ) ? '<strong>Student class:' . esc_html( $student_data['class'] ) . '</strong>' . '<br>' : '';

		echo ! empty( $student_data['favorite_subject'] ) ? '<strong>Student favorite subject:' . esc_html( $student_data['favorite_subject'] ) . '</strong>' . '<br>' : '';
		?>
    </header>

</article>