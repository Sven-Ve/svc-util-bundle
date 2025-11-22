# Stimulus controllers

## alert

Display a simple alert dialog using the native Popover API (emoji icons: ✅ ❌ ⚠️ ℹ️ ❓).

_Example_
```html
<form {{ stimulus_controller('svc--util-bundle--alert', {
    'title': 'Success!',
    'text': 'Operation completed successfully.',
    'icon': 'success',
    'confirmButtonText': 'OK'
  }) }}
  data-action="submit->svc--util-bundle--alert#onSubmit"
>
  <button type="submit" class="btn btn-success">Show Alert</button>
</form>
```

**Parameters:**
* `title` (string, optional): Alert dialog title
* `text` (string, optional): Message text to display
* `icon` (string, optional): Icon type - `success`, `error`, `warning`, `info`, or `question`
* `confirmButtonText` (string, optional): Text for confirm button (default: 'OK')

## clipboard

Copy a text to the clipboard and show a toast notification.

_Example_
```html
<span class="d-none d-grid"
  {{ stimulus_controller('svc--util-bundle--clipboard', {
    'link': copyUrl
  } ) }}
>
  <button type="button" class="btn btn-warning btn-sm" data-action="svc--util-bundle--clipboard#copy" title='{% trans %}Copy link to clipboard{% endtrans %}'>{% trans %}Copy link{% endtrans %}</button>
</span>
```

**Parameters:**
* `link` (string, required): The text/URL to copy to clipboard

## mclipboard

Copy 1-4 texts to the clipboard with toast notifications (multiple copy actions with one controller instance).

_Example_
```html
<span class="d-none"
  {{ stimulus_controller('svc--util-bundle--mclipboard', {
    'link': url('svc_video_run', {id: video.id} ),
    'link1': url('svc_video_run_hn', {id: video.id} )
  } ) }}
>
  <div class="btn-group">
    <button type="button" class="btn btn-warning btn-sm" data-action="svc--util-bundle--mclipboard#copy" title='{% trans %}Copy link to clipboard{% endtrans %}'>{% trans %}Copy link{% endtrans %}</button>
    <button class="btn btn-warning dropdown-toggle dropdown-toggle-split btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
      <li><a class='dropdown-item' data-action="svc--util-bundle--mclipboard#copy1">{% trans %}without nav{% endtrans %}</a></li>
    </ul>
  </div>
</span>
```

**Parameters:**
* `link` (string, required): First text/URL to copy (action: `#copy`)
* `link1` (string, optional): Second text/URL to copy (action: `#copy1`)
* `link2` (string, optional): Third text/URL to copy (action: `#copy2`)
* `link3` (string, optional): Fourth text/URL to copy (action: `#copy3`)

## submit-confirm

Show a confirmation dialog before submitting a form using the native Popover API.

![submit-confirm dialog](images/submit-confirm.png "submit-confirm dialog")

_Example_
```html
<form method="post" action="{{ path('svc_video_group_delete', {'id': video_group.id}) }}"
  {{ stimulus_controller('svc--util-bundle--submit-confirm', {
    title: 'Remove this video group?' | trans,
    icon: 'warning',
    confirmButtonText: 'Yes, remove it' | trans,
    cancelButtonText: 'Cancel' | trans
  }) }}
  data-action="svc--util-bundle--submit-confirm#onSubmit"
>
```

**Parameters:**
* `title` (string, optional): Confirmation dialog title
* `text` (string, optional): Message text in the dialog body
* `html` (string, optional): HTML content (use instead of text for formatted content)
* `icon` (string, optional): Icon type - `success`, `error`, `warning`, `info`, or `question`
* `confirmButtonText` (string, optional): Text for confirm button (default: 'OK')
* `cancelButtonText` (string, optional): Text for cancel button (default: 'Cancel')

## reload-content

Reload content via AJAX or page reload. Shows error dialog with reload button if fetch fails.

_Example_
```html
<div {{ stimulus_controller('svc--util-bundle--reload-content', {
    'url': path('my_content_route'),
    'refreshAjax': true
  }) }}
  data-svc--util-bundle--reload-content-target="content"
>
  <!-- Content will be replaced here -->
</div>

<!-- Trigger reload from outside -->
<button data-action="click->svc--util-bundle--reload-content#refreshContent">
  Refresh Content
</button>
```

**Parameters:**
* `url` (string, required): URL to fetch content from
* `refreshAjax` (boolean, optional): If true, fetch via AJAX. If false, reload entire page (default: false)

**Targets:**
* `content` (optional): Element where fetched content will be inserted. If not specified, controller element is used.

**Custom Events:**
* Dispatch custom event with detail.url to override URL:
  ```javascript
  element.dispatchEvent(new CustomEvent('reload-content:refresh', {
    detail: { url: '/new/url' }
  }));
  ```

## modal

Show modal dialog with dynamically loaded content using native HTML `<dialog>` element.

**MIGRATED:** This controller now uses the native `<dialog>` element instead of Bootstrap Modal. The API remains 100% compatible - no changes needed in your code!

**Benefits:**
- ✅ Zero dependencies (no Bootstrap Modal JS needed, ~45KB saved)
- ✅ Better accessibility (WCAG 2.1 compliant by default)
- ✅ Native backdrop, focus trap, ESC key handling
- ✅ Bootstrap 5.3+ dark mode support
- ✅ Automatic cleanup on close

**Note:** The old Bootstrap templates (`@SvcUtil/elements/_modal.html.twig` and `SvcUtil-ModalDialog` component) are **no longer required**. The dialog is created dynamically by the controller.

_Example_
```html
<span
  data-controller="svc--util-bundle--modal"
  data-svc--util-bundle--modal-url-value="{{ path('my_content_route', {id: item.id}) }}"
  data-svc--util-bundle--modal-title-value="{% trans %}Item Details{% endtrans %}"
  data-action="click->svc--util-bundle--modal#show"
>
  <button type="button" class="btn btn-primary">Show Details</button>
</span>
```

**Parameters:**
* `url` (string, required): URL to fetch modal content from (HTML fragment)
* `title` (string, optional): Modal dialog title (default: 'Dialog')
* `size` (string, optional): Modal size - `sm`, `lg`, `xl`, or `fullscreen`

**Optional Size Example:**
```html
<span
  {{ stimulus_controller('svc--util-bundle--modal', {
    'url': path('my_content_route', {id: item.id}),
    'title': 'Large Dialog',
    'size': 'lg'
  }) }}
  data-action="click->svc--util-bundle--modal#show"
>
  <button type="button" class="btn btn-primary">Show Large Dialog</button>
</span>
```

**Server Response:** The URL should return an HTML fragment (not a full page) that will be inserted into the dialog body.

**Turbo Integration:** The controller automatically closes all open dialogs on `turbo:before-cache` events.