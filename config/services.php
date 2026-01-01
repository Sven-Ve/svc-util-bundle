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
use Svc\UtilBundle\Form\Extension\TogglePasswordTypeExtension;
use Svc\UtilBundle\Service\EnvInfoHelper;
use Svc\UtilBundle\Service\MailerHelper;
use Svc\UtilBundle\Service\NetworkHelper;
use Svc\UtilBundle\Service\UIHelper;
use Svc\UtilBundle\Twig\Components\ModalDialog;
use Svc\UtilBundle\Twig\Components\Table;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->private();

    $services->set(NetworkHelper::class);
    $services->set(EnvInfoHelper::class);
    $services->set(MailerHelper::class)
        ->public();

    $services->set(UIHelper::class);
    $services->set(EnvInfoController::class);
    $services->set(ModalDialog::class);
    $services->set(Table::class);

    $services->set(TogglePasswordTypeExtension::class);
};
