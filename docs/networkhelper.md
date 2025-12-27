# NetworkHelper

Helper class to give network information about clients.

## Important Security Notes

- **Geolocation API**: Uses HTTP (HTTPS requires paid API key at ip-api.com). Consider this for production use.
- **Rate Limiting**: Free tier allows 45 requests per minute from the same IP address.
- **IP Validation**: Public IP detection filters out private and reserved IP ranges for security.
- **External Dependency**: Location information depends on external service (ip-api.com) with 5-second timeout.

## Quick Start

### Recommended: Type-Safe Approach (v8.4+)

```php
use Svc\UtilBundle\Service\NetworkHelper;
use Svc\UtilBundle\Model\NetworkInfo;

// Get all client information as a type-safe object
$info = NetworkHelper::getAllAsObject();

// Access properties with full IDE support
echo $info->ip;        // ?string
echo $info->country;   // string
echo $info->city;      // string
echo $info->userAgent; // ?string
echo $info->referer;   // ?string

// Use helper methods
if ($info->hasLocation()) {
    echo "User from {$info->city}, {$info->country}";
}

if ($info->isLocalhost()) {
    echo "Development environment";
}
```

### Legacy: Array-Based Approach (Deprecated)

```php
// ⚠️ Deprecated since v8.4 - use getAllAsObject() instead
$info = NetworkHelper::getAll();
$ip = $info['ip'];
```

See [MIGRATION_NETWORKHELPER_GETALL.md](../MIGRATION_NETWORKHELPER_GETALL.md) for migration guide.

## NetworkInfo Value Object

The `NetworkInfo` class is a readonly value object introduced in version 8.4 that provides type-safe access to client network information.

### Properties

| Property | Type | Description |
|----------|------|-------------|
| `ip` | `?string` | Client IP address (null if not detected) |
| `country` | `string` | ISO country code (e.g., "CH", "US") - empty if unknown |
| `city` | `string` | City name - empty if unknown |
| `userAgent` | `?string` | User agent string (null if not available) |
| `referer` | `?string` | HTTP referer (null if not available) |

### Methods

#### `fromCurrentClient(): NetworkInfo`

Named constructor that creates a NetworkInfo instance from the current HTTP request.

```php
$info = NetworkInfo::fromCurrentClient();
// Equivalent to: NetworkHelper::getAllAsObject()
```

#### `hasLocation(): bool`

Check if location information (country or city) is available.

```php
$info = NetworkHelper::getAllAsObject();

if ($info->hasLocation()) {
    echo "Location: {$info->city}, {$info->country}";
} else {
    echo "Location unknown";
}
```

#### `isLocalhost(): bool`

Check if the IP address is localhost or a private/reserved IP range.

```php
$info = NetworkHelper::getAllAsObject();

if ($info->isLocalhost()) {
    // Development or local network
    echo "Private IP: {$info->ip}";
} else {
    // Public internet
    echo "Public IP: {$info->ip}";
}
```

#### `toArray(): array`

Convert to legacy array format for backward compatibility.

```php
$info = NetworkHelper::getAllAsObject();
$array = $info->toArray();

// Returns: ['ip' => ..., 'country' => ..., 'city' => ..., 'ua' => ..., 'referer' => ...]
```

#### `jsonSerialize(): array`

Serialize to JSON format (implements `JsonSerializable`).

```php
$info = NetworkHelper::getAllAsObject();
$json = json_encode($info);

// Returns: {"ip":"...","country":"...","city":"...","userAgent":"...","referer":"..."}
```

**Note**: Uses `userAgent` instead of `ua` for better API consistency.

## NetworkHelper Static Methods

### `getAllAsObject(): NetworkInfo`

**Recommended** - Returns all client information as a type-safe NetworkInfo object.

```php
$info = NetworkHelper::getAllAsObject();
echo $info->ip;
echo $info->country;
```

**Since**: v8.4

### `getAll(): array` (Deprecated)

**Deprecated** - Returns client information as an array.

```php
/**
 * @deprecated since 8.4, use getAllAsObject() instead
 * @return array{ip: ?string, country: string, city: string, ua: ?string, referer: ?string}
 */
public static function getAll(): array
```

**Migration**: Use `getAllAsObject()` instead. See [MIGRATION_NETWORKHELPER_GETALL.md](../MIGRATION_NETWORKHELPER_GETALL.md).

### `getIP(): ?string`

Get the client's IP address.

```php
$ip = NetworkHelper::getIP();

if ($ip) {
    echo "Client IP: {$ip}";
}
```

**Returns**: Client IP address or `null` if not detected.

**Detection Priority**:
1. `HTTP_CLIENT_IP`
2. `HTTP_X_FORWARDED_FOR` (first IP if comma-separated)
3. `REMOTE_ADDR`

**Security**: Validates IP format and excludes private/reserved ranges for public IP detection. Returns private IPs for local development.

### `getUserAgent(): ?string`

Get the client's user agent string.

