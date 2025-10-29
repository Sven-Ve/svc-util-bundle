<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
