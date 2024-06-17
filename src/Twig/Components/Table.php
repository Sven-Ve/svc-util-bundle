<?php

namespace Svc\UtilBundle\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SvcUtil-Table', '@SvcUtil/components/Table.html.twig')]
class Table
{
  public bool $hasHeader = true;
  public bool $isResponsive = true;
  public bool $isSmall = false;
  public bool $isStriped = false;
  public bool $isBordered = false;

  public function getSmall(): ?string {
    return $this->isSmall ? 'table-sm ' : null;
  }

  public function getStriped(): ?string {
    return $this->isStriped ? 'table-striped ' : null;
  }

  public function getBordered(): ?string {
    return $this->isBordered ? 'table-bordered ' : null;
  }
}
