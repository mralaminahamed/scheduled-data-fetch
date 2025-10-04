# Security Policy

## Supported Versions

We actively maintain and provide security updates for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability in Scheduled Data Fetch, please report it responsibly.

### How to Report

**Please do NOT report security vulnerabilities through public GitHub issues.**

Instead, please report security vulnerabilities by emailing:
- **Email**: security@alaminahamed.com
- **Subject**: [SECURITY] Scheduled Data Fetch - Brief Description

### What to Include

When reporting a vulnerability, please include as much information as possible:

1. **Type of vulnerability** (e.g., XSS, SQL injection, etc.)
2. **Location** of the affected source code (file path and line number if possible)
3. **Step-by-step instructions** to reproduce the issue
4. **Proof of concept** or exploit code (if applicable)
5. **Impact** assessment of the vulnerability
6. **Suggested fix** (if you have one)

### Response Timeline

We aim to respond to security reports according to the following timeline:

- **Initial Response**: Within 48 hours
- **Assessment**: Within 7 days
- **Fix Development**: Within 30 days (depending on complexity)
- **Release**: Coordinated with reporter

### Disclosure Policy

We follow responsible disclosure practices:

1. **Private reporting** - Issues are reported privately first
2. **Assessment and fix** - We assess and develop fixes internally
3. **Coordinated disclosure** - We coordinate the public disclosure with the reporter
4. **Public disclosure** - After fixes are released and users have time to update

### Security Measures

This plugin implements several security measures:

#### Input Validation & Sanitization
- All user inputs are sanitized using WordPress functions
- Data validation using WordPress standards
- Proper escaping of all output

#### Access Control
- Capability checks for administrative functions
- Nonce verification for form submissions
- Proper user permission validation

#### API Security
- Secure SOAP request handling
- SSL/TLS support for encrypted communication
- Error message sanitization to prevent information disclosure

#### Database Security
- Uses WordPress database API exclusively
- Prepared statements for all queries
- No direct SQL queries

#### Cron Security
- Secure cron job registration
- Proper cleanup on deactivation
- Prevention of unauthorized cron execution

### Security Best Practices

When contributing to this project, please follow these security guidelines:

#### Code Security
- **Sanitize inputs**: Use `sanitize_text_field()`, `sanitize_email()`, etc.
- **Escape outputs**: Use `esc_html()`, `esc_attr()`, `esc_url()`, etc.
- **Validate data**: Check data types and formats
- **Use nonces**: For all form submissions and AJAX requests
- **Check capabilities**: Verify user permissions

#### API Security
```php
// Good - Secure SOAP request
try {
    $client = new \GuzzleHttp\Client([
        'verify' => true, // Verify SSL certificates
        'timeout' => 30,  // Set reasonable timeout
    ]);

    // Sanitize and validate inputs
    $endpoint = esc_url_raw( $endpoint );

    // Make request
    $response = $client->sendAsync($request)->wait();

} catch ( \Exception $e ) {
    // Log error securely without exposing sensitive data
    error_log( 'API Error: ' . esc_html( $e->getMessage() ) );
}
```

#### Cron Security
```php
// Good - Secure cron registration
if ( ! wp_next_scheduled( 'my_schedule_data_fetch' ) ) {
    wp_schedule_event( time(), 'daily', 'my_schedule_data_fetch' );
}

// Good - Capability check
if ( ! current_user_can( 'manage_options' ) ) {
    return;
}
```

### Vulnerability Scope

We consider the following as security vulnerabilities:

- Cross-Site Scripting (XSS)
- SQL Injection
- Cross-Site Request Forgery (CSRF)
- Authentication bypass
- Privilege escalation
- Remote code execution
- Local file inclusion/directory traversal
- Information disclosure
- API key/credential exposure
- Insecure data transmission

### Out of Scope

The following are generally NOT considered security vulnerabilities:

- Issues in third-party dependencies (please report to the respective maintainers)
- Social engineering attacks
- Physical access attacks
- Denial of Service attacks
- Issues requiring admin access to exploit
- Theoretical vulnerabilities without practical impact

### Security Updates

When security updates are released:

1. **Critical vulnerabilities**: Immediate patch release
2. **High severity**: Patch within 7 days
3. **Medium severity**: Patch within 30 days
4. **Low severity**: Patch in next regular release

### Security Resources

- [WordPress Security Guidelines](https://developer.wordpress.org/plugins/security/)
- [OWASP Web Security Guidelines](https://owasp.org/www-project-web-security-testing-guide/)
- [Guzzle Security Best Practices](https://docs.guzzlephp.org/en/stable/security.html)

### Recognition

Security researchers who responsibly disclose vulnerabilities will be:

- Credited in the security advisory (unless they prefer to remain anonymous)
- Listed in our Hall of Fame (if applicable)
- Given priority support for future security research

### Contact Information

For security-related inquiries:
- **Email**: security@alaminahamed.com
- **Website**: https://alaminahamed.com/security

### GPG Key

For encrypted communications, you can use our GPG key:
- **Key ID**: Available upon request
- **Fingerprint**: Available upon request

Thank you for helping keep Scheduled Data Fetch secure!
