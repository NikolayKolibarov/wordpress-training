<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">

        <strong>Student name: </strong>
        <?php echo esc_html($student_data['name']); ?>
        <br>
        <strong>Student age: </strong>
        <?php echo esc_html($student_data['age']) ?>
        <br>
        <strong>Student class: </strong>
        <?php echo esc_html($student_data['class']) ?>
        <br>
        <strong>Student favorite subject: </strong>
        <?php echo esc_html($student_data['favorite_subject']) ?>

    </header>

</article>