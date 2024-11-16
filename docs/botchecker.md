# NetworkHelper

Helper class to give information, if a User Agent a bot

## Signatures

```php
  /**
   * Check, if a user agent a bot
   *
   * @param string|null $userAgent if null, the current user agent is used
   * @return array|null null means no bot, a array give information about the bot
   */
  public function getBot(?string $userAgent = null): array|null
  ```

  ## Result array if a bot found
```php
array:4 [▼
  "name" => "Googlebot"
  "category" => "Search bot"
  "url" => "https://developers.google.com/search/docs/crawling-indexing/overview-google-crawlers"
  "producer" => array:2 [▼
    "name" => "Google Inc."
    "url" => "https://www.google.com/"
  ]
]
```
