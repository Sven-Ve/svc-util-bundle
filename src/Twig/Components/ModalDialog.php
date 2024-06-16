<?php

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
