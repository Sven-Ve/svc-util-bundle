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

namespace Svc\UtilBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TogglePasswordTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [PasswordType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'toggle' => false,
            'hidden_label' => 'Hide',
            'visible_label' => 'Show',
            'hidden_icon' => 'Default',
            'visible_icon' => 'Default',
            'button_classes' => ['toggle-password-button'],
            'toggle_container_classes' => ['toggle-password-container'],
            'use_toggle_form_theme' => true,
        ]);


        $resolver->setAllowedTypes('toggle', ['bool']);
        $resolver->setAllowedTypes('hidden_label', ['string', 'null']);
        $resolver->setAllowedTypes('visible_label', ['string', 'null']);
        $resolver->setAllowedTypes('hidden_icon', ['string', 'null']);
        $resolver->setAllowedTypes('visible_icon', ['string', 'null']);
        $resolver->setAllowedTypes('button_classes', ['string[]']);
        $resolver->setAllowedTypes('toggle_container_classes', ['string[]']);
        $resolver->setAllowedTypes('use_toggle_form_theme', ['bool']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['toggle'] = $options['toggle'];

        if (!$options['toggle']) {
            return;
        }

        if ($options['use_toggle_form_theme']) {
            array_splice($view->vars['block_prefixes'], -1, 0, 'toggle_password');
        }

        $controllerName = 'svc--util-bundle--toggle-password';
        $view->vars['attr']['data-controller'] = trim(\sprintf('%s %s', $view->vars['attr']['data-controller'] ?? '', $controllerName));


        $controllerValues['hidden-label'] = $options['hidden_label'];
        $controllerValues['visible-label'] = $options['visible_label'];

        $controllerValues['hidden-icon'] = $options['hidden_icon'];
        $controllerValues['visible-icon'] = $options['visible_icon'];
        $controllerValues['button-classes'] = json_encode($options['button_classes'], \JSON_THROW_ON_ERROR);

        foreach ($controllerValues as $name => $value) {
            $view->vars['attr'][\sprintf('data-%s-%s-value', $controllerName, $name)] = $value;
        }

        $view->vars['toggle_container_classes'] = $options['toggle_container_classes'];
    }
}
