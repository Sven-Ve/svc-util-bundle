<?php

namespace Svc\UtilBundle\Service;

/**
 * Helper class for the UserInterface.
 *
 * @author Sven Vetter <dev@sv-systems.com>
 */
class UIHelper
{
  /**
   * give a random rgb column.
   */
  public function getRandomColor(int $minValue = 10, int $maxValue = 250): string
  {
    $red = random_int($minValue, $maxValue);
    $green = random_int($minValue, $maxValue);
    $blue = random_int($minValue, $maxValue);

    return "rgb($red,$green,$blue)";
  }
}
