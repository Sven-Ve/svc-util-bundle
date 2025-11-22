# Migration: Bootstrap Modal → Native HTML `<dialog>`

This document describes the migration from Bootstrap Modal to the native HTML `<dialog>` element in the `modal` Stimulus controller.

## Summary

**Date:** 2025-11-22
**Bundle Size Reduction:** ~45KB JavaScript removed
**Browser Support:** 97%+ (Chrome 37+, Firefox 98+, Safari 15.4+)

**Impact:**
- ✅ **Dynamic Modals (modal.js):** 100% API compatible - **NO CHANGES NEEDED**
- ⚠️ **Static Modals (Component):** Breaking changes - **ID attribute required**

**Quick Migration Checklist for Component Users:**
```diff
- <twig:SvcUtil-ModalDialog title="...">
+ <twig:SvcUtil-ModalDialog id="myDialog" title="...">
-   Content here
+   {% block content %}Content here{% endblock %}
  </twig:SvcUtil-ModalDialog>

- <button data-bs-toggle="modal" data-bs-target="#svcModal">Open</button>
+ <button onclick="document.getElementById('myDialog').showModal()">Open</button>
```

## What Changed?

### Before (Bootstrap Modal)
- **Dependencies:** Bootstrap CSS + JS (~45KB)
- **Template Required:** `@SvcUtil/elements/_modal.html.twig` had to be included in every page
- **Accessibility:** Manual ARIA setup
- **Dark Mode:** Bootstrap theme dependent

### After (Native `<dialog>`)
- **Dependencies:** None (0KB)
- **Template:** Not required - dialog created dynamically by controller
- **Accessibility:** WCAG 2.1 compliant by default
- **Dark Mode:** Automatic Bootstrap 5.3+ support + system preference fallback

## API Compatibility

✅ **Your existing code continues to work without changes!**

### Controller Usage (Unchanged)

```html
<!-- This code works EXACTLY as before -->
<span
  data-controller="svc--util-bundle--modal"
  data-svc--util-bundle--modal-url-value="{{ path('my_route', {id: id}) }}"
  data-svc--util-bundle--modal-title-value="{% trans %}My Title{% endtrans %}"
  data-action="click->svc--util-bundle--modal#show"
>
  <button>Show Modal</button>
</span>
```

### New Optional Features

You can now optionally use the `size` parameter:

```html
<span
  data-controller="svc--util-bundle--modal"
  data-svc--util-bundle--modal-url-value="{{ path('my_route') }}"
  data-svc--util-bundle--modal-title-value="Large Dialog"
  data-svc--util-bundle--modal-size-value="lg"
  data-action="click->svc--util-bundle--modal#show"
>
  <button>Show Large Modal</button>
</span>
```

**Available sizes:**
- `sm` - Small (300px max-width)
- `lg` - Large (800px max-width)
- `xl` - Extra Large (1140px max-width)
- `fullscreen` - Full viewport

## Breaking Changes

### Two Use Cases

The bundle now supports two different modal patterns:

#### 1. Dynamic Content (modal.js Controller)

**For content loaded via URL:**

```html
<!-- No template needed - dialog created dynamically -->
<span
  data-controller="svc--util-bundle--modal"
  data-svc--util-bundle--modal-url-value="{{ path('my_route') }}"
  data-action="click->svc--util-bundle--modal#show"
>
  <button>Show Dynamic Modal</button>
</span>
```

The dialog is created automatically by the controller.

#### 2. Static Content (SvcUtil-ModalDialog Component)

**For static/template-based content:**

✅ **Component migrated to `<dialog>` - REQUIRES ID:**

```twig
{# 1. Define the dialog with an ID (REQUIRED!) #}
<twig:SvcUtil-ModalDialog title="Confirmation" modalSize="sm" id="confirmDialog">
  {% block content %}
    <p>Are you sure?</p>
  {% endblock %}
</twig:SvcUtil-ModalDialog>

{# 2. Trigger button with onclick #}
<button
  type="button"
  class="btn btn-primary"
  onclick="document.getElementById('confirmDialog').showModal()"
>
  Open Dialog
</button>
```

**BREAKING CHANGE:** The trigger mechanism has changed!

**Before (Bootstrap Modal):**
```twig
{# OLD - No longer works #}
<button data-bs-toggle="modal" data-bs-target="#svcModal">Open</button>
```

**After (Native Dialog):**
```twig
{# NEW - Simple onclick #}
<button onclick="document.getElementById('confirmDialog').showModal()">Open</button>
```

**Key Requirements:**
- ✅ Dialog **must have an `id`** attribute
- ✅ Use `{% block content %}` for dialog content
- ✅ Use `onclick="document.getElementById('dialogId').showModal()"` to open
- ✅ Close button (×) automatically included in header

### Deprecated Templates

❌ **No longer needed:**
```twig
{# This old include is deprecated #}
{{ include("@SvcUtil/elements/_modal.html.twig") }}
```

The old `_modal.html.twig` file used Bootstrap Modal structure and is no longer used by the bundle.

### CSS Changes

**Old Bootstrap classes:**
```html
<!-- These classes no longer exist -->
<div class="modal fade" id="svcModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">...</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">...</div>
    </div>
  </div>
</div>
```

**New native dialog classes:**
```html
<!-- Dialog is created automatically with these classes -->
<dialog class="svc-dialog">
  <div class="svc-dialog-header">
    <h2 class="svc-dialog-title">...</h2>
    <button class="svc-dialog-close">×</button>
  </div>
  <div class="svc-dialog-body">...</div>
</dialog>
```

