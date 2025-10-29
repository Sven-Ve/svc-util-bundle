# Toggle Password

A form extension and Stimulus controller that adds show/hide toggle functionality to password fields.

## Features

- Adds a toggle button to password fields to switch between hidden and visible text
- Fully customizable labels, icons, and styling
- Built-in eye icons (open/closed) with support for custom icons
- Emits custom events for integration with other components
- Automatic Stimulus controller integration

## Installation

The toggle password functionality is automatically available after installing the bundle. No additional configuration is required.


## Basic Usage

To add a toggle button to a password field, simply set the `toggle` option to `true`:

```php
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

$builder->add('password', PasswordType::class, [
    'toggle' => true,
]);
```

This creates a password field with a "Show" button that toggles to "Hide" when clicked.

## Configuration Options

### Available Options

- **`toggle`** (bool, default: `false`): Enable/disable the toggle functionality
- **`visible_label`** (string, default: `'Show'`): Label text when password is hidden
- **`hidden_label`** (string, default: `'Hide'`): Label text when password is visible
- **`visible_icon`** (string, default: `'Default'`): Icon HTML when password is hidden
- **`hidden_icon`** (string, default: `'Default'`): Icon HTML when password is visible
- **`button_classes`** (array, default: `['toggle-password-button']`): CSS classes for the toggle button
- **`toggle_container_classes`** (array, default: `['toggle-password-container']`): CSS classes for the wrapper container
- **`use_toggle_form_theme`** (bool, default: `true`): Apply the form theme for proper rendering

### Custom Labels Example

```php
$builder->add('password', PasswordType::class, [
    'toggle' => true,
    'visible_label' => 'Reveal',
    'hidden_label' => 'Conceal',
]);
```

### Custom Icons Example

```php
$builder->add('password', PasswordType::class, [
    'toggle' => true,
    'visible_icon' => '<i class="fas fa-eye"></i>',
    'hidden_icon' => '<i class="fas fa-eye-slash"></i>',
]);
```

### Custom Button Styling Example

```php
$builder->add('password', PasswordType::class, [
    'toggle' => true,
    'button_classes' => ['btn', 'btn-sm', 'btn-link', 'my-custom-class'],
]);
```

## Form Theme

The bundle includes a form theme (`templates/form_theme.html.twig`) that wraps the password widget in a container with the configured CSS classes. This is automatically applied when `use_toggle_form_theme` is `true` (default).

To use the form theme globally, add it to your Twig configuration:

```yaml
# config/packages/twig.yaml
twig:
    form_themes:
        - '@SvcUtil/form_theme.html.twig'
```

## JavaScript Events

The Stimulus controller emits custom events that you can listen to:

### Event Types

- **`toggle-password:connect`**: Fired when the controller connects
  - `detail.element`: The password input element
  - `detail.button`: The toggle button element

- **`toggle-password:show`**: Fired when password becomes visible
  - `detail.element`: The password input element
  - `detail.button`: The toggle button element

- **`toggle-password:hide`**: Fired when password becomes hidden
  - `detail.element`: The password input element
  - `detail.button`: The toggle button element

### Listening to Events Example

```javascript
document.addEventListener('toggle-password:show', (event) => {
    console.log('Password is now visible', event.detail.element);
});

document.addEventListener('toggle-password:hide', (event) => {
    console.log('Password is now hidden', event.detail.element);
});
```

## Complete Example

```php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class, [
                'toggle' => true,
                'visible_label' => 'Show',
                'hidden_label' => 'Hide',
                'button_classes' => ['toggle-password-button', 'text-primary'],
            ])
            ->add('save', SubmitType::class);
    }
}
```

## Default Icons

The bundle includes built-in SVG eye icons:

- **Visible Icon** (eye open): Shows when password is hidden
- **Hidden Icon** (eye with slash): Shows when password is visible

To use custom icons, provide HTML strings (FontAwesome, Bootstrap Icons, etc.) to the `visible_icon` and `hidden_icon` options.

## Accessibility

- The toggle button has `tabindex="-1"` to prevent tab navigation (following common UX patterns)
- The button type is set to `button` to prevent form submission
- Screen readers will announce the button label changes when toggling

## Browser Compatibility

The toggle password functionality works in all modern browsers that support:
- ES6 JavaScript modules
- Stimulus framework
- CSS positioning (absolute/relative)

## Styling Customization

The default CSS classes are:

```css
.toggle-password-container {
    position: relative;
}

.toggle-password-button {
    position: absolute;
    right: 0.5rem;
    top: -1.25rem;
    /* Additional styling... */
}

.toggle-password-icon {
    height: 1rem;
    width: 1rem;
}
```

Override these classes in your own CSS or use the `button_classes` and `toggle_container_classes` options to apply custom classes.
