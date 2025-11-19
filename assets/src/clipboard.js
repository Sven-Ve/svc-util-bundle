/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>
 *
 */

import { Controller } from '@hotwired/stimulus';
import { PopoverHelper } from './popover-helper.js';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static values = { link: String };

  connect() {
    if (navigator.clipboard) {
      this.element.classList.remove("d-none");
    }
  }

  copy() {
    this.updateClipboard(this.linkValue);
  }

  updateClipboard(newClip) {
    try {
      navigator.clipboard.writeText(newClip).then(() => {
        PopoverHelper.showToast("Copied.", 'success', 1500);
      }, () => {
        this.displayError();
      });
    } catch (err) {
      this.displayError();
    }
  }

  displayError() {
    PopoverHelper.showToast("Copy failed", 'error', 1500);
  }
}
