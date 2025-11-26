# Migration: Bootstrap Toast → Native Popover API

## Overview

This bundle has migrated flash message toast notifications from **Bootstrap Toast** to the native browser **Popover API**. This eliminates the Bootstrap Toast dependency and provides better performance while maintaining the same visual behavior.

## What Changed

### Bundle Level (No Action Required)

All toast-related components have been updated internally:
- ✅ `toast_controller.js` - Migrated to PopoverHelper
- ✅ `templates/elements/_flashes.html.twig` - Migrated to native implementation

### Your Application (Action Required If...)

**You only need to take action if:**
- You're using custom flash message types beyond the standard ones
- You have custom JavaScript that interacts with Bootstrap Toast

**Most applications require NO changes** - the flash message system works exactly the same from your controller:

```php
$this->addFlash('success', 'Operation completed!');
$this->addFlash('error', 'Something went wrong!');
```

## Browser Support

The Popover API is supported in:
- ✅ Chrome/Edge 114+ (May 2023)
- ✅ Safari 17+ (September 2023)
- ✅ Firefox 125+ (April 2024)

**Coverage: ~89% of global browser usage (November 2025)**

### Polyfill for Older Browsers

If you need to support older browsers, add this to your app:

```javascript
// importmap.php or similar
if (!HTMLElement.prototype.hasOwnProperty('popover')) {
  import('@oddbird/popover-polyfill'); // 6KB
}
```

## Flash Message Types (Icons)

The bundle automatically maps your flash message type to the appropriate icon:

| Flash Type | Icon | Description |
|------------|------|-------------|
| `success`  | ✅   | Green checkmark - for successful operations |
| `error`    | ❌   | Red X - for errors and failures |
| `warning`  | ⚠️   | Yellow triangle - for warnings |
| `info`     | ℹ️   | Blue info circle - for informational messages |
| `question` | ❓   | Question mark - for prompts |

### Usage in Your Controllers

```php
// Success message
$this->addFlash('success', 'Your profile has been updated!');

// Error message
$this->addFlash('error', 'Unable to save changes. Please try again.');

// Warning message
$this->addFlash('warning', 'Your session will expire in 5 minutes.');

// Info message
$this->addFlash('info', 'New features are now available!');

// Question (if needed for prompts)
$this->addFlash('question', 'Did you know you can export your data?');
```

### Multi-line Messages

Flash messages support line breaks using `\n`:

```php
$this->addFlash('success', "Operation completed!\nAll files have been processed.");
```

The PopoverHelper automatically converts line breaks to HTML `<br>` tags while maintaining XSS protection.

## Toast Configuration

### Default Settings

Toasts appear with these defaults:
- **Position**: Top-right corner of the screen
- **Duration**: 6000ms (6 seconds)
- **Auto-dismiss**: Yes
- **Animation**: Fade in from top

### Customizing Duration

If you need to change the toast duration for specific use cases, you can create a custom Twig include:

```twig
{# templates/_custom_flashes.html.twig #}
{% for label, messages in app.flashes %}
  {% for message in messages %}
    <div style="display: none;"
      {{ stimulus_controller('svc--util-bundle--toast', {
        message: message | nl2br,
        icon: label,
        duration: 3000  {# 3 seconds instead of 6 #}
      }) }}
    ></div>
  {% endfor %}
{% endfor %}
```

## Styling

### Default Styling

The default styling provides a clean, modern toast design that works well with most applications.

### Customization

Edit `assets/styles/popover.css` to customize toast appearance:

```css
/* Change toast position */
.svc-popover-toast {
  top: 1.5rem;    /* Distance from top */
  right: 1.5rem;  /* Distance from right */
}

/* Change toast width */
.svc-popover-toast {
  max-width: 400px; /* Default: 320px */
}

/* Change icon size */
.svc-popover-toast-icon {
  font-size: 2rem; /* Default: 1.5rem */
}

/* Change border accent colors */
.svc-popover-toast-success {
  border-left: 4px solid #10b981; /* Green */
}

.svc-popover-toast-error {
  border-left: 4px solid #ef4444; /* Red */
}
```

