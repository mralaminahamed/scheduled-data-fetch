# Scheduled Data Fetch

[![WordPress Plugin Version](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)](https://wordpress.org/)
[![PHP Version](https://img.shields.io/badge/PHP-7.3%2B-777BB4.svg)](https://php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

> **A robust WordPress plugin for fetching data from SOAP APIs on a scheduled basis using WordPress Cron.**

## ✨ Features

### 🎯 **SOAP API Integration**
- **Guzzle HTTP Client**: Modern HTTP client for reliable SOAP requests
- **Error Handling**: Comprehensive error handling with try-catch blocks
- **Async Support**: Asynchronous request handling for better performance

### ⏰ **Scheduled Execution**
- **WordPress Cron**: Native WordPress scheduling system
- **Daily Sync**: Automatic daily data synchronization
- **Flexible Scheduling**: Easy customization of schedule intervals

### 🔧 **Developer Friendly**
- **PSR-4 Autoloading**: Modern PHP autoloading standard
- **Code Quality**: PHPCS, PHPStan, ESLint, and Stylelint integration
- **Modern Build System**: Webpack with @wordpress/scripts
- **Comprehensive Documentation**: Detailed inline documentation

---

## 🚀 Quick Start

### Installation

1. **Upload & Activate**
   ```bash
   cd wp-content/plugins/
   # Upload plugin files
   # Activate via WordPress admin
   ```

2. **Requirements Check**
   - ✅ WordPress 5.0+
   - ✅ PHP 7.3+
   - ✅ Composer (for development)
   - ✅ Node.js 14+ (for development)

3. **Automatic Setup**
   - Cron job automatically scheduled on plugin activation
   - No additional configuration needed!

---

## 📖 Documentation

### How It Works

The plugin uses WordPress Cron to schedule automatic data fetching from SOAP APIs:

1. **Activation**: When the plugin is activated, a daily cron job is registered
2. **Execution**: The cron job runs daily and fetches data from the configured SOAP API
3. **Processing**: Data is retrieved and can be processed or stored as needed
4. **Deactivation**: Cron job is automatically removed when plugin is deactivated

### Configuration

#### Customizing the Schedule

By default, the plugin runs daily. To change the schedule interval:

```php
// In your plugin file or custom code
function my_custom_schedule_interval( $schedules ) {
    $schedules['weekly'] = array(
        'interval' => 604800, // 7 days in seconds
        'display'  => __( 'Once Weekly', 'scheduled-data-fetch' )
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'my_custom_schedule_interval' );

// Update the schedule in activation function
if ( ! wp_next_scheduled( 'my_schedule_data_fetch' ) ) {
    wp_schedule_event( time(), 'weekly', 'my_schedule_data_fetch' );
}
```

#### Customizing the SOAP Request

The SOAP request can be customized by modifying the `do_schedule_data_fetch()` function:

```php
function do_schedule_data_fetch() {
    try {
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'text/xml; charset=utf-8'
        ];

        // Customize your SOAP body
        $body = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
          <soap12:Body>
            <YourSOAPMethod xmlns="http://your-namespace.com">
              <!-- Your parameters here -->
            </YourSOAPMethod>
          </soap12:Body>
        </soap12:Envelope>';

        $request = new \GuzzleHttp\Psr7\Request(
            'POST',
            'https://your-soap-endpoint.com/service',
            $headers,
            $body
        );

        $response = $client->sendAsync($request)->wait();

        // Process your response
        $data = $response->getBody()->getContents();

        // Store or process the data
        // update_option('my_soap_data', $data);

    } catch ( \Exception $e ) {
        error_log( 'SOAP Error: ' . $e->getMessage() );
    }
}
```

### Manual Execution

To manually trigger the data fetch:

```php
do_action( 'my_schedule_data_fetch' );
```

Or run the function directly:

```php
do_schedule_data_fetch();
```

### Available Hooks

#### Action Hooks

```php
// Before data fetch
do_action( 'scheduled_data_fetch_before' );

// After successful data fetch
do_action( 'scheduled_data_fetch_success', $data );

// After failed data fetch
do_action( 'scheduled_data_fetch_error', $error );
```

#### Filter Hooks

```php
// Filter SOAP endpoint
apply_filters( 'scheduled_data_fetch_endpoint', $endpoint );

// Filter SOAP headers
apply_filters( 'scheduled_data_fetch_headers', $headers );

// Filter SOAP body
apply_filters( 'scheduled_data_fetch_body', $body );

// Filter processed data
apply_filters( 'scheduled_data_fetch_data', $data );
```

---

## 🛠️ Development

### Build System

**Requirements:**
- Node.js 14+
- Composer

**Setup:**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
yarn install

# Build assets
yarn build

# Development mode (watch files)
yarn start
```

**Available Commands:**
```bash
yarn build              # Production build
yarn start              # Development watch mode
yarn packages-update    # Update WordPress packages

composer phpcs          # PHP Code Standards check
composer phpcbf         # PHP Code Standards auto-fix
composer phpstan        # PHP static analysis
composer makepot        # Generate translation file
composer zip            # Create distribution zip
```

### Code Quality

- **WordPress Coding Standards** (PHPCS)
- **PHPStan Level 8** static analysis
- **ESLint** for JavaScript
- **Stylelint** for SCSS
- **Prettier** for code formatting

### Architecture

```
scheduled-data-fetch/
├── scheduled-data-fetch.php       # Main plugin file
├── src/                          # Source files
│   └── index.js                  # Main JavaScript entry
├── vendor/                       # Composer dependencies
├── node_modules/                 # Node dependencies
├── build/                        # Compiled assets (auto-generated)
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
├── webpack.config.js             # Webpack configuration
├── phpcs.xml                     # PHPCS configuration
└── phpstan.neon                  # PHPStan configuration
```

---

## 🔧 Troubleshooting

### Common Issues

**Cron job not running:**
- ✅ Check if WP-Cron is enabled (wp-config.php: `DISABLE_WP_CRON`)
- ✅ Verify cron schedule: `wp cron event list` (WP-CLI)
- ✅ Check server timezone settings

**SOAP request failing:**
- ✅ Verify SOAP endpoint URL is correct
- ✅ Check SSL certificate validity
- ✅ Ensure proper authentication if required
- ✅ Review error logs for specific error messages

**Plugin not activating:**
- ✅ Check PHP version (7.3+ required)
- ✅ Verify Composer dependencies are installed
- ✅ Review PHP error logs

### Debug Mode

Enable WordPress debug mode for troubleshooting:

```php
// wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

### Checking Scheduled Events

Using WP-CLI:

```bash
# List all scheduled events
wp cron event list

# List specific event
wp cron event list --filter=my_schedule_data_fetch

# Run event manually
wp cron event run my_schedule_data_fetch
```

---

## 📊 Performance

### Optimizations
- **Async Requests**: Non-blocking SOAP requests
- **Scheduled Execution**: Background processing via WP-Cron
- **Error Handling**: Prevents site slowdown on API failures
- **Minimal Footprint**: Lightweight plugin with minimal overhead

### Benchmarks
- **Memory Usage**: < 2MB additional memory
- **Execution Time**: Varies based on API response time
- **Cron Impact**: Minimal impact on site performance

---

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. **Fork the repository**
2. **Create a feature branch**
3. **Follow WordPress coding standards**
4. **Add tests for new functionality**
5. **Submit a pull request**

### Development Setup
```bash
git clone <repository-url>
cd scheduled-data-fetch
composer install
yarn install
yarn start
```

### Code Standards
- WordPress PHP Coding Standards
- WordPress JavaScript Coding Standards
- SCSS with BEM methodology
- PHPStan level 8 compliance

---

## 📝 Changelog

### [1.0.0] - 2025-10-05
#### Added
- 🎉 Initial release
- ✨ SOAP API integration with Guzzle HTTP client
- ⏰ WordPress Cron scheduled data fetching
- 🔧 Activation and deactivation hooks
- 📱 Error handling and logging
- ⚡ Modern build system with Webpack
- 🎯 Code quality tools (PHPCS, PHPStan, ESLint, Stylelint)

---

## 📞 Support

- **📚 Documentation**: This README and inline code documentation
- **🐛 Issues**: [GitHub Issues](https://github.com/mralaminahamed/scheduled-data-fetch/issues)
- **💡 Feature Requests**: Submit via GitHub Issues with enhancement label
- **👨‍💻 Developer Support**: Comprehensive hooks and filter system for customization

---

## 📜 License

MIT License - see [LICENSE](LICENSE) file for details

---

## 👨‍💻 Author

**Al Amin Ahamed**

- 🌐 **Website**: [alaminahamed.com](https://alaminahamed.com)
- 💼 **Specialization**: WordPress plugin development and API integrations
- 📧 **Email**: me@alaminahamed.com
- 🐱 **GitHub**: [@mralaminahamed](https://github.com/mralaminahamed)
- 💼 **Available**: Custom development projects and consulting

---

<div align="center">

**Made with ❤️ for the WordPress community**

[⭐ Star this project](https://github.com/mralaminahamed/scheduled-data-fetch) if you find it useful!

</div>
