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

### Form Extensions

**TogglePasswordTypeExtension** (`src/Form/Extension/TogglePasswordTypeExtension.php`):
- Extends Symfony's `PasswordType` to add show/hide toggle functionality
- Automatically integrates Stimulus controller (`svc--util-bundle--toggle-password`)
- Options resolver pattern with strict type validation
- Key options:
  - `toggle` (bool): Enable/disable toggle functionality
  - `visible_label`/`hidden_label` (string|null): Button text when password is hidden/shown
  - `visible_icon`/`hidden_icon` (string|null): HTML for icons (default: built-in SVG eye icons)
  - `button_classes` (array): CSS classes for toggle button
  - `toggle_container_classes` (array): CSS classes for wrapper container
  - `use_toggle_form_theme` (bool): Apply form theme (adds `toggle_password` block prefix)
- Form theme: `templates/form_theme.html.twig` wraps password widget in container
- Stimulus controller: `assets/src/toggle_password.js` with custom events (connect, show, hide)
- CSS: `assets/styles/toggle_password.css` with absolute positioning for toggle button
- Test coverage: `tests/Form/Extension/TogglePasswordTypeExtensionTest.php` (15 tests)

### Frontend Asset Integration

AssetMapper integration automatically maps `assets/src/` to `@svc/util-bundle` namespace. Stimulus controllers use lazy loading pattern (`stimulusFetch: 'lazy'`) and external dependencies (SweetAlert2, Bootstrap).

### Test Architecture

Uses custom `SvcUtilTestingKernel` that:
- Registers minimal bundles: Framework, Twig, SvcUtil, TwigComponent
- Configures null mailer transport for testing
- Routes with `/api/{_locale}` prefix for internationalization testing
- PHPStan ignores testing kernel method as unused (intentional)

**Form Extension Tests**:
- Use standalone `Forms::createFormFactoryBuilder()` instead of kernel container
- Directly register type extensions via `addTypeExtension()`
- Extend `PHPUnit\Framework\TestCase` (not `KernelTestCase`)
- Test all options, validation, Stimulus integration, and form theme behavior

**Code Style**:
- All PHP files use `declare(strict_types=1)` at the top
- PHPUnit assertions with `RenderedComponent` objects must cast to string: `(string) $rendered`
- PHPStan level enforces strict type checking

### Security Considerations

- External API calls to geoplugin.net use HTTP (not HTTPS) - known limitation
- Server variable whitelisting in EnvInfoController prevents information disclosure
- Input validation via regex patterns in EnvInfoHelper methods
- Network IP validation excludes private/reserved ranges for public IP detection