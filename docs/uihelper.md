# UIHelper

Helper class for User Interface utilities

## Signatures

```php
  /**
   * give a random rgb color
   *
   * @param int $minValue minimum RGB value (default: 10)
   * @param int $maxValue maximum RGB value (default: 250)
   * @return string RGB color string
   */
  public function getRandomColor(int $minValue = 10, int $maxValue = 250): string {}
```

## Usage

The UIHelper service can be injected into your controllers or services:

```php
use Svc\UtilBundle\Service\UIHelper;

class MyController extends AbstractController
{
    public function __construct(private UIHelper $uiHelper)
    {
    }
    
    public function myAction(): Response
    {
        // Generate a random color
        $randomColor = $this->uiHelper->getRandomColor();
        // Example output: "rgb(142,89,201)"
        
        // Generate a darker color (lower max value)
        $darkColor = $this->uiHelper->getRandomColor(10, 100);
        
        // Generate a brighter color (higher min value)  
        $brightColor = $this->uiHelper->getRandomColor(150, 250);
        
        return $this->render('template.html.twig', [
            'color' => $randomColor
        ]);
    }
}
```

## Use Cases

- Dynamic color generation for charts or UI elements
- Random background colors for user avatars
- Color-coding for different categories or items