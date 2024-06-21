<?php

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
    return $this->render('@SvcUtil/envinfo/envinfo.html.twig', [
      'server' => $_SERVER,
      'symfonyversion' => Kernel::VERSION,
      'netInfo' => NetworkHelper::getAll(),
      'cacheDir' => $this->getParameter('kernel.cache_dir'),
    ]);
  }
}
