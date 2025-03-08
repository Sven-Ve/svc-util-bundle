<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SvcUtil-Table', '@SvcUtil/components/Table.html.twig')]
class Table
{
  public bool $hasHeader = true;

  public bool $hasFooter = false;

  public bool $isResponsive = true;

  public bool $isSmall = false;

  public bool $isStriped = false;

  public bool $isBordered = false;

  public bool $isDark = false;

  public function __construct(private readonly ?int $defaultTableType = null)
  {
    if ($this->defaultTableType === 1) {
      $this->hasHeader = true;
      $this->isSmall = true;
      $this->isStriped = true;
      $this->isBordered = true;
    }
  }

  public function getSmall(): ?string
  {
    return $this->isSmall ? 'table-sm ' : null;
  }

  public function getStriped(): ?string
  {
    return $this->isStriped ? 'table-striped ' : null;
  }

  public function getBordered(): ?string
  {
    return $this->isBordered ? 'table-bordered ' : null;
  }

  public function getDark(): ?string
  {
    return $this->isDark ? 'table-dark ' : null;
  }
}
