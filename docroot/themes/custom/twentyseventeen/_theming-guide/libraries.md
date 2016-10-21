## Libraries

### Adding in external css files thru theme library

```
// cog.libraries.yml
lib:
  css:
    theme:
      '//fonts.googleapis.com/css?family=Open+Sans:400,700,300|Signika:400,700': {}
```   
      

### Adding in external css files thru preprocess alterations 

```
/**
 * Implements hook_css_alter().
 */
function cog_css_alter(&$css) {
  // Add CDN Google fonts.
  $googlefonts = '//fonts.googleapis.com/css?family=Open+Sans:400,700,300|Signika:400,700';
  $css[$googlefonts] = array(
    'data' => $googlefonts,
    'type' => 'external',
    'every_page' => TRUE,
    'media' => 'all',
    'preprocess' => FALSE,
    'group' => CSS_AGGREGATE_THEME,
    'browsers' => array('IE' => TRUE, '!IE' => TRUE),
    'weight' => -2,
  );
}
```