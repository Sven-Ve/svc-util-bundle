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
  static values = { link: String, link1: String, link2: String, link3: String };

  connect() {
    if (navigator.clipboard) {
      this.element.classList.remove("d-none");
    }
  }

  copy() {
    this.updateClipboard(this.linkValue);
  }

  copy1() {
    this.updateClipboard(this.link1Value);
  }

  copy2() {
    this.updateClipboard(this.link2Value);
  }

  copy3() {
    this.updateClipboard(this.link3Value);
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
