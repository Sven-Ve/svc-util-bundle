<?php

declare(strict_types=1);

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2026 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Tests\Form\Extension;

use PHPUnit\Framework\TestCase;
use Svc\UtilBundle\Form\Extension\TogglePasswordTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * Testing the TogglePasswordTypeExtension class.
 */
final class TogglePasswordTypeExtensionTest extends TestCase
{
    private FormFactoryInterface $formFactory;

    protected function setUp(): void
    {
        $this->formFactory = Forms::createFormFactoryBuilder()
            ->addTypeExtension(new TogglePasswordTypeExtension())
            ->getFormFactory();
    }

    public function testExtensionIsRegistered(): void
    {
        $form = $this->formFactory->create(PasswordType::class);

        $this->assertInstanceOf(\Symfony\Component\Form\FormInterface::class, $form);
    }

    public function testDefaultOptions(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => false,
        ]);

        $view = $form->createView();

        $this->assertArrayHasKey('toggle', $view->vars);
        $this->assertFalse($view->vars['toggle']);
    }

    public function testToggleDisabledDoesNotAddAttributes(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => false,
        ]);

        $view = $form->createView();

        $this->assertFalse($view->vars['toggle']);
        $this->assertArrayNotHasKey('data-svc--util-bundle--toggle-password-hidden-label-value', $view->vars['attr']);
        $this->assertArrayNotHasKey('toggle_container_classes', $view->vars);
    }

    public function testToggleEnabled(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
        ]);

        $view = $form->createView();

        $this->assertTrue($view->vars['toggle']);
        $this->assertArrayHasKey('data-controller', $view->vars['attr']);
        $this->assertStringContainsString('svc--util-bundle--toggle-password', $view->vars['attr']['data-controller']);
    }

    public function testStimulusControllerAttributes(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'hidden_label' => 'Verbergen',
            'visible_label' => 'Anzeigen',
            'hidden_icon' => '<i class="fa fa-eye-slash"></i>',
            'visible_icon' => '<i class="fa fa-eye"></i>',
            'button_classes' => ['btn', 'btn-sm'],
        ]);

        $view = $form->createView();

        $this->assertArrayHasKey('data-svc--util-bundle--toggle-password-hidden-label-value', $view->vars['attr']);
        $this->assertEquals('Verbergen', $view->vars['attr']['data-svc--util-bundle--toggle-password-hidden-label-value']);

        $this->assertArrayHasKey('data-svc--util-bundle--toggle-password-visible-label-value', $view->vars['attr']);
        $this->assertEquals('Anzeigen', $view->vars['attr']['data-svc--util-bundle--toggle-password-visible-label-value']);

        $this->assertArrayHasKey('data-svc--util-bundle--toggle-password-hidden-icon-value', $view->vars['attr']);
        $this->assertEquals('<i class="fa fa-eye-slash"></i>', $view->vars['attr']['data-svc--util-bundle--toggle-password-hidden-icon-value']);

        $this->assertArrayHasKey('data-svc--util-bundle--toggle-password-visible-icon-value', $view->vars['attr']);
        $this->assertEquals('<i class="fa fa-eye"></i>', $view->vars['attr']['data-svc--util-bundle--toggle-password-visible-icon-value']);

        $this->assertArrayHasKey('data-svc--util-bundle--toggle-password-button-classes-value', $view->vars['attr']);
        $this->assertEquals('["btn","btn-sm"]', $view->vars['attr']['data-svc--util-bundle--toggle-password-button-classes-value']);
    }

    public function testToggleContainerClasses(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'toggle_container_classes' => ['custom-container', 'password-wrapper'],
        ]);

        $view = $form->createView();

        $this->assertArrayHasKey('toggle_container_classes', $view->vars);
        $this->assertEquals(['custom-container', 'password-wrapper'], $view->vars['toggle_container_classes']);
    }

    public function testBlockPrefixesWithFormTheme(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'use_toggle_form_theme' => true,
        ]);

        $view = $form->createView();

        $this->assertContains('toggle_password', $view->vars['block_prefixes']);
    }

    public function testBlockPrefixesWithoutFormTheme(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'use_toggle_form_theme' => false,
        ]);

        $view = $form->createView();

        $this->assertNotContains('toggle_password', $view->vars['block_prefixes']);
    }

    public function testExistingDataControllerIsPreserved(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'attr' => [
                'data-controller' => 'existing-controller',
            ],
        ]);

        $view = $form->createView();

        $this->assertStringContainsString('existing-controller', $view->vars['attr']['data-controller']);
        $this->assertStringContainsString('svc--util-bundle--toggle-password', $view->vars['attr']['data-controller']);
    }

    public function testDefaultLabels(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
        ]);

        $view = $form->createView();

        $this->assertEquals('Hide', $view->vars['attr']['data-svc--util-bundle--toggle-password-hidden-label-value']);
        $this->assertEquals('Show', $view->vars['attr']['data-svc--util-bundle--toggle-password-visible-label-value']);
    }

    public function testDefaultIcons(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
        ]);

        $view = $form->createView();

        $this->assertEquals('Default', $view->vars['attr']['data-svc--util-bundle--toggle-password-hidden-icon-value']);
        $this->assertEquals('Default', $view->vars['attr']['data-svc--util-bundle--toggle-password-visible-icon-value']);
    }

    public function testNullLabelsAreAllowed(): void
    {
        $form = $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'hidden_label' => null,
            'visible_label' => null,
        ]);

        $view = $form->createView();

        $this->assertNull($view->vars['attr']['data-svc--util-bundle--toggle-password-hidden-label-value']);
        $this->assertNull($view->vars['attr']['data-svc--util-bundle--toggle-password-visible-label-value']);
    }

    public function testInvalidToggleTypeThrowsException(): void
    {
        $this->expectException(InvalidOptionsException::class);

        $this->formFactory->create(PasswordType::class, null, [
            'toggle' => 'yes',
        ]);
    }

    public function testInvalidButtonClassesTypeThrowsException(): void
    {
        $this->expectException(InvalidOptionsException::class);

        $this->formFactory->create(PasswordType::class, null, [
            'toggle' => true,
            'button_classes' => 'btn btn-sm',
        ]);
    }

    public function testGetExtendedTypes(): void
    {
        $extension = new TogglePasswordTypeExtension();
        $extendedTypes = $extension->getExtendedTypes();

        $this->assertContains(PasswordType::class, iterator_to_array($extendedTypes));
    }
}
