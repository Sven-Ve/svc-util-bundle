import { Controller } from '@hotwired/stimulus';
import { PopoverHelper } from './popover-helper.js';

export default class extends Controller {
  static values = {
    message: String,
    icon: { type: String, default: 'info' },
    duration: { type: Number, default: 6000 }
  };

  connect() {
    // Get message from data attribute or element content
    const message = this.hasMessageValue ? this.messageValue : this.element.textContent.trim();

    // Show toast using PopoverHelper
    PopoverHelper.showToast(message, this.iconValue, this.durationValue);

    // Remove the original element from DOM since we've created a native toast
    this.element.remove();
  }
}