```php
$ua = NetworkHelper::getUserAgent();

if ($ua) {
    echo "User Agent: {$ua}";
}
```

**Returns**: User agent string or `null` if not available.

### `getReferer(): ?string`

Get the HTTP referer (the page the user came from).

```php
$referer = NetworkHelper::getReferer();

if ($referer) {
    echo "Came from: {$referer}";
}
```

**Returns**: HTTP referer URL or `null` if not available.

### `getLocationInfoByIp(?string $ip = null): array`

Get location information (country and city) for a given IP address.

```php
// Get location for current client IP
$location = NetworkHelper::getLocationInfoByIp();

// Get location for specific IP
$location = NetworkHelper::getLocationInfoByIp('8.8.8.8');

echo $location['country']; // "US"
echo $location['city'];    // "Mountain View"
```

**Parameters**:
- `$ip` - IP address to lookup (uses current client IP if null)

**Returns**: Array with keys `country` (ISO code) and `city` (name). Both are empty strings if lookup fails.

**External API**: Uses ip-api.com with 5-second timeout and 45 requests/minute limit.

**Security**: Only works with public IPs (filters out private/reserved ranges).

## Usage Examples

### Example 1: Log Client Information

```php
use Svc\UtilBundle\Service\NetworkHelper;

$info = NetworkHelper::getAllAsObject();

$logger->info('User access', [
    'ip' => $info->ip,
    'location' => $info->hasLocation() ? "{$info->city}, {$info->country}" : 'unknown',
    'user_agent' => $info->userAgent,
]);
```

### Example 2: Geographic Content Restriction

```php
$info = NetworkHelper::getAllAsObject();

if ($info->country === 'US') {
    // Show US-specific content
} elseif (in_array($info->country, ['CH', 'DE', 'AT'])) {
    // Show DACH region content
}
```

### Example 3: Development vs Production Detection

```php
$info = NetworkHelper::getAllAsObject();

if ($info->isLocalhost()) {
    // Enable debug tools, verbose logging
    $this->enableDebugMode();
} else {
    // Production mode
    $this->enableCaching();
}
```

### Example 4: API Response

```php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Svc\UtilBundle\Service\NetworkHelper;

class ApiController extends AbstractController
{
    #[Route('/api/client-info', methods: ['GET'])]
    public function clientInfo(): JsonResponse
    {
        $info = NetworkHelper::getAllAsObject();

        // NetworkInfo implements JsonSerializable
        return $this->json($info);
    }
}
```

### Example 5: Rate Limiting by Location

```php
$info = NetworkHelper::getAllAsObject();

// Apply stricter rate limits for certain countries
if (in_array($info->country, ['CN', 'RU'])) {
    $rateLimiter->setLimit(10); // 10 requests/min
} else {
    $rateLimiter->setLimit(60); // 60 requests/min
}
```

### Example 6: Analytics Tracking

```php
$info = NetworkHelper::getAllAsObject();

$analytics->track('page_view', [
    'ip' => $info->ip,
    'country' => $info->country,
    'city' => $info->city,
    'is_localhost' => $info->isLocalhost(),
]);
```

## Testing

In test environments (where no HTTP request context exists), NetworkHelper returns safe defaults:

```php
$info = NetworkHelper::getAllAsObject();

// In tests:
$info->ip;        // null
$info->country;   // ""
$info->city;      // ""
$info->userAgent; // null
$info->referer;   // null

$info->hasLocation();  // false
$info->isLocalhost();  // false
```

You can mock NetworkInfo for testing:

```php
use Svc\UtilBundle\Model\NetworkInfo;

$mockInfo = new NetworkInfo(
    ip: '8.8.8.8',
    country: 'US',
    city: 'Mountain View',
    userAgent: 'PHPUnit Test',
    referer: null,
);

$this->assertTrue($mockInfo->hasLocation());
$this->assertFalse($mockInfo->isLocalhost());
```

## Type Safety with PHPStan

NetworkInfo works seamlessly with PHPStan for static analysis:

```php
$info = NetworkHelper::getAllAsObject();

// PHPStan knows exact types
echo $info->ip;        // ?string
echo $info->country;   // string

// PHPStan catches typos
echo $info->cuntry;    // ❌ PHPStan error: Property does not exist
```

Enable deprecation warnings in PHPStan:

```neon
# phpstan.neon
parameters:
    reportDeprecations: true
```

This will warn about usage of the deprecated `getAll()` method.

## Migration from v8.3 and Earlier

If you're using `NetworkHelper::getAll()` in your codebase, see the complete migration guide:

[MIGRATION_NETWORKHELPER_GETALL.md](../MIGRATION_NETWORKHELPER_GETALL.md)

**Quick migration:**

```php
// Before (v8.3)
$data = NetworkHelper::getAll();
$ip = $data['ip'];
$ua = $data['ua'];

// After (v8.4+)
$info = NetworkHelper::getAllAsObject();
$ip = $info->ip;
$ua = $info->userAgent; // Note: renamed from 'ua'
```