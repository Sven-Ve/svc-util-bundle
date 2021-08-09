import { Controller } from 'stimulus';
import Swal from 'sweetalert2';

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

    Swal.fire({
      title: this.titleValue || null,
      text: this.textValue || null,
      icon: this.iconValue || 'error',
      showCancelButton: false,
      confirmButtonText: this.confirmButtonTextValue || 'OK',
      allowOutsideClick: false,
    })
  }
}