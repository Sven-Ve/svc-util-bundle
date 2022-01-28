import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["toggleBtn", "passwordFld"];
  static values = {
    showText: String,
    hideText: String
  }

  connect() {
    if (!this.hasToggleBtnTarget) {
      this.createToogleNode(this.passwordFldTarget);
    }
  }

  toogleVisibility() {
    var type;
    var text;
    if (this.passwordFldTarget.getAttribute('type') === 'password') {
      type = 'text';
      text = this.hideTextValue || 'Hide password';
    } else {
      type = 'password';
      text = this.showTextValue || 'Show password';
    }
    this.passwordFldTarget.setAttribute('type', type);
    this.toggleBtnTarget.classList.toggle('fa-eye-slash');
    this.toggleBtnTarget.title = text;
  }

  createToogleNode(parent) {
    var area = document.createElement("i");
    area.setAttribute('data-action', "click->svc--util-bundle--show-password#toogleVisibility");
    area.setAttribute('data-svc--util-bundle--show-password-target', "toggleBtn");
    area.className='fas fa-eye float-end';

    parent.parentNode.insertBefore(area, parent.nextSibling);
  }
}