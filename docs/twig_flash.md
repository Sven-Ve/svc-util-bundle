# Flash messages

display symfony flash messages via bootstrap toast (needs bootstrap... - and stimulus for the controller)

![flash message](images/flash_messages_via_toast.png "flash message")

## Usage

call the template in your base template (base.html.twig)

```twig
{% include '@SvcUtil/elements/_flashes.html.twig' %}
```