# Twig Components

The bundle provides Bootstrap-based Twig components using Symfony UX.

## Table Component

Bootstrap table component with configurable styling options.

### Usage

```twig
<twig:SvcUtil-Table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>John Doe</td>
            <td>john@example.com</td>
        </tr>
    </tbody>
</twig:SvcUtil-Table>
```

### Configuration Options

- `hasHeader` (bool): Show table header (default: true)
- `hasFooter` (bool): Show table footer (default: false)  
- `isResponsive` (bool): Make table responsive (default: true)
- `isSmall` (bool): Use smaller table styling (default: false)
- `isStriped` (bool): Use striped rows (default: false)
- `isBordered` (bool): Add borders (default: false)
- `isDark` (bool): Use dark theme (default: false)

### Bundle Configuration

You can set a default table type in your bundle configuration:

```yaml
# config/packages/svc_util.yaml
svc_util:
    twig_components:
        table_default_type: 1  # Enables small, striped, bordered styling
```

### Example with Options

```twig
<twig:SvcUtil-Table 
    :isSmall="true"
    :isStriped="true" 
    :isBordered="true"
>
    <!-- table content -->
</twig:SvcUtil-Table>
```

## Modal Dialog Component

Native `<dialog>` modal component for displaying static content.

**MIGRATED:** Now uses native HTML `<dialog>` instead of Bootstrap Modal. Zero dependencies, better accessibility.

**Note:** For dynamic content loaded via URL, use the `modal` Stimulus controller instead (see [stimulus-controllers.md](stimulus-controllers.md#modal)).

### Usage

**IMPORTANT:** The dialog requires an `id` attribute and you trigger it with `onclick`:

```twig
{# 1. Define the dialog with an ID #}
<twig:SvcUtil-ModalDialog title="Confirmation" modalSize="sm" id="confirmDialog">
    {% block content %}
        <p>Are you sure you want to proceed?</p>
    {% endblock %}
</twig:SvcUtil-ModalDialog>

{# 2. Add a trigger button #}
<button
    type="button"
    class="btn btn-primary"
    onclick="document.getElementById('confirmDialog').showModal()"
>
    Open Dialog
</button>
```

**Key Points:**
- ✅ **Must have `id`** - Required for `getElementById()`
- ✅ **Use `{% block content %}`** - Correct way to pass content
- ✅ **`onclick`** - Simplest trigger method
- ✅ **Close button included** - Automatic × button in header

### With Footer Buttons

```twig
<twig:SvcUtil-ModalDialog
    title="Edit Item"
    modalSize="lg"
    id="editDialog"
    :saveButton="true"
    saveButtonText="Save Changes"
>
    {% block content %}
        <form id="editForm">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name">
            </div>
        </form>
    {% endblock %}
</twig:SvcUtil-ModalDialog>

<button onclick="document.getElementById('editDialog').showModal()">
    Edit
</button>
```

### Configuration Options

- `title` (string): Modal title (default: 'Title')
- `modalSize` (string): Modal size - `sm`, `lg`, `xl`, `fullscreen`, or empty for default
- `saveButton` (bool): Show save button in footer (default: false)
- `saveButtonText` (string): Text for save button (default: 'Save changes')

### Modal Sizes

- `sm`: Small modal (300px max-width)
- Default: Standard modal (500px max-width)
- `lg`: Large modal (800px max-width)
- `xl`: Extra large modal (1140px max-width)
- `fullscreen`: Full viewport modal

### Triggering the Dialog

**Recommended - Direct JavaScript (simplest):**

```html
{# Open the dialog #}
<button onclick="document.getElementById('myDialog').showModal()">
    Open Dialog
</button>

{# Close from outside (optional, × button already included) #}
<button onclick="document.getElementById('myDialog').close()">
    Close Dialog
</button>
```

**Alternative - From JavaScript:**

```javascript
// Open
const dialog = document.getElementById('myDialog');
dialog.showModal();

// Close
dialog.close();
```

### Dark Mode Support

Automatically supports Bootstrap 5.3+ dark mode via `[data-bs-theme="dark"]` and system preference fallback.