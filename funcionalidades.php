<?php
/**
 * Plugin Name: Funcionalidades
 * Plugin URI:  funcionalidades
 * Description: Plugin para añadir funcionalidades.
 * Version:     1.0
 * Author:      David Viña
 * Author URI:  www.davidviña.es
 * Text Domain: Funcionalidades
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     Funcionalidades
 * @author      David Viña
 * @copyright   2020 David Viña
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      funcionalidades
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Shortcode formulario.
 */
function formulario_semanawp() {
	wp_enqueue_script( 'js-formulario-semanawp', plugin_dir_url( __FILE__ ) . 'js/custom.js', array(), '1.0', true );
	wp_localize_script(
		'js-formulario-semanawp',
		'var_ajax',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'semanawp' ),
		)
	);
	ob_start();
	?>
	<form id="formulario-semanawp">
		<p>
			<label for="nombre">Nombre: </label>
			<input type="text" name="nombre" id="nombre">
		</p>
		<p>
			<label for="profesion">Profesión: </label>
			<input type="text" name="profesion" id="profesion">
		</p>
		<p>
			<input type="submit" value="Enviar">
		</p>
	</form>
	<div id="avisos"></div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'formulario_semanawp', 'formulario_semanawp' );


/**
 * Respuesta ajax.
 */
function ajax_semana_wp() {
	$nonce = sanitize_text_field( $_POST['nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'semanawp' ) ) {
		$response['response'] = 'ERROR';
		$response['error']    = 'Nonce incorrecto';

		wp_send_json( $response );
	}

	$nombre    = $_POST['nombre'];
	$profesion = $_POST['profesion'];

	$response = array(
		'response'  => 'SUCCESS',
		'nombre'    => $nombre,
		'profesion' => $profesion,
	);

	wp_send_json( $response );

}
add_action( 'wp_ajax_ajax_semana_wp', 'ajax_semana_wp' );
add_action( 'wp_ajax_nopriv_ajax_semana_wp', 'ajax_semana_wp' );
