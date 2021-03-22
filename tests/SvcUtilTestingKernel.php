<?php

namespace Svc\UtilBundle\Tests;

use Symfony\Component\HttpKernel\Kernel;
use Svc\UtilBundle\SvcUtilBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Test kernel
 */
class SvcUtilTestingKernel extends Kernel
{
    public function registerBundles()
    {
      return [
        new SvcUtilBundle(),
        new FrameworkBundle()
      ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}