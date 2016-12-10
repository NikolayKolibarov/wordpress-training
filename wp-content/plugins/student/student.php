<?php
/*
 * Plugin Name: Student
 * Description: Simple WordPress plugin.
 * Version: 1.0
 * Author: Nikolay
 * Text Domain: student
 */

if ( ! function_exists( 'add_action' ) ) {
	echo 'Not allowed. Do not call me directly.';
	exit();
}

// Setup
define( 'STUDENT_PLUGIN_URL', __FILE__ );

class Student {
	public function __construct() {
		register_activation_hook( STUDENT_PLUGIN_URL, array( $this, 'nnk_activate_plugin' ) );
		add_action( 'init', array( $this, 'student_init' ) );
		add_action( 'admin_init', array( $this, 'student_admin_init' ) );
		add_action( 'save_post_student', array( $this, 'nnk_save_post_admin' ), 10, 3 );
		add_filter( 'template_include', array( $this, 'nnk_include_single_template' ), 1 );
		add_shortcode( 'student_listing', array( $this, 'nnk_student_render' ) );
		add_action( 'widgets_init', array( $this, 'nnk_widgets_init' ) );
	}

	public function nnk_activate_plugin() {
		if ( version_compare( get_bloginfo( 'version' ), '4.2', '<' ) ) {
			wp_die( __( 'You must update WordPress to use this plugin.', 'student' ) );
		}
	}

	function student_init() {
		$labels = array(
			'name'               => _x( 'Students', 'post type general name', 'student' ),
			'singular_name'      => _x( 'Student', 'post type singular name', 'student' ),
			'menu_name'          => _x( 'Students', 'admin menu', 'student' ),
			'name_admin_bar'     => _x( 'Student', 'add new on admin bar', 'student' ),
			'add_new'            => _x( 'Add New', 'student', 'student' ),
			'add_new_item'       => __( 'Add New Student', 'student' ),
			'new_item'           => __( 'New Student', 'student' ),
			'edit_item'          => __( 'Edit Student', 'student' ),
			'view_item'          => __( 'View Student', 'student' ),
			'all_items'          => __( 'All Students', 'student' ),
			'search_items'       => __( 'Search Students', 'student' ),
			'parent_item_colon'  => __( 'Parent Students:', 'student' ),
			'not_found'          => __( 'No students found.', 'student' ),
			'not_found_in_trash' => __( 'No students found in Trash.', 'student' )
		);

		$args = array(
			'labels'                => $labels,
			'description'           => __( 'CPT for students.', 'student' ),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'student' ),
			'capability_type'       => 'post',
			'has_archive'           => true,
			'hierarchical'          => false,
			'menu_position'         => null,
			'show_in_rest'          => true,
			'rest_base'             => 'students',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'taxonomies'            => array( 'category', 'post_tag' )
		);

		register_post_type( 'student', $args );
	}

	function student_admin_init() {
		include( 'includes/admin/create-metaboxes.php' );
		include( 'includes/admin/student-options.php' );
		include( 'includes/admin/enqueue.php' );

		add_action( 'add_meta_boxes_student', 'nnk_create_metaboxes' );
		add_action( 'admin_enqueue_scripts', 'nnk_admin_enqueue' );

	}

	function nnk_save_post_admin( $post_id, $post, $update ) {
		if ( ! $update ) {
			return;
		}

		$student_data                     = array();
		$student_data['name']             = sanitize_text_field( $_POST['nnk_name'] );
		$student_data['age']              = sanitize_text_field( $_POST['nnk_age'] );
		$student_data['class']            = sanitize_text_field( $_POST['nnk_class'] );
		$student_data['favorite_subject'] = sanitize_text_field( $_POST['nnk_favorite_subject'] );

		update_post_meta( $post_id, 'student_data', $student_data );
	}

	function nnk_include_single_template( $template_path ) {
		if ( get_post_type() == 'student' ) {
			if ( is_single() ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				if ( $theme_file = locate_template( array( 'single-student.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( STUDENT_PLUGIN_URL ) . '/templates/single-student.php';
				}
			}
		}

		return $template_path;
	}

	function nnk_student_render( $atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'name'             => 'Default name',
				'age'              => 'Default age',
				'class'            => 'Default class',
				'favorite_subject' => 'Default favorite_subject',
			), $atts
		);

		return
			'<p>Student shortcode:</h1>' .
			'<p>' . 'Name' . ' : ' . $atts['name'] . '</h1>' .
			'<p>' . 'Age' . ' : ' . $atts['age'] . '</h1>' .
			'<p>' . 'Class' . ' : ' . $atts['class'] . '</h1>' .
			'<p>' . 'Favorite Subject' . ' : ' . $atts['favorite_subject'] . '</p>';
	}

	function nnk_widgets_init() {
		include( 'widgets/student-list-widget.php' );

		register_widget( 'Student_List_Widget' );
	}
}

$student = new Student();