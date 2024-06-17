<?php

namespace Svc\UtilBundle\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SvcUtil-TableType1', '@SvcUtil/components/Table.html.twig')]
final class TableType1 extends Table
{
  public bool $hasHeader = true;
  public bool $isResponsive = true;
  public bool $isSmall = true;
  public bool $isStriped = true;
  public bool $isBordered = true;
}
