# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial plugin structure setup
- SOAP API integration with Guzzle HTTP client
- WP-Cron scheduled data fetch functionality
- Plugin activation/deactivation hooks

## [1.0.0] - 2025-10-05

### Added
- Initial release of Scheduled Data Fetch plugin
- SOAP API client integration using Guzzle
- Scheduled data fetching with WordPress Cron
- Daily automatic data synchronization
- Error handling and logging
- Plugin activation and deactivation hooks
- Modern build system with Webpack and SCSS compilation
- Code quality tools (ESLint, Stylelint, PHPCS, PHPStan)
- Comprehensive documentation and developer guide

### Features
- **SOAP API Integration**: Connect to SOAP web services for data retrieval
- **Scheduled Execution**: Automatic data fetching using WordPress Cron
- **Error Handling**: Robust error handling with try-catch blocks
- **Activation Hooks**: Automatic cron job setup on plugin activation
- **Deactivation Hooks**: Clean cron job removal on plugin deactivation
- **Developer Tools**: Modern build pipeline with linting and static analysis

### Technical Details
- PHP 7.3+ compatibility
- PSR-4 autoloading
- Guzzle HTTP client for SOAP requests
- WordPress Cron for scheduling
- Modern JavaScript with ES6+ support
- SCSS compilation with CSS custom properties

### Code Quality
- WordPress Coding Standards (PHPCS)
- PHPStan static analysis (level 8)
- ESLint for JavaScript
- Stylelint for SCSS
- Comprehensive .gitignore configuration

### Build System
- Webpack configuration with @wordpress/scripts
- SCSS compilation with CSS custom properties
- Modern JavaScript with ES6+ support
- Development and production build scripts
- Asset optimization and minification

## [0.1.0] - Development

### Added
- Initial plugin structure
- Basic SOAP API integration research
- WordPress Cron integration planning
- Build system configuration
- Code quality tools setup