## Migration Steps

### For App Developers (Using the Bundle)

**No action required!** Your existing code continues to work.

**Required actions for `<twig:SvcUtil-ModalDialog>` users:**

1. ✅ **Add `id` attribute** to all `<twig:SvcUtil-ModalDialog>` components
2. ✅ **Update trigger buttons** from `data-bs-toggle="modal"` to `onclick="document.getElementById('dialogId').showModal()"`
3. ✅ **Use `{% block content %}`** instead of direct content

**Optional cleanup:**
1. Remove `{{ include("@SvcUtil/elements/_modal.html.twig") }}` from templates (deprecated)

### For Bundle Developers

If you want to **roll back** to Bootstrap Modal:

1. Restore the old `modal.js` from the backup comment at the top of the file
2. Remove `assets/styles/dialog.css`
3. Revert documentation changes

## Technical Details

### Features Preserved

✅ **Dynamic content loading** via Fetch API
✅ **Error handling** with user-friendly messages
✅ **Turbo integration** (`turbo:before-cache` cleanup)
✅ **ESC key** to close
✅ **Backdrop click** to close
✅ **Focus management** (automatic)

### New Features

✅ **Top layer rendering** - no z-index conflicts
✅ **Native accessibility** - WCAG 2.1 by default
✅ **Smooth animations** - pure CSS transitions
✅ **Dark mode** - automatic Bootstrap 5.3+ theme support
✅ **System preference fallback** - works without Bootstrap
✅ **XSS protection** - automatic HTML escaping

### Automatic Scroll Prevention

✅ **Prevents background scrolling** - The background page cannot scroll when the dialog is open (using CSS `overflow: hidden`)

This prevents a common issue where keyboard or mouse scrolling in the dialog unintentionally scrolls the page in the background.

**Behavior:**
- Dialog open: Background page scrolling is completely blocked
- Dialog open: Scrolling within the dialog works normally (mouse wheel and keyboard)
- Dialog with long content: Dialog body automatically receives focus for keyboard scrolling
- Dialog closed: Normal browser scrolling behavior restored

**Implementation:**
- CSS `overflow: hidden` on `document.body` when dialog opens (modal.js:173)
- Automatic focus management for scrollable content (modal.js:142-146)
- Original overflow style restored on dialog close (modal.js:177)

### Browser Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome/Edge | 37+ | ✅ Yes |
| Firefox | 98+ | ✅ Yes |
| Safari | 15.4+ | ✅ Yes |
| Safari iOS | 15.4+ | ✅ Yes |
| Chrome Android | Latest | ✅ Yes |

**Global Coverage:** 97%+ of users (January 2025)

**Polyfill available** for older browsers (but not included by default):
```html
<script>
if (!HTMLDialogElement.prototype.showModal) {
  const script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/dialog-polyfill@0.5.6/dist/dialog-polyfill.min.js';
  document.head.appendChild(script);
}
</script>
```

## Comparison: Popover vs. Dialog

This bundle now provides two native solutions:

| Feature | Popover (alert.js) | Dialog (modal.js) |
|---------|-------------------|-------------------|
| Use Case | Simple alerts/toasts | Complex modals |
| Content | Static (passed as params) | Dynamic (fetched via URL) |
| Backdrop | Yes (popover manual) | Yes (dialog native) |
| Form Support | Basic | Full |
| Server Integration | No | Yes (Fetch API) |
| Bundle Replaced | SweetAlert2 (~42KB) | Bootstrap Modal (~45KB) |

Both complement each other perfectly!

## FAQ

**Q: Do I need to update my apps?**
A: Depends on which feature you use:
- **Dynamic modals** (modal.js controller with `url-value`): No changes needed! 100% compatible.
- **Static modals** (`<twig:SvcUtil-ModalDialog>` component): Yes, you need to add `id` attribute and update trigger buttons.

**Q: My `<twig:SvcUtil-ModalDialog>` doesn't show - what's wrong?**
A: Most likely you forgot the `id` attribute! Make sure:
```twig
{# CORRECT #}
<twig:SvcUtil-ModalDialog id="myDialog" title="...">
  {% block content %}...{% endblock %}
</twig:SvcUtil-ModalDialog>
<button onclick="document.getElementById('myDialog').showModal()">Open</button>

{# WRONG - No id attribute #}
<twig:SvcUtil-ModalDialog title="...">...</twig:SvcUtil-ModalDialog>
```

**Q: Can I still use Bootstrap for styling?**
A: Yes! The dialog uses Bootstrap-compatible classes like `.alert-danger`, `.spinner-border`, etc.

**Q: What about the old `_modal.html.twig` template?**
A: It's deprecated but won't cause errors. You can safely remove includes to it.

**Q: Does dark mode work?**
A: Yes! Supports both `[data-bs-theme="dark"]` and `@media (prefers-color-scheme: dark)`.

**Q: What if I need the old behavior?**
A: The old implementation is preserved as a comment in `modal.js` lines 19-75. You can restore it if needed.

**Q: Performance impact?**
A: Positive! Faster load times (~45KB less), better rendering (native top layer), smoother animations (GPU-accelerated CSS).

## See Also

- [Native Dialog Specification (MDN)](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog)
- [Popover Migration Guide](MIGRATION_SWEETALERT_TO_POPOVER.md)
- [Stimulus Controllers Documentation](docs/stimulus-controllers.md)

## Credits

Inspired by the Medium article: "I Deleted 45KB of JavaScript Using This One HTML Tag (2025 Guide)" by CodeOrbit.
