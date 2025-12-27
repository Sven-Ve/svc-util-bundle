# Migration: NetworkHelper::getAll() → NetworkInfo DTO

## Overview

This bundle has introduced a new type-safe **NetworkInfo** value object to replace the array-based `NetworkHelper::getAll()` method. This provides better IDE support, static analysis, and additional helper methods while maintaining backward compatibility.

## What Changed

### New in Version 8.4

- ✅ **NetworkInfo** value object (readonly DTO)
- ✅ `NetworkHelper::getAllAsObject()` - Returns NetworkInfo instance
- ⚠️ `NetworkHelper::getAll()` - **Deprecated** (will be removed in version 9.0)

### Backward Compatibility

**The old `getAll()` method still works** - it's just marked as deprecated. You can migrate at your own pace before version 9.0.

## Migration Guide

### Before (Deprecated)

```php
use Svc\UtilBundle\Service\NetworkHelper;

$info = NetworkHelper::getAll();

$ip = $info['ip'];           // ?string
$country = $info['country']; // string
$city = $info['city'];       // string
$ua = $info['ua'];           // ?string
$referer = $info['referer']; // ?string
```

**Problems with this approach:**
- No IDE autocomplete for array keys
- Typos like `$info['cuntry']` only discovered at runtime
- No static analysis by PHPStan
- No additional helper methods

### After (Recommended)

```php
use Svc\UtilBundle\Service\NetworkHelper;
use Svc\UtilBundle\Model\NetworkInfo;

$info = NetworkHelper::getAllAsObject();

$ip = $info->ip;             // ?string - with full IDE support
$country = $info->country;   // string
$city = $info->city;         // string
$ua = $info->userAgent;      // ?string - renamed from 'ua' for clarity
$referer = $info->referer;   // ?string
```

**Benefits:**
- ✅ Full IDE autocomplete and type hints
- ✅ PHPStan catches errors at development time
- ✅ Immutable (readonly properties)
- ✅ Additional helper methods (see below)

## NetworkInfo Features

### Helper Methods

The NetworkInfo DTO includes useful helper methods:

```php
$info = NetworkHelper::getAllAsObject();

// Check if location data is available
if ($info->hasLocation()) {
    echo "User is from {$info->city}, {$info->country}";
}

// Check if this is a local/private IP
if ($info->isLocalhost()) {
    echo "Development environment detected";
} else {
    echo "Public IP: {$info->ip}";
}
```

### Named Constructor

You can also create NetworkInfo instances directly:

```php
use Svc\UtilBundle\Model\NetworkInfo;

// From current client (same as NetworkHelper::getAllAsObject())
$info = NetworkInfo::fromCurrentClient();

// Manual construction (for testing or custom scenarios)
$info = new NetworkInfo(
    ip: '8.8.8.8',
    country: 'US',
    city: 'Mountain View',
    userAgent: 'Mozilla/5.0...',
    referer: 'https://example.com'
);
```

### Backward Compatibility Helpers

If you need the old array format (e.g., for legacy code or APIs):

```php
$info = NetworkHelper::getAllAsObject();

// Convert to old array format
$array = $info->toArray();
// Returns: ['ip' => ..., 'country' => ..., 'city' => ..., 'ua' => ..., 'referer' => ...]
```

### JSON Serialization

NetworkInfo implements `JsonSerializable` for API responses:

```php
$info = NetworkHelper::getAllAsObject();

// Direct JSON encoding
$json = json_encode($info);
// Returns: {"ip":"...","country":"...","city":"...","userAgent":"...","referer":"..."}

// Or in Symfony controller
return $this->json($info);
```

**Note:** `jsonSerialize()` uses `userAgent` (not `ua`) for better API consistency. Use `toArray()` if you need the legacy format with `ua`.

## Property Name Changes

When migrating, note this naming change for clarity:

| Old Array Key | New DTO Property | Reason |
|---------------|------------------|--------|
| `ua` | `userAgent` | More descriptive and standard naming |

All other property names remain the same.

## Migration Examples

### Example 1: Simple Data Access

**Before:**
```php
$data = NetworkHelper::getAll();
$userIp = $data['ip'] ?? 'unknown';
```

**After:**
```php
$info = NetworkHelper::getAllAsObject();
$userIp = $info->ip ?? 'unknown';
```

### Example 2: Conditional Logic

