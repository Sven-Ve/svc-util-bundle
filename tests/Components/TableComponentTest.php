<?php

namespace Svc\ProfileBundle\Tests\Components;

use Svc\UtilBundle\Twig\Components\Table;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class TableComponentTest extends KernelTestCase
{
  use InteractsWithTwigComponents;

  public function testDefaultTable(): void
  {
    $component = $this->mountTwigComponent(
      name: Table::class
    );

    $this->assertInstanceOf(Table::class, $component);
    $this->assertTrue($component->hasHeader);
    $this->assertFalse($component->hasFooter);
    $this->assertNull($component->getStriped());
    $this->assertNull($component->getBordered());
    $this->assertNull($component->getDark());
  }

  public function testDefaultContent(): void
  {
    $rendered = $this->renderTwigComponent(
      name: Table::class,
    );

    $this->assertStringContainsString('<thead', $rendered);
    $this->assertStringContainsString('table-responsive', $rendered);
    $this->assertStringContainsString('table-hover', $rendered);
    $this->assertStringContainsString('table-light', $rendered);

    // use the crawler
    $this->assertCount(1, $rendered->crawler()->filter('table'));
    $this->assertCount(1, $rendered->crawler()->filter('div'));
  }

  public function testTableHeader(): void
  {
    $title = 'Test123';
    $rendered = $this->renderTwigComponent(
      name: Table::class,
      data: ['hasHeader' => true],
      blocks: ['header_row' => $title]
    );

    $this->assertStringContainsString('<thead', $rendered);
    $this->assertStringContainsString($title, $rendered);
  }
}
