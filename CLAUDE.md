# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Testing and Quality Assurance
- Run tests: `composer test` or `vendor/bin/phpunit --testdox`
- Run PHPStan static analysis: `composer phpstan` or `php -d memory_limit=-1 vendor/bin/phpstan analyse -c .phpstan.neon`
- Run PHP CS Fixer: `/opt/homebrew/bin/php-cs-fixer fix`

## Architecture Overview

This is a **Symfony Bundle** (svc/util-bundle) that provides utility services and components for Symfony applications.

### Core Components

**Services** (src/Service/):
- `EnvInfoHelper` - Environment information utilities (URLs, server details)
- `MailerHelper` - Simplified email sending with template support
- `NetworkHelper` - Network-related utilities
- `UIHelper` - UI helper functions

**Controllers** (src/Controller/):
- `EnvInfoController` - Displays environment information page

**Twig Components** (src/Twig/Components/):
- `Table` - Bootstrap table component with configurable options
- `ModalDialog` - Modal dialog component

**Frontend Assets** (assets/src/):
- Stimulus controllers for interactive behaviors (autosubmit, clipboard, modal, toast, etc.)

### Bundle Configuration

The bundle uses Symfony's new Bundle Configuration System (requires Symfony >=6.1) and supports:
- Mailer configuration (default sender address/name)
- Twig component configuration (table default type)
- AssetMapper integration for frontend assets

### Key Features

- Email sending with Twig templates
- Environment information display
- Network utilities
- Bootstrap-based Twig components
- Stimulus controllers for enhanced UI interactions
- Flash message handling via toast notifications

### Test Architecture

Uses PHPUnit with a custom testing kernel (`SvcUtilTestingKernel`) for isolated bundle testing.

### Info

the geolocation API works only with http because of licence issues.