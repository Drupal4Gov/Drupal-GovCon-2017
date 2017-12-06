# Theming Guide: Using Web Fonts in Drupal

* [Adding External Web Fonts in Drupal](#cdnfonts)
* [Adding Local Web Fonts in Drupal](#localfonts)

<a name="cdnfonts"></a>
## Adding External Web Fonts in Drupal

Most popular web font stacks can be included with minimal effort, especially when loading from an external source. In this example we will load a Google font into our theme thru the libraries file. 

### Filename

`example.libraries.yml`

### File contents

```yaml
fonts:
  version: VERSION
    example:
      '//fonts.googleapis.com/css?family=Open+Sans:400,700,300': { type: external}
```

<a name="localfonts"></a>
## Adding Local Web Fonts in Drupal

When implementing local web fonts, you can reference a local CSS within your libraries file to isolate the font import. After adding to the theme libraries file, we recommend using the `@font-face` rule to accomplish this. The below example shows broader coverage for each browser, but this can be trimmed based on the available font library. 

### Filename

`example.libraries.yml`

### File contents

```yaml
fonts:
  version: VERSION
    example:
      fonts/example.css: {} # local font
```

### Filename

`fonts/example.css`

### File contents

```scss
@font-face {
  font-family: 'Klavika Light Condensed';
  src: url('../fonts/Klavika-LightCondensed.eot');
  src: url('../fonts/Klavika-LightCondensed.eot?#iefix') format('embedded-opentype'),
  url('../fonts/Klavika-LightCondensed.woff') format('woff'),
  url('../fonts/Klavika-LightCondensed.ttf') format('truetype');
  font-weight: 300;
  font-style: normal;
}
```

---

## Additional References
* [Adding stylesheets (CSS) and JavaScript (JS) to a Drupal 8 theme](https://www.drupal.org/docs/8/theming-drupal-8/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-theme)
* [MDN @font-face](https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face)
* [Using @font-face CSS Tricks](https://www.drupal.org/docs/8/theming)