### Dark Mode Support

Toast notifications automatically support dark mode through two methods:

1. **Bootstrap 5.3+ Dark Mode (Primary)**
   - Automatically detects `data-bs-theme="dark"` on `<html>` element
   - Works with Bootstrap's native color mode system

2. **System Preference (Fallback)**
   - Uses `prefers-color-scheme: dark` media query
   - Activates when Bootstrap theme is NOT set
   - Works in non-Bootstrap applications

No configuration needed - dark mode just works!

### Mobile Responsive

Toasts automatically adapt to mobile screens:
- Full-width on screens < 640px
- Positioned at top with proper margins
- Touch-friendly hit areas

## Migration from Bootstrap Toast Classes

If you were using Bootstrap Toast utility classes in your templates, here's how they map:

| Bootstrap Class | New Equivalent | Notes |
|----------------|----------------|-------|
| `text-bg-success` | `icon: 'success'` | Icon color handled automatically |
| `text-bg-danger` | `icon: 'error'` | Use 'error' instead of 'danger' |
| `text-bg-warning` | `icon: 'warning'` | Direct mapping |
| `text-bg-info` | `icon: 'info'` | Direct mapping |
| `data-bs-delay` | `duration` value | In milliseconds |

**Note**: The flash type `danger` still works (it's used as the icon parameter), but it will render the ❌ error icon since that's what's defined in PopoverHelper.

## Benefits of Native Popover API

### Bundle Size Reduction
- **Before**: Required Bootstrap JavaScript (~30KB for Toast component)
- **After**: Native PopoverHelper (~2KB)
- **Savings**: No Bootstrap Toast dependency needed

### Performance
- Native browser implementation
- Faster rendering
- No jQuery or Bootstrap JS required
- GPU-accelerated CSS animations

### Consistency
- Same technology as modal dialogs (see `MIGRATION_SWEETALERT_TO_POPOVER.md`)
- Unified styling across all notifications
- Single source of truth for popover behavior

### Accessibility
- Built-in ARIA attributes
- Proper screen reader announcements
- Keyboard navigation support

## Advanced Usage

### Programmatic Toast Notifications

If you need to show toasts from JavaScript (not just flash messages):

```javascript
import { PopoverHelper } from '@svc/util-bundle/popover-helper.js';

// Show a success toast
PopoverHelper.showToast('Changes saved!', 'success', 1500);

// Show an error toast with longer duration
PopoverHelper.showToast('Network error', 'error', 5000);

// Show custom icon
PopoverHelper.showToast('Party time!', '🎉', 2000);
```

### Stacking Multiple Toasts

The native implementation automatically stacks multiple toasts vertically. Each toast maintains its own timer and dismisses independently.

## Troubleshooting

### Toasts not appearing
1. Verify you're including the flash template: `{% include '@SvcUtil/elements/_flashes.html.twig' %}`
2. Check browser console for JavaScript errors
3. Ensure `popover.css` is loaded

### Wrong icons showing
- The icon type matches your flash message type exactly
- If you use `$this->addFlash('danger', ...)`, it will show the 'danger' icon (you may want to use 'error' instead)
- Custom icon types will be passed as-is to the PopoverHelper

### Duration too short/long
- Default is 6000ms (6 seconds)
- Customize in your template as shown in "Customizing Duration" section

### Toasts behind other elements
- Toasts use `position: fixed` with high z-index
- Check your CSS for conflicting z-index values
- Inspect with browser DevTools

## Migration Checklist

- [x] Update bundle to version 2.6.0+
- [ ] Test flash messages in your application
- [ ] Verify all flash types render correctly (success, error, warning, info)
- [ ] Check mobile responsive behavior
- [ ] Test dark mode if applicable
- [ ] Optional: Customize toast styling in `popover.css`
- [ ] Optional: Adjust toast duration if needed

## Need Help?

- Browser support: https://caniuse.com/mdn-api_popover
- Popover API Spec: https://developer.mozilla.org/en-US/docs/Web/API/Popover_API
- File issues: https://github.com/Sven-Ve/svc-util-bundle/issues
