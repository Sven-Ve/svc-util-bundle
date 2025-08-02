<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Controller;

// use App\Kernel;
use Svc\UtilBundle\Service\NetworkHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;

class EnvInfoController extends AbstractController
{
    public function info(): Response
    {
        // Whitelist of safe $_SERVER variables to prevent information disclosure
        $safeServerVars = [
            'DOCUMENT_ROOT',
            'SERVER_SIGNATURE',
            'SERVER_SOFTWARE',
            'SERVER_ADMIN',
            'APP_ENV',
            'SYMFONY_DOTENV_VARS',
            'APP_LOG_DIR',
            'APP_CACHE_DIR',
            'APP_DEBUG',
        ];

        $filteredServer = [];
        foreach ($safeServerVars as $key) {
            if (isset($_SERVER[$key])) {
                // Sanitize values to prevent XSS
                $value = $_SERVER[$key];
                if (is_string($value)) {
                    $filteredServer[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                } else {
                    $filteredServer[$key] = $value;
                }
            }
        }

        return $this->render('@SvcUtil/envinfo/envinfo.html.twig', [
            'server' => $filteredServer,
            'symfonyversion' => Kernel::VERSION,
            'netInfo' => NetworkHelper::getAll(),
            'cacheDir' => $this->getParameter('kernel.cache_dir'),
        ]);
    }
}
