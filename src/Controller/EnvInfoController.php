<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Controller;

use Psr\Cache\CacheItemPoolInterface;
use Svc\UtilBundle\Service\NetworkHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;

final class EnvInfoController extends AbstractController
{
    public function info(Request $request): Response
    {
        // Whitelist of safe $_SERVER variables to prevent information disclosure
        $safeServerVars = [
            'DOCUMENT_ROOT',
            'SERVER_SIGNATURE',
            'SERVER_SOFTWARE',
            'SERVER_ADMIN',
            'SYMFONY_DOTENV_VARS',
            'APP_LOG_DIR',
            'APP_CACHE_DIR',
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
            'projectRoot' => $this->getParameter('kernel.project_dir'),
            'logDir' => $this->getParameter('kernel.logs_dir'),
            'phpInfo' => $this->getPhpInfo(),
            'opcacheInfo' => $this->getOpcacheInfo(),
            'sslInfo' => $this->getSslInfo($request),
            'cacheInfo' => $this->getCacheInfo(),
            'debugInfo' => $this->getDebugInfo(),
        ]);
    }

    private function getPhpInfo(): array
    {
        return [
            'sapi' => php_sapi_name(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'timezone' => date_default_timezone_get(),
            'server_time' => date('Y-m-d H:i:s T'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];
    }

    private function getOpcacheInfo(): array
    {
        if (!extension_loaded('Zend OPcache')) {
            return ['status' => 'Not available'];
        }

        $status = opcache_get_status();
        if ($status === false) {
            return ['status' => 'Disabled'];
        }

        return [
            'status' => 'Enabled',
            'opcache_enabled' => $status['opcache_enabled'] ?? false,
            'cache_full' => $status['cache_full'] ?? false,
            'memory_usage' => $status['memory_usage'] ?? [],
            'opcache_statistics' => $status['opcache_statistics'] ?? [],
        ];
    }

    private function getSslInfo(Request $request): array
    {
        return [
            'is_secure' => $request->isSecure(),
            'scheme' => $request->getScheme(),
            'port' => $request->getPort(),
            'https_header' => $_SERVER['HTTPS'] ?? 'Not set',
        ];
    }

    private function getCacheInfo(): array
    {
        try {
            if (!$this->container->has('cache.app')) {
                return [
                    'status' => 'Not configured',
                    'type' => 'N/A',
                ];
            }

            $cache = $this->container->get('cache.app');
            if ($cache instanceof CacheItemPoolInterface) {
                $testKey = 'envinfo_test_' . time();
                $item = $cache->getItem($testKey);
                $item->set('test');
                $saved = $cache->save($item);
                if ($saved) {
                    $cache->deleteItem($testKey);
                }

                return [
                    'status' => $saved ? 'Working' : 'Failed to write',
                    'type' => get_class($cache),
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'Error: ' . $e->getMessage(),
                'type' => 'Unknown',
            ];
        }

        return [
            'status' => 'Not available',
            'type' => 'N/A',
        ];
    }

    private function getDebugInfo(): array
    {
        return [
            'debug_mode' => $this->getParameter('kernel.debug'),
            'environment' => $this->getParameter('kernel.environment'),
        ];
    }
}
