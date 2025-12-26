# NetworkHelper

Helper class to give network information

## Important Security Notes

- **Geolocation API**: Uses HTTP (HTTPS requires paid API key at ip-api.com). Consider this for production use.
- **Rate Limiting**: Free tier allows 45 requests per minute from the same IP address.
- **IP Validation**: Public IP detection filters out private and reserved IP ranges for security.
- **External Dependency**: Location information depends on external service (ip-api.com) with 5-second timeout.

## Signatures

```php
  /**
   * give client IP adress
   *
   * @return string|null
   */
  public static function getIP(): ?string {}

  /**
   * give client user agent
   *
   * @return string|null
   */
  public static function getUserAgent(): ?string {}
  
  /**
   * give client referer
   *
   * @return string|null
   */
  public static function getReferer(): ?string {}
  
  /**
   * give location info (country and city) based on IP
   * 
   * @param string $ip if null, use current IP
   * 
   * @return array ['country', 'city']
   */
  public static function getLocationInfoByIp($ip = null): array {}

  /**
   * give info about current client
   * 
   * @return array ['ip', 'country', 'city', 'ua', 'referer']
   */
  public static function getAll(): array {}
  ```