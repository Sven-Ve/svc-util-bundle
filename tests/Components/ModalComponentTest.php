<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Components;

use Svc\UtilBundle\Twig\Components\ModalDialog;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

class ModalComponentTest extends KernelTestCase
{
  use InteractsWithTwigComponents;

  public function testModelMountSizeSm(): void
  {
    $component = $this->mountTwigComponent(
      name: ModalDialog::class,
      data: ['modalSize' => 'sm'],
    );

    $this->assertInstanceOf(ModalDialog::class, $component);
    $this->assertSame('modal-sm', $component->bsModalSize());
  }

  public function testModelMountSizeEmpty(): void
  {
    $component = $this->mountTwigComponent(
      name: ModalDialog::class,
    );

    $this->assertInstanceOf(ModalDialog::class, $component);
    $this->assertEmpty($component->bsModalSize());
  }

  public function testModelTitle(): void
  {
    $title = 'Test123';
    $rendered = $this->renderTwigComponent(
      name: ModalDialog::class,
      data: ['title' => $title],
    );

    $this->assertStringContainsString($title, $rendered);

    // use the crawler
    $this->assertCount(1, $rendered->crawler()->filter('h2'));
  }

  public function testModelSaveButtonExists(): void
  {
    $btnText = 'Test123';
    $rendered = $this->renderTwigComponent(
      name: ModalDialog::class, // can also use FQCN (MyComponent::class)
      data: ['saveButton' => true, 'saveButtonText' => $btnText],
    );

    $this->assertStringContainsString($btnText, $rendered);
  }

  public function testModelSaveButtonNotExists(): void
  {
    $btnText = 'Test123';
    $rendered = $this->renderTwigComponent(
      name: ModalDialog::class, // can also use FQCN (MyComponent::class)
      data: ['saveButton' => false, 'saveButtonText' => $btnText],
    );

    $this->assertStringNotContainsString($btnText, $rendered);
  }
}
