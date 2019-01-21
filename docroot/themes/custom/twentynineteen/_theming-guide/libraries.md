# Theming Guide: Drupal 8 Libraries

* [Defining Local Libraries in Drupal 8](#locallibs)
* [Defining External Libraries in Drupal 8](#remotelibs)
* [Adding Library Dependencies](#dependencylibs)
* [Attaching Libraries within Twig files](#attachtwig)
* [Attaching Libraries within Preprocess Functions](#preprocesslibraries)
* [Replacing or Removing Libraries](#replaceremovelibs)

## Defining Local Libraries in Drupal 8
<a name="locallibs"></a>

A majority of themes start out with baseline CSS and JS files that are needed site-wide. In these cases, we declare and attach these local libraries within the theme.  

### Filename

`EXAMPLE.info.yml`

### File contents

```yaml
libraries:
  - EXAMPLE/global
```

### Filename

`EXAMPLE.libraries.yml`

### File contents

```yaml
global:
  css:
    theme:
      css/styles.css: {}
  js:
    theme:
      js/theme.js: {}
```

<a name="remotelibs"></a>
## Defining External Libraries in Drupal 8

When referencing external JS and CSS assets that are hosted outside the site, make sure to pass the `type: external` syntax within the `EXAMPLE.libraries.yml` libraries file. 

### Filename

`EXAMPLE.libraries.yml`

### File contents

```yaml
fonts:
  css:
    theme:
      '//fonts.googleapis.com/css?family=Open+Sans:400,700,300': {type: external}
```

<a name="dependencylibs"></a>
## Adding Library Dependencies

When utilizing common library dependencies, just reference within your `EXAMPLE.libraries.yml` file. In the following example, we will set both jQuery and Drupal Settings as dependencies.  

### Filename

`EXAMPLE.libraries.yml`

### File contents

```yaml
global:
  js:
    theme:
      js/theme.js: {}
    dependencies:
        - core/jquery
        - core/drupalSettings
```

<a name="attachtwig"></a>
## Attaching Libraries within Twig files 

There will be situations in which you will only want to attach libraries for certain markup. In this example we will utilize the new Drupal 8 function `attach_library()` to add a library within the node twig file. 

### Filename

`node.html.twig`

### File contents

```twig
{{ attach_library('example/example-library') }}
```

<a name="preprocesslibraries"></a>
### Attaching Libraries within Preprocess Functions 

You have the option to attach a library in the preprocess level for custom scenarios. In the following example we will only attach the library for article node pages. 

### Filename

`EXAMPLE.theme`

### File contents

```php
function EXAMPLE_preprocess_page(&$variables) {
  if($variables['node']->getType() == 'article'){
    $variables['#attached']['library'][] = 'articlelib/article-library';
  } 
} 
```

<a name="replaceremovelibs"></a>
## Replacing or Removing Libraries 

Situations will arise when you need to replace a library or remove it all together. In the following example we will show examples of both. 

### Filename

`EXAMPLE.info.yml`

### File contents

```yaml
libraries-override:
  classy/messages:  # replace
    example/messages
  classy/file: false # remove
```

---

## Additional References

* [Adding stylesheets (CSS) and JavaScript (JS) to a Drupal 8 theme](https://www.drupal.org/docs/8/theming-drupal-8/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-theme)
* [Defining a theme with an .info.yml file](https://www.drupal.org/node/2349827)
