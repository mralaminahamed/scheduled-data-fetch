<?php
/**
 * Plugin Name:     Scheduled Data Fetch
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     scheduled-data-fetch
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @throws SoapFault
 * @package         Scheduled_Data_Fetch
 */

add_action( 'my_schedule_data_fetch', 'do_schedule_data_fetch' );

do_schedule_data_fetch();

/**
 * Define the callback function
 *
 * @throws SoapFault
 */
function do_schedule_data_fetch() {
	// Define SOAP client options
	$options = array(
		'trace'      => 1, // Enable tracing to see request and response details
		'cache_wsdl' => WSDL_CACHE_NONE, // Disable WSDL caching
	);

	// Create a new SOAP client instance
	$client = new SoapClient( 'https://smartclient.lemu.dk/LMGetPrice.asmx?op=GetExtendedPrice', $options );

	// Define SOAP request parameters
	$params = array(
		'param1' => 'value1',
		'param2' => 'value2',
	);

	try {
		// Call the SOAP method
		$response = $client->__soapCall( 'MethodName', array( $params ) );

		// Process the response
		var_dump( $response );
	} catch ( SoapFault $e ) {
		// Handle SOAP errors
		echo "Error: " . $e->getMessage();
	}

}

// Define activation function
function my_plugin_activation() {
	// Register WP schedule with the callback function
	if ( ! wp_next_scheduled( 'my_schedule_data_fetch' ) ) {
		wp_schedule_event( time(), 'daily', 'my_schedule_data_fetch' );
	}
}

register_activation_hook( __FILE__, 'my_plugin_activation' );

// Define deactivation function
function my_plugin_deactivation() {
	// Deregister WP schedule
	wp_clear_scheduled_hook( 'my_schedule_data_fetch' );
}

register_deactivation_hook( __FILE__, 'my_plugin_deactivation' );

// Load plugin
require_once __DIR__ . '/vendor/autoload.php';

