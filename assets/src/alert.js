import { Controller } from '@hotwired/stimulus';
import { PopoverHelper } from './popover-helper.js';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static values = {
    title: String,
    text: String,
    icon: String,
    confirmButtonText: String,
  }

  onSubmit(event) {
    event.preventDefault();

    PopoverHelper.fire({
      title: this.titleValue || null,
      text: this.textValue || null,
      icon: this.iconValue || 'error',
      showCancelButton: false,
      confirmButtonText: this.confirmButtonTextValue || 'OK',
      allowOutsideClick: false,
    });
  }
}
