## Drupal & Markup
Consistent markup makes life easier. Just like building a site outside of Drupal, you want to reuse html elements appropriately for both semantics and consistency. Classes are provided by Drupal core and Drupal contrib modules. These can be used, removed or overridden as needed in your sub theme. The way that Drupal 8 controls markup is via [Twig](http://twig.sensiolabs.org/) templates. It is not necessary to edit these templates to use a Drupal theme, but they provide a great deal of power in customizing your site markup to do what you need.

### Example Drupal Twig template

#### Filename
`username.html.twig`

#### File contents
```twig
{% if link_path -%}
  <a{{ attributes.addClass(‘username’) }}>{{ name }}{{ extra }}</a>
{%- else -%}
  <span{{ attributes }}>{{ name }}{{ extra }}</span>
{%- endif -%}
```

### Overriding Twig templates
Your sub theme can override any template from the base theme, contrib modules or Drupal core. This is the overview of the process: locate the template, copy it into your sub theme, modify it, clear Drupal’s caches.

More detailed information can be found in the official Drupal documentation:
[Working with Twig Templates](https://www.drupal.org/node/2186401)
[Locating Template File with Debugging](https://www.drupal.org/node/2358785)