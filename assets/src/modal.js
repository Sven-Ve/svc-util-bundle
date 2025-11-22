/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>
 *
 * Native Dialog Modal Controller - Replacement for Bootstrap Modal
 *
 * MIGRATION: This controller now uses native HTML <dialog> instead of Bootstrap Modal.
 * The API remains 100% compatible - no changes needed in your apps!
 *
 * Benefits:
 * - Zero dependencies (no Bootstrap JS needed)
 * - Smaller bundle size (~45KB saved)
 * - Better accessibility (WCAG 2.1 by default)
 * - Automatic backdrop, focus trap, ESC key handling
 * - Bootstrap 5.3+ dark mode support
 */

/*
 * OLD IMPLEMENTATION (Bootstrap Modal - BACKUP for reference):
 *
 * import { Controller } from '@hotwired/stimulus';
 * import { Modal } from 'bootstrap';
 *
 * export default class extends Controller {
 *   static values = {
 *     url: String,
 *     title: String
 *   }
 *
 *   show() {
 *     this.loadData(this.urlValue);
 *   }
 *
 *   async loadData(url) {
 *     let response;
 *     try {
 *       response = await fetch(url);
 *     } catch (err) {
 *       console.log(err.message);
 *       alert('Error during load. Please dry again.')
 *       location.reload();
 *       return;
 *     }
 *
 *     if (response.ok) {
 *       this.displayModal(await response.text());
 *     } else {
 *       alert('Error during load. Please dry again. (' + response.status + ')');
 *       location.reload();
 *     }
 *   }
 *
 *   displayModal(data) {
 *     var model = document.getElementById('svcModal')
 *     model.querySelector('.modal-details').innerHTML = data;
 *     if (this.titleValue) {
 *       model.querySelector('.modal-title').textContent = this.titleValue;
 *     }
 *     const myModal = new Modal(model);
 *     myModal.show();
 *   }
 *
 *   close() {
 *     if (document.body.classList.contains('modal-open')) {
 *       const modalEl = document.querySelector('.modal');
 *       const modal = Modal.getInstance(modalEl);
 *       modalEl.classList.remove('fade');
 *       modal._backdrop._config.isAnimated = false;
 *       modal.hide();
 *       modal.dispose();
 *     }
 *   }
 * }
 */

import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static values = {
    url: String,
    title: String,
    size: String,  // Optional: 'sm', 'lg', 'xl', 'fullscreen'
  }

  static idCounter = 0;

  show() {
    this.loadData(this.urlValue);
  }

  async loadData(url) {
    // Create native dialog element
    const dialogId = `svc-dialog-${++this.constructor.idCounter}`;
    const dialog = document.createElement('dialog');
    dialog.id = dialogId;
    dialog.className = 'svc-dialog';

    // Optional: Size support
    if (this.hasSizeValue && this.sizeValue) {
      dialog.classList.add(`svc-dialog-${this.sizeValue}`);
    }

    // Build dialog structure (Bootstrap-compatible)
    dialog.innerHTML = `
      <div class="svc-dialog-header">
        <h2 class="svc-dialog-title">${this.escapeHtml(this.titleValue || 'Dialog')}</h2>
        <button type="button" class="svc-dialog-close" aria-label="Close">&times;</button>
      </div>
      <div class="svc-dialog-body">
        <div class="svc-dialog-loading">
          <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Laden...</span>
          </div>
        </div>
      </div>
    `;

    document.body.appendChild(dialog);

    // Setup event handlers
    this.setupDialogHandlers(dialog);

    // Fetch content (same logic as before)
    let response;
    try {
      response = await fetch(url);
    } catch (err) {
      console.log(err.message);
      this.showError(dialog, 'Error during load. Please try again.');
      dialog.showModal();
      return;
    }

    if (response.ok) {
      const html = await response.text();
      const dialogBody = dialog.querySelector('.svc-dialog-body');
      dialogBody.innerHTML = html;
      dialog.showModal();

      // Make dialog body focusable if it has scrollable content
      if (dialogBody.scrollHeight > dialogBody.clientHeight) {
        dialogBody.setAttribute('tabindex', '0');
        dialogBody.focus();
      }
    } else {
      this.showError(dialog, `Error during load. Please try again. (${response.status})`);
      dialog.showModal();
    }
  }

  /**
   * Setup event handlers for the dialog
   *
   * Includes:
   * - Close button handler
   * - Backdrop click to close
   * - Scroll prevention: Prevents background page scrolling when dialog is open
   *   (arrow keys, space, home/end keys are blocked from scrolling the background)
   * - Cleanup on dialog close
   */
  setupDialogHandlers(dialog) {
    // Close button
    const closeBtn = dialog.querySelector('.svc-dialog-close');
    closeBtn.addEventListener('click', () => dialog.close());

    // Click outside to close (backdrop click)
    dialog.addEventListener('click', (e) => {
      if (e.target === dialog) {
        dialog.close();
      }
    });

    // Prevent background page scrolling when dialog is open
    // Store original overflow style
    const originalOverflow = document.body.style.overflow;

    // Prevent scroll on background
    document.body.style.overflow = 'hidden';

    // Cleanup on close
    dialog.addEventListener('close', () => {
      document.body.style.overflow = originalOverflow;
      setTimeout(() => dialog.remove(), 300); // Wait for animation
    });
  }

  showError(dialog, message) {
    dialog.querySelector('.svc-dialog-body').innerHTML = `
      <div class="alert alert-danger" role="alert">
        ${this.escapeHtml(message)}
      </div>
    `;
  }

  close() {
    // Turbo integration: Close all open dialogs
    const openDialogs = document.querySelectorAll('dialog.svc-dialog[open]');
    openDialogs.forEach(dialog => {
      dialog.close();
      dialog.remove();
    });
  }

  escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
}
