# Flash messages

Display Symfony flash messages via **native browser Popover API** as toast notifications.

![flash message](images/flash_messages_via_toast.png "flash message")

## Features

- ✅ **Native Browser API** - No Bootstrap Toast dependency required
- ✅ **Automatic positioning** - Top-right corner with close button
- ✅ **Auto-dismiss** - Closes automatically after 6 seconds
- ✅ **Manual close** - Click the × button to dismiss immediately
- ✅ **Multiline support** - Use `\n` in messages for line breaks
- ✅ **Dark mode** - Automatic support for Bootstrap 5.3+ and system preferences
- ✅ **Mobile responsive** - Full-width on small screens
- ✅ **Auto-import CSS** - Styling loaded automatically via package.json

## Usage

Include the template in your base template (base.html.twig):

```twig
{% include '@SvcUtil/elements/_flashes.html.twig' %}
```

## Supported Flash Types

The bundle maps flash message types to icons:

| Flash Type | Icon | Usage |
|------------|------|-------|
| `success`  | ✅   | Successful operations |
| `error`    | ❌   | Errors and failures |
| `warning`  | ⚠️   | Warnings |
| `info`     | ℹ️   | Informational messages |
| `question` | ❓   | Questions/prompts |

## Examples

### Simple flash message

```php
$this->addFlash('success', 'Your profile has been updated!');
$this->addFlash('error', 'Unable to save changes. Please try again.');
$this->addFlash('warning', 'Your session will expire soon.');
$this->addFlash('info', 'New features are now available!');
```

### Multiline messages

Use `\n` for line breaks:

```php
$this->addFlash('success', "Operation completed!\nAll files have been processed.\nYou can now continue.");
```

The PopoverHelper automatically converts `\n` to HTML `<br>` tags while maintaining XSS protection.

## Browser Support

- Chrome/Edge 114+ (May 2023)
- Safari 17+ (September 2023)
- Firefox 125+ (April 2024)

**~89% global browser coverage (November 2025)**

For older browsers, use the [popover-polyfill](https://www.npmjs.com/package/@oddbird/popover-polyfill).

## Migration from Bootstrap Toast

If upgrading from an older version that used Bootstrap Toast, see [MIGRATION_TOAST_TO_POPOVER.md](../MIGRATION_TOAST_TO_POPOVER.md) for details.
