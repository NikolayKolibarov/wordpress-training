<?php
get_header(); ?>
<div id="primary">
    <main id="main" class="site-main" role="main">
        <?php
        $student = array('post_type' => 'student');
        $loop = new WP_Query($student);
        $student_data = get_post_meta($post->ID, 'student_data', true);
        ?>
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>

            <?php
            include('student-content.php');

            if (comments_open() || get_comments_number()) {
                comments_template();
            }

            if (is_singular('attachment')) {
                // Parent post navigation.
                the_post_navigation(array(
                    'prev_text' => _x('<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen'),
                ));
            } elseif (is_singular('post')) {
                // Previous/next post navigation.
                the_post_navigation(array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next', 'twentysixteen') . '</span> ' .
                        '<span class="screen-reader-text">' . __('Next post:', 'twentysixteen') . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous', 'twentysixteen') . '</span> ' .
                        '<span class="screen-reader-text">' . __('Previous post:', 'twentysixteen') . '</span> ' .
                        '<span class="post-title">%title</span>',
                ));
            }
            ?>


        <?php endwhile; ?>
</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
