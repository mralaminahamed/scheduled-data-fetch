<?php
/**
 * Scheduled Data Fetch
 *
 * @package           WPScheduledDataFetch
 * @author            Al Amin Ahamed
 * @copyright         2025 Al Amin Ahamed
 * @license           MIT
 *
 * @wordpress-plugin
 * Plugin Name:       WP Scheduled Data Fetch
 * Plugin URI:        https://alaminahamed.com/projects/wp-scheduled-data-fetch
 * Description:       A WordPress plugin for fetching data from a SOAP API on a scheduled basis using WordPress Cron. Automatically syncs data daily with robust error handling.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.3
 * Author:            Al Amin Ahamed
 * Author URI:        https://alaminahamed.com
 * Text Domain:       wp-scheduled-data-fetch
 * Domain Path:       /languages
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'WP_SCHEDULED_DATA_FETCH_VERSION', '1.0.0' );
define( 'WP_SCHEDULED_DATA_FETCH_FILE', __FILE__ );
define( 'WP_SCHEDULED_DATA_FETCH_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SCHEDULED_DATA_FETCH_PATH', plugin_dir_path( __FILE__ ) );

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Register the scheduled event hook
 *
 * @since 1.0.0
 */
add_action( 'wp_scheduled_data_fetch_event', 'wp_scheduled_data_fetch_callback' );

/**
 * Fetch data from SOAP API
 *
 * @since 1.0.0
 * @return void
 */
function wp_scheduled_data_fetch_callback() {
	do_action( 'wp_scheduled_data_fetch_before' );

	try {
		// Initialize Guzzle client
		$client = new Client(
			array(
				'verify'  => true, // Verify SSL certificates
				'timeout' => 30,   // Request timeout
			)
		);

		$headers = array(
			'Content-Type' => 'text/xml; charset=utf-8',
		);

		// SOAP request body
		$body = '<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <ListOfCurrenciesByName xmlns="http://www.oorsprong.org/websamples.countryinfo">
    </ListOfCurrenciesByName>
  </soap12:Body>
</soap12:Envelope>';

		// Apply filters to allow customization
		$endpoint = apply_filters( 'wp_scheduled_data_fetch_endpoint', 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso' );
		$headers  = apply_filters( 'wp_scheduled_data_fetch_headers', $headers );
		$body     = apply_filters( 'wp_scheduled_data_fetch_body', $body );

		// Create and send request
		$request  = new Request( 'POST', $endpoint, $headers, $body );
		$response = $client->sendAsync( $request )->wait();

		// Get response data
		$data = $response->getBody()->getContents();
		$data = apply_filters( 'wp_scheduled_data_fetch_data', $data );

		// Process the response (customize as needed)
		// Example: update_option( 'scheduled_data_fetch_result', $data );

		do_action( 'wp_scheduled_data_fetch_success', $data );
	} catch ( Exception $e ) {
		do_action( 'wp_scheduled_data_fetch_error', $e );
	}

	do_action( 'wp_scheduled_data_fetch_after' );
}

/**
 * Plugin activation hook
 *
 * @since 1.0.0
 * @return void
 */
function wp_scheduled_data_fetch_activation() {
	// Register WP-Cron schedule if not already scheduled
	if ( ! wp_next_scheduled( 'wp_scheduled_data_fetch_event' ) ) {
		wp_schedule_event( time(), 'daily', 'wp_scheduled_data_fetch_event' );
	}
}

register_activation_hook( __FILE__, 'wp_scheduled_data_fetch_activation' );

/**
 * Plugin deactivation hook
 *
 * @since 1.0.0
 * @return void
 */
function wp_scheduled_data_fetch_deactivation() {
	// Clear scheduled event
	$timestamp = wp_next_scheduled( 'scheduled_data_fetch_event' );
	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, 'scheduled_data_fetch_event' );
	}

	// Clear all scheduled hooks for this event
	wp_clear_scheduled_hook( 'scheduled_data_fetch_event' );
}

register_deactivation_hook( __FILE__, 'wp_scheduled_data_fetch_deactivation' );

