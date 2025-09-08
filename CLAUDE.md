# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Testing and Quality Assurance
- Run all tests: `composer test` or `vendor/bin/phpunit --testdox`
- Run single test class: `vendor/bin/phpunit tests/Service/MailerHelperTest.php --testdox`
- Run single test method: `vendor/bin/phpunit --filter testMailOptions tests/Service/MailerHelperTest.php`
- Run PHPStan static analysis: `composer phpstan` or `php -d memory_limit=-1 vendor/bin/phpstan analyse -c .phpstan.neon`
- Run PHP CS Fixer: `/opt/homebrew/bin/php-cs-fixer fix`
- Dry-run PHP CS Fixer: `/opt/homebrew/bin/php-cs-fixer fix --dry-run --diff`

## Architecture Overview

This is a **Symfony Bundle** (svc/util-bundle) that provides utility services and components for Symfony applications.

### Bundle Configuration System

The bundle uses Symfony's new Bundle Configuration System (requires Symfony >=6.1). Configuration is handled in `SvcUtilBundle::configure()` and supports:

```yaml
# config/packages/svc_util.yaml
svc_util:
  mailer:
    mail_address: 'noreply@example.com'  # Required - no hardcoded fallback
    mail_name: 'System Mailer'
  twig_components:
    table_default_type: 1  # Optional - enables striped, bordered, small tables
```

**Critical**: The `MailerHelper` service will throw `InvalidArgumentException` if `mailer.mail_address` is not configured.

### Configuration Validation

The bundle validates that required configuration values are properly set:
- `mailer.mail_address` must be provided (has default 'test@test.com' but should be overridden in production)
- Defaults exist for testing but production apps should override with real values

### Core Services Architecture

**NetworkHelper** (static methods):
- IP detection with security validation (filters private/reserved ranges)
- External geolocation API calls to geoplugin.net (HTTP only, 5-second timeout)
- User agent and referer extraction

**MailerHelper** (service with DI):
- Template-based email sending via Symfony Mailer
- Options resolver pattern for configuration
- Dry-run support for testing

**EnvInfoHelper** (static methods):
- Server URL construction with security validation
- Host header injection protection via regex validation

**EnvInfoController**:
- Admin-only environment information display
- Whitelisted server variables to prevent information disclosure
- XSS protection via `htmlspecialchars()` and Twig escaping

### Frontend Asset Integration

AssetMapper integration automatically maps `assets/src/` to `@svc/util-bundle` namespace. Stimulus controllers use lazy loading pattern (`stimulusFetch: 'lazy'`) and external dependencies (SweetAlert2, Bootstrap).

### Test Architecture

Uses custom `SvcUtilTestingKernel` that:
- Registers minimal bundles: Framework, Twig, SvcUtil, TwigComponent
- Configures null mailer transport for testing
- Routes with `/api/{_locale}` prefix for internationalization testing
- PHPStan ignores testing kernel method as unused (intentional)

### Security Considerations

- External API calls to geoplugin.net use HTTP (not HTTPS) - known limitation
- Server variable whitelisting in EnvInfoController prevents information disclosure
- Input validation via regex patterns in EnvInfoHelper methods
- Network IP validation excludes private/reserved ranges for public IP detection