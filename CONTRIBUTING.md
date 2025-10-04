# Contributing to Scheduled Data Fetch

Thank you for your interest in contributing to Scheduled Data Fetch! We welcome contributions from the community.

## Development Setup

### Prerequisites

- WordPress 5.0+
- PHP 7.3+
- Node.js 14+
- Composer
- Yarn package manager

### Local Development

1. **Clone the repository**
   ```bash
   cd wp-content/plugins/
   git clone <repository-url> scheduled-data-fetch
   cd scheduled-data-fetch
   ```

2. **Install dependencies**
   ```bash
   composer install
   yarn install
   ```

3. **Build assets**
   ```bash
   yarn build
   ```

4. **Enable development mode**
   ```bash
   yarn start
   ```

## Code Standards

### WordPress Coding Standards

This project follows WordPress coding standards:

- **PHP**: WordPress PHP Coding Standards (WPCS)
- **JavaScript**: WordPress JavaScript Coding Standards
- **CSS/SCSS**: WordPress CSS Coding Standards with BEM methodology

### Quality Tools

Before submitting a pull request, ensure all quality checks pass:

```bash
# PHP Code Standards
composer phpcs

# PHP Static Analysis
composer phpstan

# JavaScript Linting
yarn lint

# SCSS Linting
yarn lint:css

# Fix auto-fixable issues
yarn lint:fix
composer phpcbf
```

### Required Quality Levels

- **PHPCS**: Must pass WordPress coding standards
- **PHPStan**: Must pass level 8 static analysis
- **ESLint**: Must pass WordPress JavaScript standards
- **Stylelint**: Must pass SCSS linting rules

## Development Workflow

### Branch Naming

- `feature/feature-name` - New features
- `fix/issue-description` - Bug fixes
- `enhancement/improvement-name` - Enhancements
- `docs/documentation-update` - Documentation updates

### Commit Messages

Follow conventional commit format:

```
type(scope): description

[optional body]

[optional footer]
```

Examples:
- `feat(api): add support for custom SOAP headers`
- `fix(cron): resolve schedule timing issue`
- `docs(readme): update installation instructions`
- `style(css): improve responsive layout`

### Pull Request Process

1. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes**
   - Follow coding standards
   - Add tests if applicable
   - Update documentation

3. **Test your changes**
   ```bash
   yarn build
   composer phpcs
   composer phpstan
   ```

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat(scope): your descriptive message"
   ```

5. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **Create a pull request**
   - Provide a clear description
   - Reference any related issues
   - Include screenshots if applicable

## Code Architecture

### Plugin Structure

- **Bootstrap**: `scheduled-data-fetch.php`
- **Source Files**: `src/` directory
- **Dependencies**: Managed via Composer and Yarn

### SOAP Integration

The plugin uses Guzzle HTTP client for SOAP requests:
- Modern async/await pattern
- Comprehensive error handling
- PSR-7 request/response interface

### WordPress Cron

- Scheduled events using `wp_schedule_event()`
- Activation hook registers cron job
- Deactivation hook cleans up cron job

### Build System

- **Webpack**: Asset compilation with @wordpress/scripts
- **SCSS**: CSS preprocessing
- **JavaScript**: ES6+ with WordPress standards

## Testing

### Manual Testing

Test on:
- Latest WordPress version
- Multiple PHP versions (7.3, 7.4, 8.0+)
- Different server configurations
- Various SOAP API endpoints

### Testing Checklist

- [ ] Plugin activates without errors
- [ ] Cron job is registered on activation
- [ ] SOAP request executes successfully
- [ ] Error handling works correctly
- [ ] Cron job is removed on deactivation
- [ ] No PHP errors/warnings
- [ ] No JavaScript errors
- [ ] Code passes all quality checks

## Documentation

### Code Documentation

- Use PHP DocBlocks for all functions and classes
- Comment complex logic
- Document hook usage
- Include @since tags for new functions

### User Documentation

- Update README.md for new features
- Add changelog entries
- Include usage examples
- Document configuration options

## Issue Reporting

### Bug Reports

Include:
- WordPress version
- PHP version
- Plugin version
- Steps to reproduce
- Expected vs actual behavior
- Error logs (if applicable)
- Server environment details

### Feature Requests

Include:
- Use case description
- Expected behavior
- Proposed implementation (if any)
- Impact on existing functionality

## Security

### Reporting Security Issues

Email security issues to: security@alaminahamed.com

Do not open public issues for security vulnerabilities.

### Security Guidelines

- Sanitize all input data
- Escape all output
- Use nonces for form submissions
- Follow WordPress security best practices
- Never expose sensitive information

## Support

- **Documentation**: README.md and inline documentation
- **Issues**: GitHub Issues for bug reports and feature requests
- **Questions**: Use GitHub Discussions for general questions

## License

By contributing to this project, you agree that your contributions will be licensed under the MIT license.

## Recognition

Contributors will be recognized in:
- CHANGELOG.md
- Plugin credits
- GitHub contributors list

Thank you for contributing to Scheduled Data Fetch!
