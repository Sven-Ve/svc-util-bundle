<?php

namespace Svc\UtilBundle\Service;

use Symfony\Component\Yaml\Yaml;

/**
 * Helper to check if it a bot.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class BotChecker
{

  private ?string $userAgent;

  private function getRegexesDirectory(): string
  {
    return (__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'regexes' . DIRECTORY_SEPARATOR;
  }

  private function matchUserAgent(string $regex): ?array
  {
    $matches = [];

    // only match if useragent begins with given regex or there is no letter before it
    $regex = '/(?:^|[^A-Z0-9_-]|[^A-Z0-9-]_|sprd-|MZ-)(?:' . \str_replace('/', '\/', $regex) . ')/i';

    try {
      if (\preg_match($regex, $this->userAgent, $matches)) {
        return $matches;
      }
    } catch (\Exception $exception) {
      throw new \Exception(
        \sprintf("%s\nRegex: %s", $exception->getMessage(), $regex),
        $exception->getCode(),
        $exception
      );
    }

    return null;
  }

  /**
   * Check, if a user agent a bot
   *
   * @param string|null $userAgent if null, the current user agent is used
   * @return array|null null means no bot, a array give information about the bot
   */
  public function getBot(?string $userAgent = null): array|null
  {
    if (!$userAgent) {
      $this->userAgent = NetworkHelper::getUserAgent();
    } else {
      $this->userAgent = $userAgent;
    }
    if (!$this->userAgent) {
      return null;
    }

    $yamlParser = new Yaml;
    $regexes = $yamlParser->parseFile($this->getRegexesDirectory() . 'bots.yml');

    foreach ($regexes as $regex) {
      $matches = $this->matchUserAgent($regex['regex']);

      if ($matches) {
        unset($regex['regex']);
        return $regex;
      }
    }

    return null;
  }
}
