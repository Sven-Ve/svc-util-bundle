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

Bootstrap modal component for displaying content.

### Usage

```twig
<twig:SvcUtil-ModalDialog title="Confirmation" modalSize="sm">
    <p>Are you sure you want to proceed?</p>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Confirm</button>
    </div>
</twig:SvcUtil-ModalDialog>
```

### Configuration Options

- `title` (string): Modal title
- `modalSize` (string): Modal size ('sm', 'lg', 'xl', or empty for default)
- `saveButton` (bool): Show save button (default: true)

### Modal Sizes

- `sm`: Small modal
- Default: Standard size modal
- `lg`: Large modal
- `xl`: Extra large modal