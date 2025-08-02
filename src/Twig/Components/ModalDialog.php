<?php

/*
 * This file is part of the svc/util-bundle.
 *
 * (c) 2025 Sven Vetter <dev@sv-systems.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Svc\UtilBundle\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SvcUtil-ModalDialog', '@SvcUtil/components/ModalDialog.html.twig')]
final class ModalDialog
{
    public bool $saveButton = false;

    public string $saveButtonText = 'Save changes';

    public string $title = 'Title';

    private string $intModalSize = '';

    public function mount(string $modalSize = '')
    {
        $this->intModalSize = $modalSize;
    }

    public function bsModalSize()
    {
        if (!$this->intModalSize) {
            return '';
        }

        return 'modal-' . $this->intModalSize;
    }
}
