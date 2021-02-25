<?php

namespace Svc\UtilBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SvcUtilBundle extends Bundle {

  public function getPath(): string
  {
      return \dirname(__DIR__);
  }
}