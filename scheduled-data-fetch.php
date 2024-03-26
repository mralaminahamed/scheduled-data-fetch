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

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

// Load plugin
require_once __DIR__ . '/vendor/autoload.php';


add_action( 'my_schedule_data_fetch', 'do_schedule_data_fetch' );

do_schedule_data_fetch();

/**
 * Define the callback function
 *
 * @throws SoapFault
 */
function do_schedule_data_fetch() {
	try {
		// Call the SOAP method
		$client = new Client();
		$headers = [
			'Content-Type' => 'text/xml; charset=utf-8'
		];
		$body = '<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <ListOfCurrenciesByName xmlns="http://www.oorsprong.org/websamples.countryinfo">
    </ListOfCurrenciesByName>
  </soap12:Body>
</soap12:Envelope>';
		$request = new Request('POST', 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso', $headers, $body);
		$res = $client->sendAsync($request)->wait();
		echo $res->getBody();

		// Process the response
//		var_dump( $res->getBody() );
	} catch ( Exception $e ) {
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

