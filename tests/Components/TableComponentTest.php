<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Tests\Components;

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

        $this->assertStringContainsString('<thead', (string) $rendered);
        $this->assertStringContainsString('table-responsive', (string) $rendered);
        $this->assertStringContainsString('table-hover', (string) $rendered);

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

        $this->assertStringContainsString('<thead', (string) $rendered);
        $this->assertStringContainsString($title, (string) $rendered);
    }
}
