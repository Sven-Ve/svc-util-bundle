import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static values = {
    url: String,
    title: String
  }

  show() {
    this.loadData(this.urlValue);
  }

  async loadData(url) {

    var response;
    try {
      response = await fetch(url);
    } catch (err) {
      console.log(err.message);
      alert('Error during load. Please dry again.')
      location.reload();
      return;
    }

    if (response.ok) {
      this.displayModal(await response.text());

    } else {
      alert('Error during load. Please dry again. (' + response.status + ')');
      location.reload();
    }
  }

  displayModal(data) {
    var model = document.getElementById('svcModal')
    model.querySelector('.modal-details').innerHTML = data;
    if (this.titleValue) {
      model.querySelector('.modal-title').textContent = this.titleValue;
    }

    var myModal = new Modal(model);
    myModal.show();
  }

}