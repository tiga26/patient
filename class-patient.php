<?php
require_once ABSPATH.'wp-admin/includes/upgrade.php';

class Patient_Plugin {

	private static $db_structure;
	
	public function setDbStructure($db_structure) {

		self::$db_structure = $db_structure;
		return $this;
	}

	public static function init($filename) {
		/*Runs on plugin activation*/		
		register_activation_hook( $filename, array( 'Patient_Plugin', 'onPluginActivation'));

		/*Runs on plugin deactivation*/
		register_deactivation_hook( $filename, array( 'Patient_Plugin', 'onPluginDeactivation'));

		/*Redirection hook for page Ppatient created by this plugin*/
		add_action('template_redirect', array( 'Patient_Plugin', 'pageRedirect'));
	}

	public function onPluginActivation() {

		self::createPluginPage();
		self::createPluginTables();

	}

	public function onPluginDeactivation() {

		global $wpdb;

		$page_title = get_option('my_plugin_page_title');
		$page_name = get_option('my_plugin_page_name');

		$page_id = get_option('my_plugin_page_id');
		if( $page_id ) {
			wp_delete_post( $page_id );
		}

		delete_option('my_plugin_page_title');
		delete_option('my_plugin_page_name');
		delete_option('my_plugin_page_id');

		self::dropPluginTables();

	}

	public static function pageRedirect() {

		global $wp;

		$plugin_dir = dirname(__FILE__);
		$page_name = get_option('my_plugin_page_name');

		$page_slug = get_page_template_slug(get_queried_object_id());
	    $templatefilename = 'single-patient.php';

	    if (!file_exists(dirname(__FILE__). '/templates/' . $templatefilename)) {
	        $return_template = $templatefilename;
	    } else {
	        $return_template = $plugin_dir . '/templates/' . $templatefilename;
	    }
	    // var_dump($return_template);exit;
	    if($page_slug == $templatefilename) {
	    	add_action( 'wp_enqueue_scripts', array( 'Patient_Plugin', 'addStylesAndScripts'));
	    	self::doRedirect($return_template);	
	    }

	}

	public function addStylesAndScripts() {
		$css_url = plugins_url().'/patient/css';
		$js_url = plugins_url().'/patient/js';

		wp_enqueue_style( 'custom-style', $css_url.'/style.css' );
		wp_enqueue_style( 'jquery-ui-custom', $css_url.'/jquery-ui-1.10.4.custom.css' );
		wp_enqueue_style( 'jquery-jscrollpane', $css_url.'/jquery.jscrollpane.css' );
		wp_enqueue_style( 'jquery-selectBox', $css_url.'/jquery.selectBox.css' );
		wp_enqueue_style( 'bootstrat', $css_url.'/bootstrap.min.css' );

		wp_enqueue_script( 'jquery-ui-custom-min', $js_url.'/jquery-ui-1.10.4.custom.min.js', array('jquery'));
		wp_enqueue_script( 'jquery-jscrollpane-min', $js_url.'/jquery.jscrollpane.min.js', array('jquery'));
		wp_enqueue_script( 'jquery-mousewheel', $js_url.'/jquery.mousewheel.js', array('jquery'));		
		wp_enqueue_script( 'jquery-select', $js_url.'/jquery.selectBox-0.2.js', array('jquery'));
		wp_enqueue_script( 'jquery-bootstrap', $js_url.'/bootstrap.min.js', array('jquery'));

		// wp_localize_script( 'ajax-test', 'the_ajax_script', array( 'ajaxurl' => plugin_dir_url( __FILE__ ).'class-ajax-handler.php' ) );	

		add_action('wp_print_scripts', array('Patient_Plugin','test_ajax_load_scripts'));
	}

	private static function doRedirect($url) {

		global $post, $wp_query;

		if(have_posts()) {
			include($url);
			die();
		} else {
			$wp_query->is_404 = true;
		}

	}

	private static function createPluginTables() {
		
		$tables = self::$db_structure['tables'];		

		foreach ($tables as $name => $table) {
			self::createSingleTable($name, $table);
		}
	}

	private static function createSingleTable($name, $table) {

		global $wpdb;
		$prefix = self::$db_structure['prefix'];

		// check if table doesn't exists in database then create it
		if($wpdb->get_var('SHOW TABLES LIKE '.$name.'') != $name) {			

			$create_sql = 'CREATE TABLE '.$prefix.$name.' (';
			foreach ($table['fields'] as $field_name => $params) {
					$create_sql .= $field_name.$params['type'].$params['length'].$params['nonull'].$params['autoincrement'].',';
			}
			$create_sql .= 'PRIMARY KEY ('.$table['primary_key'].') ';
			$create_sql .= ') ENGINE='.$table['engine'];
		
			dbDelta($create_sql);			
		}

	}

	private static function dropPluginTables() {

		$tables =  self::$db_structure['tables'];
		foreach ($tables as $name => $table) {
			self::dropSingleTable($name);
		}
	}

	private static function dropSingleTable($name) {

		global $wpdb;
		$prefix = self::$db_structure['prefix'];
		$drop_sql = 'DROP TABLE IF EXISTS '.$prefix.$name;
		$wpdb->query($drop_sql);

	}

	private static function createPluginPage() {

		global $wpdb;

		$page_title = 'Patient';
		$page_name = 'patient';
		$page_template = 'single-patient.php';

		delete_option('my_plugin_page_title');
		add_option('my_plugin_page_title', $page_title, '', 'yes');

		//slug
		delete_option('my_plugin_page_name');
		add_option('my_plugin_page_name' ,$page_name, '', 'yes');

		//id
		delete_option('my_plugin_page_id');
		add_option('my_plugin_page_id', '0', '', 'yes');

		$the_page = get_page_by_title( $page_title );

		if( !$the_page ) {
			// creating post object if the page is not trashed after plugin deactivation
			$post = array();
			$post['post_title'] = $page_title;
			$post['post_content'] = 'Everything you wish';
			$post['post_status'] = 'publish';
			$post['post_type'] = 'page';
			$post['comment_status'] = 'closed';
			$post['ping_status'] = 'closed';
			$post['post_category'] = array(1); // default 'uncategorised' 

			//inserting the post database
			$page_id = wp_insert_post( $post );

		} else {

			// the plugin may have been active and the page may just be trashed
			$page_id = $the_page->ID;

			//make sure that the page is not trashed
			$the_page->post_status = 'publish';
			$page_id = wp_update_post( $the_page );

		}		

		delete_option('my_plugin_page_id');
		add_option('my_plugin_page_id', $page_id);

		update_post_meta( $page_id, '_wp_page_template', $page_template);
	}

	public static function test_ajax_load_scripts() {
		// load our jquery file that sends the $.post request
		wp_enqueue_script( "ajax-test", plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery' ),'0.0.1',true );
	 
		// make the ajaxurl var available to the above script
		wp_localize_script( 'ajax-test', 'the_ajax_script', array( 'ajaxurl' => plugin_dir_url( __FILE__ ).'class-ajax-handler.php' ) );	
	}
}

?>