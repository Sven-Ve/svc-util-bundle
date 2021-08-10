import { Controller } from 'stimulus';
import Swal from 'sweetalert2';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ['content'];
  static values = {
    url: String,
    refreshAjax: Boolean
  }

  async refreshContent(event) {
    var url = this.urlValue;
    if (event.detail.url) {
      url = event.detail.url;
    }

    if (this.refreshAjaxValue) {
      const target = this.hasContentTarget ? this.contentTarget : this.element;
      target.style.opacity = .5;

      var response;
      try {
        response = await fetch(url);
      }
      catch(err) {
        this.handleError(err.message);
        return;
      }

      if (response.ok) {
        target.innerHTML = await response.text();
        target.style.opacity = 1;
      } else {
        this.handleError(response.status);
      }
    } else {
      location.reload();
    }
  }

  handleError(error) {
    Swal.fire({
      title: "Error",
      html: '<strong>Cannot load page</strong><br /><br />Please try reload it.<br /><br /><small>error: "' + error + '"</small>',
      icon: 'error',
      showCancelButton: false,
      confirmButtonText: 'Reload',
      allowOutsideClick: false,
    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    })
  }
}
