<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2026 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Svc\UtilBundle\Controller\EnvInfoController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('svc_envinfo_info', '/envinfo')
        ->controller([EnvInfoController::class, 'info']);
};
