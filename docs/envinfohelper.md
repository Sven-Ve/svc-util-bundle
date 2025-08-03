# EnvInfoHelper

Get information about the current environment

## Signatures

```php
 /**
   * give protocoll and servername
   *
   * @return string
   */
  public static function getRootURL(): string {}

  /**
   * give protokoll, servername and prefix (if server not installed in "/" )
   *
   * @return string
   */
  public static function getRootURLandPrefix(): string {}

  /**
   * URL to index.php
   *
   * @return string
   */
  public static function getURLtoIndexPhp(): string {} 

  /**
   * get the subdomain for a url or '' if no subdomain exists
   *
   * @param string|null $url if null the current host is used
   * @return string
   */
  public static function getSubDomain(?string $url = null): string {}
```