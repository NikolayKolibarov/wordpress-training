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

		$sql = "SELECT * FROM {$wpdb->prefix}posts WHERE post_type='student'";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}

	public static function delete_student( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}students",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}

	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}students";

		return $wpdb->get_var( $sql );
	}

	public function no_items() {
		_e( 'No students available.', 'sp' );
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
//            case 'title':
//                return print_r($item['title'], true);
//			case 'name':
//				return print_r($item['name'], true);
//			case 'age':
//				return print_r($item['age'], true);
//			case 'class':
//				return print_r($item['class'], true);
//			case'favorite_subject':
//				return print_r($item['favorite_subject'], true);
			default:

				return print_r( $column_name, true ); //Show the whole array for troubleshooting purposes
		}
	}

	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		);
	}

	function get_columns() {
		$columns = [
			'cb'               => '<input type="checkbox" />',
			'post_title'       => __( 'Title', 'sp' ),
			'name'             => __( 'Name', 'sp' ),
			'age'              => __( 'Age', 'sp' ),
			'class'            => __( 'Class', 'sp' ),
			'favorite_subject' => __( 'Favorite Subject', 'sp' )
		];

		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array();

		return $sortable_columns;
	}

	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];

		return $actions;
	}

	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'students_per_page', 5 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_students( $per_page, $current_page );
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_student' ) ) {
				die( 'Go get a life script kiddies' );
			} else {
				self::delete_student( absint( $_GET['student'] ) );

				// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
				// add_query_arg() return the current url
				wp_redirect( esc_url_raw( add_query_arg() ) );
				exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_student( $id );

			}

			// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
			// add_query_arg() return the current url
			wp_redirect( esc_url_raw( add_query_arg() ) );
			exit;
		}
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
