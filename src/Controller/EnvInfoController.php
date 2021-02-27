<?php

namespace Svc\UtilBundle\Controller;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
#use Symfony\Component\Routing\Annotation\Route;


class EnvInfoController extends AbstractController
{

  public function info(): Response
  {
    return $this->render('@SvcUtil/envinfo/envinfo.html.twig', [
      'server' => $_SERVER,
      'symfonyversion' => Kernel::VERSION,
      'phpversion' => phpversion()
    ]);
  }


}
