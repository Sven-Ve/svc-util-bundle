/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>
 *
 * Native Dialog Modal Component Controller
 *
 * This controller is for the <twig:SvcUtil-ModalDialog> component with static content.
 * For dynamic content loaded via URL, use modal.js instead.
 *
 * The controller is attached directly to the <dialog> element.
 */

import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  connect() {
    // Controller is attached to the dialog element itself
  }

  show() {
    // Show the dialog (this.element is the <dialog>)
    this.element.showModal();
  }

  close() {
    // Close the dialog
    if (this.element.open) {
      this.element.close();
    }
  }

  // Close all open dialogs (Turbo integration)
  closeAll() {
    const openDialogs = document.querySelectorAll('dialog.svc-dialog[open]');
    openDialogs.forEach(dialog => dialog.close());
  }
}
