<?php

/*
* Plugin Name: Student_List_Table
* Description: Demo on how WP_List_Table Class works
* Version: 1.0
* Author: Nikolay
* Text Domain: student_list
*/

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Students_List_Table extends WP_List_Table {

	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Student', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Students', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}

	public static function get_students( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM wp_posts, wp_postmeta WHERE id=post_id AND meta_key='student_data'";

		$results = $wpdb->get_results( $sql, 'ARRAY_A' );


		return $results;
	}

	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM wp_posts, wp_postmeta WHERE id=post_id AND meta_key='student_data'";

		return $wpdb->get_var( $sql );
	}

	public function no_items() {
		_e( 'No students available.', 'sp' );
	}

	public function column_default( $item, $column_name ) {

		$student = get_post_meta( $item['ID'], 'student_data', true );

		return ( $student[$column_name] );

	}


	function get_columns() {
		$columns = [
			'name'             => __( 'Name', 'sp' ),
			'age'              => __( 'Age', 'sp' ),
			'class'            => __( 'Class', 'sp' ),
			'favorite_subject' => __( 'Favorite Subject', 'sp' )
		];

		return $columns;
	}



	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		$per_page     = $this->get_items_per_page( 'students_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_students( $per_page, $current_page );
	}


}


class Students_List_Table_Settings {

	// class instance
	static $instance;

	// student WP_List_Table object
	public $students_obj;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {

		$hook = add_menu_page(
			'Students_List_Table',
			'Students Table',
			'manage_options',
			'wp_list_table_class',
			[ $this, 'plugin_settings_page' ]
		);

		add_action( "load-$hook", [ $this, 'screen_option' ] );

	}

	public function plugin_settings_page() {
		?>
        <div class="wrap">
            <h2>Student List Table</h2>

            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
								<?php
								$this->students_obj->prepare_items();
								$this->students_obj->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
		<?php
	}

	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Students',
			'default' => 5,
			'option'  => 'students_per_page'
		];

		add_screen_option( $option, $args );

		$this->students_obj = new Students_List_Table();
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

add_action( 'plugins_loaded', function () {
	Students_List_Table_Settings::get_instance();
} );