**Before:**
```php
$data = NetworkHelper::getAll();
if (!empty($data['country']) || !empty($data['city'])) {
    // Has location info
}
```

**After:**
```php
$info = NetworkHelper::getAllAsObject();
if ($info->hasLocation()) {
    // Has location info - cleaner and more semantic
}
```

### Example 3: API Response

**Before:**
```php
$data = NetworkHelper::getAll();
return $this->json([
    'ip' => $data['ip'],
    'country' => $data['country'],
    'city' => $data['city'],
    'userAgent' => $data['ua'],
]);
```

**After:**
```php
$info = NetworkHelper::getAllAsObject();
return $this->json($info); // Uses JsonSerializable
```

### Example 4: Twig Templates

**Before:**
```twig
{% set info = getAll() %}
<p>IP: {{ info.ip }}</p>
<p>Location: {{ info.city }}, {{ info.country }}</p>
```

**After:**
```twig
{% set info = getAllAsObject() %}
<p>IP: {{ info.ip }}</p>
<p>Location: {{ info.city }}, {{ info.country }}</p>
{% if info.hasLocation() %}
    <p>Geolocation available</p>
{% endif %}
```

## Benefits of NetworkInfo DTO

### Type Safety

**Array-based (old):**
```php
$info = NetworkHelper::getAll();
// PHPStan cannot help with this typo:
echo $info['cuntry']; // Runtime error - undefined key
```

**DTO-based (new):**
```php
$info = NetworkHelper::getAllAsObject();
// PHPStan catches this at development time:
echo $info->cuntry; // Static analysis error - property does not exist
```

### Immutability

NetworkInfo uses `readonly` properties, preventing accidental modifications:

```php
$info = NetworkHelper::getAllAsObject();
$info->ip = '1.1.1.1'; // ❌ Fatal error - cannot modify readonly property
```

This makes your code more predictable and thread-safe.

### Documentation

Properties are self-documenting through type hints:

```php
// IDE shows exact types when you hover over properties
$info->ip;        // ?string
$info->country;   // string
$info->city;      // string
$info->userAgent; // ?string
$info->referer;   // ?string
```

## Testing

Both methods work in your test environment:

```php
use Svc\UtilBundle\Service\NetworkHelper;

// Old method (deprecated but still works)
$data = NetworkHelper::getAll();
$this->assertArrayHasKey('ip', $data);

// New method (recommended)
$info = NetworkHelper::getAllAsObject();
$this->assertInstanceOf(NetworkInfo::class, $info);
$this->assertNull($info->ip); // null in test environment
```

## Deprecation Timeline

| Version | Status |
|---------|--------|
| 8.4 | `getAll()` deprecated, `getAllAsObject()` introduced |
| 8.x | Both methods available (deprecation warnings in logs) |
| 9.0 | `getAll()` will be removed (planned) |

**Recommendation:** Start migrating to `getAllAsObject()` now to avoid breaking changes in version 9.0.

## PHPStan Configuration

If you're using PHPStan and want to catch deprecated method usage:

```neon
# phpstan.neon
parameters:
    reportDeprecations: true
```

This will show warnings when you use `NetworkHelper::getAll()`.

## Migration Checklist

- [ ] Update to bundle version 8.4+
- [ ] Find all usages of `NetworkHelper::getAll()` in your codebase
- [ ] Replace with `NetworkHelper::getAllAsObject()`
- [ ] Update property access: `$data['ua']` → `$info->userAgent`
- [ ] Consider using helper methods (`hasLocation()`, `isLocalhost()`)
- [ ] Update tests if needed
- [ ] Run PHPStan to verify type safety
- [ ] Test in development environment

## Search & Replace Tips

Use these patterns to find usages in your codebase:

```bash
# Find all getAll() usages
grep -r "NetworkHelper::getAll()" src/

# Find all array access to 'ua'
grep -r "\['ua'\]" src/
```

## Need Help?

- NetworkInfo API: See `docs/networkhelper.md`
- Type safety with PHPStan: https://phpstan.org/
- File issues: https://github.com/Sven-Ve/svc-util-bundle/issues

## See Also

- `docs/networkhelper.md` - Complete NetworkHelper documentation
- `MIGRATION_TOAST_TO_POPOVER.md` - Toast notification migration
- `MIGRATION_SWEETALERT_TO_POPOVER.md` - Modal dialog migration
