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
```