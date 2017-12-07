# Theming Guide: Twig in Drupal 8

The introduction of the Twig rendering engine in Drupal 8 offers a wide range of flexibility within templates. The core syntax is very similiar to most programming languages, with slight alterations based on context. Below are some code examples of common tasks when coding within Twig.

* [Twig Basics](#twigbasics)
* [Twig Comparison and Control Operators](#twigcompare)
* [Twig Functions and Filters](#twigfunc)
* [Enable Twig Debugging](#twigenabledebug)
* [Debugging Options in Twig](#twigdebug)

<a name="twigbasics"></a>
## Twig Basics

```twig
# print variable 
I am {{ hamburgers }}

# print hashed variable 
{{ content.body['#view_mode'] }}

# string together
{{ 'I am ' ~ var.something }}

# set a variable
{% set var = content.string %}

# set array
{% set myarray = {'acorn': 'awesome', 'tree': 'better'} %}
```

<a name="twigcompare"></a>
## Twig Comparison and Control Operators

```twig
# foreach loop for myarray
{% for arrayfor in myarray %} {% endfor %}

# or
{% if (a or b) %} {% endif %} 

# and
{% if (a and b) %} {% endif %} 

# if conditional
{% if myarray %} {% endif %}

# not empty 
{% if myarray is not empty %} {% endif %}

# isset 
{% if myarray is defined %} {% endif %}

# !isset
{% if myarray is not defined %} {% endif %}

# greater than 
{% if myarray.length > 0 %} {% endif %} 

# starts with 
{% if 'Fudge' starts with 'F' %} {% endif %}

# ends with 
{% if 'Funky' ends with 'y' %} {% endif %}

# contained within  
{{ 1 in [1, 2, 3] }}
{{ 'cd' in 'abcde' }}

# ternary 
{{ funky ? 'yes' : 'no' }} 

# regex 
{% if numbers matches '/^[\\d\\.]+$/' %} {% endif %}
```

<a name="twigfunc"></a>
## Twig Functions and Filters

```twig
# strip_tags
{{ myarray.acorn|striptags }} 

# translate 
{{ 'Hello, World|t }} 
{{ 'Hello @acorn'|t({ '@acorn': myarray.acorn }) }}

# Renderable arrays can be printed by default 
{% set numbers = [{'#markup': 'One'}, {'#markup':'Two'}, {'#other':'Three'}] %}
{{ numbers }} // prints 'OneTwo' 

# safe join 
{{ [1, 2, 3]|safe_join('|') }} is 1|2|3

# escape 
{{ user.username|escape }}

# filter proper class
<div class="icon-{{ item.title|clean_class }}" >

# filter proper id
<div id="icon-{{ item.title|clean_id }}" >

# title
{{ 'the apple is green'|title }}

# capitalize
{{ 'how are you'|capitalize }}

# lowercase
{{ 'HOWDY'|lower }}

# uppercase
{{ 'howdy'|upper }}

# without 
{{ content|without('links') }} // removes content.links

# date 
{% if date(user.created_at) < date() %} {% endif %} 

# default 
{{ var|default('var is not defined') }}

# length  
{% if users|length > 10 %} {% endif %}

# trim: whitespace or chars  
{{ '  I like Twig.'|trim('.') }}

# merge: add to array 
{% set values = values|merge(['cat', 'dog']) %} 

# nl2br converts to <br>
{{ "Let us have apples\nIt will be great"|nl2br }} 

# formatting numbers
{{ 9800.333|number_format(2, '.', ',') }}

# reverse
{{ '1234'|reverse }}

# round
{{ 23.535|round(1, 'floor') }}

# slice
{{ '12345'|slice(1, 2) }}  // 23

# sort an array 
{% users|sort %}
```

<a name="twigenabledebug"></a>
## Enable Twig Debugging

In order to enable Twig debugging you simply need to change a variable in the `sites/default/services.yml` file. If you have not created your `services.yml` yet, just copy and rename your  `default.services.yml` file. 

### Filename

`services.yml`

### File contents

```yaml
parameters:
  twig.config:
    debug: true
```

After you have enabled debugging, you will see similiar markup in your DOM.

```html
<!-- THEME DEBUG -->
<!-- THEME HOOK: 'node' -->
<!-- FILE NAME SUGGESTIONS:
   * node--view--frontpage--page-1.html.twig
   * node--view--frontpage.html.twig
   * node--1--teaser.html.twig
   * node--1.html.twig
   * node--article--teaser.html.twig
   * node--article.html.twig
   * node--teaser.html.twig
   x node.html.twig
```

<a name="twigdebug"></a>
### Debugging Options in Twig 

```twig
# using kint in twig file 
{{ kint(page.content) }}

# print variable
{{ dump(var) }}

# print all variables
{{ dump(_context) }}

# print only keys 
{{ dump(_context|keys) }}

# print formatted keys or value 
{% for key, value in _context %}
  <li>{{ key }}</li>
{% endfor %}
```

---

## Additional References
* [Comparison of PHPTemplate and Twig theming paradigms](https://www.drupal.org/node/1918824)
* [Working With Twig Templates](https://www.drupal.org/node/2186401)
* [Debugging Twig templates](https://www.drupal.org/node/1906392)
* [Filters - Modifying Variables In Twig Templates](https://www.drupal.org/node/2357633)
* [Functions - In Twig Templates](https://www.drupal.org/node/2486991)
* [Twig best practices - preprocess functions and templates](https://www.drupal.org/node/1920746)
* [Drupal-defined Twig Filters](https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Template%21TwigExtension.php/function/TwigExtension%3A%3AgetFilters/8)
