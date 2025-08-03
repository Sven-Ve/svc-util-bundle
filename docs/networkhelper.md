# NetworkHelper

Helper class to give network information

## Important Security Notes

- **Geolocation API**: Uses HTTP (not HTTPS) due to licensing limitations. Consider this for production use.
- **IP Validation**: Public IP detection filters out private and reserved IP ranges for security.
- **External Dependency**: Location information depends on external service (geoplugin.net) with 5-second timeout.

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