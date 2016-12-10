<?php

class Student_List_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'student_list_widget',
			'description' => 'Widget that displays students',
		);
		parent::__construct( 'student_list_widget', 'Student List Widget', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo $this->getStudentListings( $instance['numberOfListings'] );
		echo $args['after_widget'];

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		if ( $instance ) {
			$title            = esc_attr( $instance['title'] );
			$numberOfListings = esc_attr( $instance['numberOfListings'] );
		} else {
			$title            = '';
			$numberOfListings = '';
		}
		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'student_list_widget' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'numberOfListings' ); ?>"><?php _e( 'Number of Listings:', 'student_list_widget' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'numberOfListings' ); ?>"
			        name="<?php echo $this->get_field_name( 'numberOfListings' ); ?>">
				<?php for ( $x = 1; $x <= 10; $x ++ ): ?>
					<option <?php echo $x == $numberOfListings ? 'selected="selected"' : ''; ?>
						value="<?php echo $x; ?>"><?php echo $x; ?></option>
				<?php endfor; ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['numberOfListings'] = ( ! empty( $new_instance['numberOfListings'] ) ) ? strip_tags( $new_instance['numberOfListings'] ) : '';

		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberOfListings'] = strip_tags($new_instance['numberOfListings']);
		return $instance;

	}

	public function getStudentListings( $numberOfListings ) { //html
		$listings = new WP_Query();
		$listings->query( 'post_type=student&posts_per_page=' . $numberOfListings );
		if ( $listings->found_posts > 0 ) {
			echo '<ul class="realty_widget">';
			while ( $listings->have_posts() ) {
				$listings->the_post();
				$listItem = '<h2>';
				$listItem .= '<a href="' . get_permalink() . '">';
				$listItem .= get_the_title() . '</a>';
				$listItem .= '</h2>';
				echo $listItem;
			}
			echo '</ul>';
			wp_reset_postdata();
		} else {
			echo '<p style="padding:25px;">No listing found</p>';
		}
	}
}