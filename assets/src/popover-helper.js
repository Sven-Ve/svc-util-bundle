/*
 * This file is part of the svc/util-bundle.
 *
 * (c) Sven Vetter <dev@sv-systems.com>
 *
 * Popover Helper - Native browser popover replacement for SweetAlert2
 */

export class PopoverHelper {
  static idCounter = 0;

  // Icon mapping (Emoji-based)
  static icons = {
    success: '✅',
    error: '❌',
    warning: '⚠️',
    info: 'ℹ️',
    question: '❓'
  };

  /**
   * Show a modal dialog (replacement for Swal.fire with manual mode)
   */
  static fire(options = {}) {
    const {
      title = '',
      text = '',
      html = '',
      icon = null,
      showCancelButton = false,
      confirmButtonText = 'OK',
      cancelButtonText = 'Cancel',
      allowOutsideClick = true,
      timer = null,
    } = options;

    return new Promise((resolve) => {
      const popoverId = `svc-popover-${++this.idCounter}`;
      const popover = document.createElement('div');
      popover.id = popoverId;
      popover.setAttribute('popover', allowOutsideClick ? 'auto' : 'manual');
      popover.className = 'svc-popover-modal';

      // Build content
      let content = '';

      if (icon) {
        const iconEmoji = this.icons[icon] || icon;
        content += `<div class="svc-popover-icon svc-popover-icon-${icon}">${iconEmoji}</div>`;
      }

      if (title) {
        content += `<h2 class="svc-popover-title">${this.escapeHtml(title)}</h2>`;
      }

      if (html) {
        content += `<div class="svc-popover-content">${html}</div>`;
      } else if (text) {
        content += `<div class="svc-popover-content">${this.escapeHtml(text)}</div>`;
      }

      // Build buttons
      const buttons = [];
      if (showCancelButton) {
        buttons.push(`<button type="button" class="svc-popover-btn svc-popover-btn-cancel" data-action="cancel">${this.escapeHtml(cancelButtonText)}</button>`);
      }
      buttons.push(`<button type="button" class="svc-popover-btn svc-popover-btn-confirm" data-action="confirm">${this.escapeHtml(confirmButtonText)}</button>`);

      if (buttons.length > 0) {
        content += `<div class="svc-popover-actions">${buttons.join('')}</div>`;
      }

      popover.innerHTML = content;
      document.body.appendChild(popover);

      // Event handlers
      let resolved = false;
      const handleAction = (isConfirmed) => {
        if (resolved) return;
        resolved = true;

        popover.hidePopover();
        setTimeout(() => popover.remove(), 300); // Wait for animation
        resolve({ isConfirmed, isDismissed: !isConfirmed });
      };

      // Button clicks
      const confirmBtn = popover.querySelector('[data-action="confirm"]');
      const cancelBtn = popover.querySelector('[data-action="cancel"]');

      if (confirmBtn) {
        confirmBtn.addEventListener('click', () => handleAction(true));
      }
      if (cancelBtn) {
        cancelBtn.addEventListener('click', () => handleAction(false));
      }

      // Handle popover close (ESC, click outside for auto mode)
      popover.addEventListener('toggle', (e) => {
        if (e.newState === 'closed' && !resolved) {
          handleAction(false);
        }
      });

      // Auto-close with timer
      if (timer) {
        setTimeout(() => {
          if (!resolved) {
            handleAction(true);
          }
        }, timer);
      }

      // Show the popover
      popover.showPopover();

      // Focus first button
      setTimeout(() => {
        const firstBtn = confirmBtn || cancelBtn;
        if (firstBtn) firstBtn.focus();
      }, 100);
    });
  }

  /**
   * Show a toast notification (auto-dismiss with manual close option)
   */
  static showToast(message, icon = 'success', duration = 1500) {
    const popoverId = `svc-toast-${++this.idCounter}`;
    const toast = document.createElement('div');
    toast.id = popoverId;
    toast.setAttribute('popover', 'manual'); // Manual because we control closing
    toast.className = `svc-popover-toast svc-popover-toast-${icon}`;

    const iconEmoji = this.icons[icon] || icon;
    // Escape HTML first, then convert \n to <br> for safe multiline support
    const escapedMessage = this.escapeHtml(message).replace(/\n/g, '<br>');

    toast.innerHTML = `
      <span class="svc-popover-toast-icon">${iconEmoji}</span>
      <span class="svc-popover-toast-message">${escapedMessage}</span>
      <button type="button" class="svc-popover-toast-close" aria-label="Close">×</button>
    `;

    document.body.appendChild(toast);
    toast.showPopover();

    // Close button handler
    const closeBtn = toast.querySelector('.svc-popover-toast-close');
    const closeToast = () => {
      toast.hidePopover();
      setTimeout(() => toast.remove(), 300);
    };

    if (closeBtn) {
      closeBtn.addEventListener('click', closeToast);
    }

    // Auto-close
    const autoCloseTimer = setTimeout(closeToast, duration);

    // Store timer so it can be cancelled if manually closed
    toast.dataset.autoCloseTimer = autoCloseTimer;

    return toast;
  }

  /**
   * Escape HTML to prevent XSS
   */
  static escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }
}
