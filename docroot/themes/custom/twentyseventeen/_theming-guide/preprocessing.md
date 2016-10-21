# Theming Guide: Preprocessing

## TOC

- [Purpose](#purpose)
- [Custom Variables](#custom-variables)
- [Libraries](#libraries)
- [Common Variables](#common-variables)

## Purpose 
This document is a reference for techniques to customize theme templates, such as preprocessing, alter and render functions. 

## Custom Variables

### Creating and passing custom variables to twig 

The preprocess functions are essentially the same as D7, with just printing as a twig variable instead of PHP.  

```
// cog.theme
function cog_preprocess_node(&$variables) {
  $variables[‘custom_variable_node_id’] = ‘custom-var-‘ . $variables[‘node’]->nid->value;
}

// node.html.twig 
{{ custom_variable_node_id }}
```


### Creating variables based on user role

You can reference existing classes to create new classes for preprocess functions.

```
// cog.theme
function cog_preprocess_html(&$variables) {
  // Get current user.
  $user = \Drupal::currentUser();
  $roles = $user->getRoles();
  foreach ($roles as $role) {
    $variables['attributes']['class'][] = 'role-' . $role;
  } 
}
```


### Creating theme path variable to pass to twig 

Just like in D7, you can create new variables in the preprocess functions that will be rendered within the twig files. 

```
// cog.theme
function cog_preprocess_page(&$variables, $hook) {
  $variables[‘theme_path’] = drupal_get_path(‘theme’, ‘cog’);
}
```



## Common Variables

### Common variables available in html.html.twig 
```
{{ attributes }}  Attributes rendered on body tag 
{{ logged_in }}  If user is logged in
{{ is_admin }}  If user is admin
{{ directory }}  Theme directory path  
{{ root_path }}  The root path of the current page
{{ node_type }}  The content type for the current node
{{ css }}  A list of CSS files for the current page
{{ head }}  Markup for the HEAD element
{{ head_title }}  Page title for the TITLE tag
{{ styles }}  Style tags HEAD section.
{{ scripts }}  Script tags for javascript files in HEAD
{{ scripts_bottom }}  Script tags for javascript files in BODY 
{{ html_attributes }}  Attributes on the HTML tag 
{{ db_offline }}  If the database is offline
{{ db_is_active }}  DB is active
{{ dump(user) }}  User object reference 
```

#### Common variables available in page.html.twig 

```
{{ base_path }}  The base path of site 
{{ directory }}  Theme directory path 
{{ attributes }}  Attributes rendered on outside <div>
{{ title }}  Node title if applicable 
{{ front_page }}  Is front page 
{{ language }}  Language variable 
{{ logo }}  Theme logo 
{{ site_name }}  Site name
{{ site_slogan }}  Site slogan 
{{ logged_in }}  If user is logged in
{{ is_admin }}  If user is admin
{{ db_is_active }}  DB is active
{{ dump(page) }}  Page object to be rendered in properties i.e. page.header
{{ dump(user) }}  User object reference 
{{ dump(tabs) }}  Tab object reference 
{{ dump(node) }}  Node object reference 
```

#### Common variables available in node.html.twig 

```
{{ view_mode }}  View mode on nodes 
{{ teaser }}  Teaser content 
{{ node }}  Node object 
{{ date }}  Date information 
{{ author_name }}  Author name  
{{ url }}  Rendered URL information 
{{ content }}  Rendered content information 
{{ attributes }}  Attributes rendered on article tag
{{ directory }}  Theme directory path 
{{ logged_in }}  If user is logged in
{{ is_admin }}  If user is admin
{{ db_is_active }}  DB is active
```


