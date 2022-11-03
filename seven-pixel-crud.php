<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://7pixel.cl
 * @since             1.0.0
 * @package           Seven_Pixel_Crud
 *
 * @wordpress-plugin
 * Plugin Name:       7Pixel Crud
 * Plugin URI:        https://7pixel.cl
 * Description:       Plugin for Making CRUD operations into Database
 * Version:           1.0.0
 * Author:            Marco Alvarado
 * Author URI:        https://7pixel.cl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       seven-pixel-crud
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEVEN_PIXEL_CRUD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-seven-pixel-crud-activator.php
 */
function activate_seven_pixel_crud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud-activator.php';
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'crud';
	$sql = "CREATE TABLE `$table_name` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(220) DEFAULT NULL,
	`email` varchar(220) DEFAULT NULL,
	PRIMARY KEY(user_id)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;
	";
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	}
	Seven_Pixel_Crud_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-seven-pixel-crud-deactivator.php
 */
function deactivate_seven_pixel_crud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud-deactivator.php';
	Seven_Pixel_Crud_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_seven_pixel_crud' );
register_deactivation_hook( __FILE__, 'deactivate_seven_pixel_crud' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_seven_pixel_crud() {

	$plugin = new Seven_Pixel_Crud();
	$plugin->run();

}
run_seven_pixel_crud();


add_action('admin_menu', 'addAdminPageContent');
function addAdminPageContent() {
  add_menu_page('CRUD', 'CRUD', 'manage_options' ,__FILE__, 'crudAdminPage', 'dashicons-wordpress');
}
function crudAdminPage() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'userstable';
  if (isset($_POST['newsubmit'])) {
	$name = $_POST['newname'];
	$email = $_POST['newemail'];
	$wpdb->query("INSERT INTO $table_name(name,email) VALUES('$name','$email')");
	echo "<script>location.replace('admin.php?page=seven-pixel-crud%2Fseven-pixel-crud.php');</script>";
  }
  if (isset($_POST['uptsubmit'])) {
	$id = $_POST['uptid'];
	$name = $_POST['uptname'];
	$email = $_POST['uptemail'];
	$wpdb->query("UPDATE $table_name SET name='$name',email='$email' WHERE user_id='$id'");
	echo "<script>location.replace('admin.php?page=seven-pixel-crud.php');</script>";
  }
  if (isset($_GET['del'])) {
	$del_id = $_GET['del'];
	$wpdb->query("DELETE FROM $table_name WHERE user_id='$del_id'");
	echo "<script>location.replace('admin.php?page=seven-pixel-crud.php');</script>";
  }
  ?>

<div class="wrap">
   <h2>CRUD Wordpress</h2>
   <table class="wp-list-table widefat striped">
	   <thead>
		   <tr>
			   <th width="25%">User ID</th>
			   <th width="25%">Nombre-</th>
			   <th width="25%">Email</th>
			   <th width="25%">Acciones</th>
		   </tr>
	   </thead>
	   <tbody>
		   <form action="" method="post">
			   <tr>
				   <td><input type="text" value="AUTO_GENERATED" disabled></td>
				   <td><input type="text" id="newname" name="newname"></td>
				   <td><input type="text" id="newemail" name="newemail"></td>
				   <td><button id="newsubmit" name="newsubmit" type="submit">INSERTAR</button></td>
			   </tr>
		   </form>
		   <?php
		  $result = $wpdb->get_results("SELECT * FROM $table_name");
		  foreach ($result as $print) {
			echo "
			  <tr>
				<td width='25%'>$print->user_id</td>
				<td width='25%'>$print->name</td>
				<td width='25%'>$print->email</td>
				<td width='25%'><a href='admin.php?page=seven-pixel-crud.php&upt=$print->user_id'><button type='button'>UPDATE</button></a> <a href='admin.php?page=seven-pixel-crud.php&del=$print->user_id'><button type='button'>BORRAR</button></a></td>
			  </tr>
			";
		  }
		?>
	   </tbody>
   </table>
   <br>
   <br>
   <?php
	  if (isset($_GET['upt'])) {
		$upt_id = $_GET['upt'];
		$result = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$upt_id'");
		foreach($result as $print) {
		  $name = $print->name;
		  $email = $print->email;
		}
		echo "
		<table class='wp-list-table widefat striped'>
		  <thead>
			<tr>
			  <th width='25%'>User ID</th>
			  <th width='25%'>Name</th>
			  <th width='25%'>Email Address</th>
			  <th width='25%'>Actions</th>
			</tr>
		  </thead>
		  <tbody>
			<form action='' method='post'>
			  <tr>
				<td width='25%'>$print->user_id <input type='hidden' id='uptid' name='uptid' value='$print->user_id'></td>
				<td width='25%'><input type='text' id='uptname' name='uptname' value='$print->name'></td>
				<td width='25%'><input type='text' id='uptemail' name='uptemail' value='$print->email'></td>
				<td width='25%'><button id='uptsubmit' name='uptsubmit' type='submit'>UPDATE</button> <a href='admin.php?page=seven-pixel-crud%2Fseven-pixel-crud.php'><button type='button'>CANCEL</button></a></td>
			  </tr>
			</form>
		  </tbody>
		</table>";
	  }
	?>
</div>
<?php
}
