import { Controller } from '@hotwired/stimulus';
import { PopoverHelper } from './popover-helper.js';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static values = {
    title: String,
    text: String,
    icon: String,
    confirmButtonText: String,
    cancelButtonText: String,
  }

  onSubmit(event) {
    event.preventDefault();

    PopoverHelper.fire({
      title: this.titleValue || null,
      text: this.textValue || null,
      icon: this.iconValue || null,
      showCancelButton: true,
      confirmButtonText: this.confirmButtonTextValue || 'Yes',
      cancelButtonText: this.cancelButtonTextValue || 'Cancel',
      allowOutsideClick: false,
    }).then((result) => {
      if (result.isConfirmed) {
        this.element.submit();
      }
    });
  }
}
