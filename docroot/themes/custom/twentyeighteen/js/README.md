## Adding a Javascript file in Drupal

We have left out any default JavaScript files in Cog to eliminate any extraneous code when installing. In the code below, we will add the library reference and provide an example Javascript file (containing local closures around Drupal.behaviors) as a reference to add your first JS file to your them.

### Filename

`example.libraries.yml`

### File contents

```yaml
lib:
  version: VERSION
  js:
    js/theme.js: {}
  dependencies:
    - core/jquery
    - core/drupal
```

### Filename

`js/theme.js`

### File contents

```js
(function ($, Drupal, window, document) {
  'use strict';

  // Example of Drupal behavior loaded.
  Drupal.behaviors.themeJS = {
    attach: function (context, settings) {
      if (typeof context['location'] !== 'undefined') { // Only fire on document load.

        /* code goes here */

      }
    }
  };

})(jQuery, Drupal, this, this.document);
```
