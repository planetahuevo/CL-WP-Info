<?php
/**
 * Plugin Name: CL WP Info
 * Plugin URI: https://desarrolloweb.longarela.eu/
 * Description: Información del servidor, PHP y plugins y temas de WordPress para poder realizar fácilmente un informe previo de la web sobre la que vamos a trabajar
 * Version: 1.2
 * Author: Carlos Longarela
 * Author URI: https://desarrolloweb.longarela.eu/
 *
 * @package CL WP Info
 * License: GPL2+
 * Text Domain: cl-wp-info
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'CL_WP_INFO_MIN_PHP', '5.2.4' );
define( 'CL_WP_INFO_MIN_DB_MYSQL', '5.0' );
define( 'CL_WP_INFO_MIN_DB_MARIA', '10' );

define( 'CL_WP_INFO_REC_PHP', '7' );
define( 'CL_WP_INFO_REC_MYSQL', '5.6' );
define( 'CL_WP_INFO_REC_MARIA', '5.1' );

/**
 * Registramos el menú.
 *
 * @since     1.0.0
 */
function cl_wp_info_add_menu_page() {
	add_menu_page(
		esc_html__( 'CL Info WP', 'cl-wp-info' ),
		esc_html__( 'Info WP', 'cl-wp-info' ),
		'manage_options',
		'cl-wp-info',
		'cl_wp_info_general',
		'dashicons-visibility',
		3
	);
}
add_action( 'admin_menu', 'cl_wp_info_add_menu_page' );

/**
 * Carga de archivo CSS sólo en esta página de admin.
 *
 * @since     1.0.0
 * @param     string $hook   El hook (gancho) de la página actual.
 */
function load_custom_wp_admin_style( $hook ) {
	// Cargar solo en ?page=toplevel_page_cl-wp-info.
	if ( 'toplevel_page_cl-wp-info' !== $hook ) {
			return;
	}
	wp_enqueue_style( 'custom_wp_admin_css', plugins_url( 'css/cl-wp-info-admin.min.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/**
 * Carga inicial en el plugin de traducciones.
 *
 * @since     1.0.0
 */
function cl_wp_info_init() {
	load_plugin_textdomain( 'cl-wp-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'cl_wp_info_init' );

// Incluimos el archivo con las funciones de info del sistema y WP.
require_once plugin_dir_path( __FILE__ ) . 'cl-functions.php';

/**
 * Función principal encargada de mostrar toda la infomación.
 *
 * @since     1.0.0
 */
function cl_wp_info_general() {
	$obj_info = new Cl_WP_Info();

	echo '<div class="cl-no-print">Colabora</div>';

	echo '<table class="cl-tabla-general">';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'Server Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_server_info();
	echo '</tbody>';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'PHP Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_php_info();
	echo '</tbody>';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'Database Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_db_info();
	echo '</tbody>';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'WordPress Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_wordpress_info();
	echo '</tbody>';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'WordPress Themes Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_wordpress_themes();
	echo '</tbody>';

	echo '<tbody>';
	echo '<tr><th colspan="2">' . esc_html__( 'WordPress Plugins Info', 'cl-wp-info' ) . '</tr></th>';
	$obj_info->cl_wp_wordpress_plugins();
	echo '</tbody>';

	echo '</table>';
}
