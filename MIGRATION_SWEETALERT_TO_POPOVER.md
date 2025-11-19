# Migration: SweetAlert2 → Native Popover API

## Overview

This bundle has been migrated from SweetAlert2 to the native browser **Popover API**. This eliminates the external dependency (~47KB) and provides better performance while maintaining the same API.

## What Changed

### Bundle Level (No Action Required)

All Stimulus controllers have been updated internally:
- ✅ `alert.js` - Migrated to PopoverHelper
- ✅ `submit-confirm.js` - Migrated to PopoverHelper
- ✅ `clipboard.js` - Migrated to PopoverHelper (Toast)
- ✅ `mclipboard.js` - Migrated to PopoverHelper (Toast)
- ✅ `reload-content.js` - Migrated to PopoverHelper

### Your Application (Action Required)

If you were using SweetAlert2 directly in your app (not through our controllers), you need to update your code.

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

## API Comparison

### Modal Dialogs

**Before (SweetAlert2):**
```javascript
import Swal from 'sweetalert2';

Swal.fire({
  title: 'Are you sure?',
  text: 'This cannot be undone',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete',
  cancelButtonText: 'Cancel'
}).then((result) => {
  if (result.isConfirmed) {
    // User clicked "Yes, delete"
  }
});
```

**After (PopoverHelper):**
```javascript
import { PopoverHelper } from '@svc/util-bundle/popover-helper.js';

PopoverHelper.fire({
  title: 'Are you sure?',
  text: 'This cannot be undone',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete',
  cancelButtonText: 'Cancel'
}).then((result) => {
  if (result.isConfirmed) {
    // User clicked "Yes, delete"
  }
});
```

**The API is identical!** Just change the import.

### Toast Notifications

**Before (SweetAlert2):**
```javascript
Swal.fire({
  title: 'Saved!',
  icon: 'success',
  timer: 1500
});
```

**After (PopoverHelper):**
```javascript
PopoverHelper.showToast('Saved!', 'success', 1500);
```

## Icon System

SweetAlert2 had custom SVG icons. We now use **Emoji icons**:

| Icon Type | Emoji |
|-----------|-------|
| `success` | ✅ |
| `error`   | ❌ |
| `warning` | ⚠️ |
| `info`    | ℹ️ |
| `question`| ❓ |

You can also pass any emoji string directly:
```javascript
PopoverHelper.fire({
  icon: '🎉',
  title: 'Congratulations!'
});
```

## Styling

The default styling matches common design systems (similar to SweetAlert2).

### Customization

Edit `assets/styles/popover.css` to customize:
- Colors: Change button colors in `.svc-popover-btn-confirm`
- Sizing: Adjust `.svc-popover-modal` max-width
- Animations: Modify transition timings
- Dark Mode: Already supported via `@media (prefers-color-scheme: dark)`

### Integration with Your Design System

If you use Bootstrap, Tailwind, or another framework:

```css
/* Override default button styling */
.svc-popover-btn-confirm {
  /* Use your primary button classes */
  @apply btn btn-primary;
}

.svc-popover-btn-cancel {
  /* Use your secondary button classes */
  @apply btn btn-secondary;
}
```

## Advanced Features

### Manual Mode (Modal that won't close on ESC/outside click)

```javascript
PopoverHelper.fire({
  title: 'Critical Action',
  text: 'You must choose',
  allowOutsideClick: false, // This uses popover="manual"
  showCancelButton: true
});
```

### HTML Content

```javascript
PopoverHelper.fire({
  title: 'Rich Content',
  html: '<strong>Bold text</strong><br>Line break<br><em>Italic</em>'
});
```

### Auto-dismiss Timer

```javascript
PopoverHelper.fire({
  title: 'Auto-closing',
  text: 'This closes in 3 seconds',
  timer: 3000
});
```

## Benefits of Native Popover API

### Bundle Size
- **Before**: SweetAlert2 ~47KB (minified + gzipped)
- **After**: PopoverHelper ~2KB + CSS ~3KB = **5KB total**
- **Savings**: ~42KB (84% reduction) ✅

### Performance
- Native browser implementation (faster than JavaScript)
- No external HTTP requests
- Better memory efficiency
- Smooth CSS animations with GPU acceleration

### Accessibility
- Built-in keyboard navigation (ESC, Tab)
- Automatic focus management
- Proper ARIA attributes
- Screen reader support

### Maintenance
- One less dependency to update
- No breaking changes from library updates
- Platform feature (will only get better)

## Troubleshooting

### Icons not showing correctly
- Make sure your font supports emoji rendering
- On older systems, emojis may render as black/white
- Solution: Use Font Awesome instead (modify `PopoverHelper.icons`)

### Backdrop not blurring
- `backdrop-filter: blur()` requires browser support
- Falls back gracefully to solid background
- Works in all modern browsers

### Animations not smooth
- Check for CSS conflicts with `[popover]` selector
- Ensure you're not overriding `display` or `overlay` properties
- Use browser DevTools to inspect transition timing

## Migration Checklist

- [x] Update bundle to version 2.6.0+
- [ ] Remove `sweetalert2` from your `importmap.php` (if not used elsewhere)
- [ ] Update custom code using `Swal.fire()` to `PopoverHelper.fire()`
- [ ] Test all modal dialogs and toast notifications
- [ ] Verify keyboard navigation (ESC, Tab)
- [ ] Test on target browsers
- [ ] Optional: Customize styling in `popover.css`

## Need Help?

- Browser support: https://caniuse.com/mdn-api_popover
- Popover API Spec: https://developer.mozilla.org/en-US/docs/Web/API/Popover_API
- File issues: https://github.com/Sven-Ve/svc-util-bundle/issues
