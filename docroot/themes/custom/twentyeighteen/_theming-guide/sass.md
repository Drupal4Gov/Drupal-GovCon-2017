# Theming Guide: Sass in Drupal

* [Sass Style Organization](#sassorg)
* [Component Rules with Media Queries](#componenmqs)
* [CSS Preprocessing](#csspreprocess)
* [Writing Effective Style Rules](#effectivestyles)
* [Media Queries Coding Techniques](#mqtechniques)

<a name="sassorg"></a>
## Sass Style Organization

This theme breaks down stylesheets according to the SMACSS-BEM methodology, similar to the core theme Classy. The following categories are broken down into actual folders that contain sass partials. Everything in these folders is compiled down to a single stylesheet that is loaded by the theme.

* **Base Rules:** Base styles for HTML elements and normalization rules
* **Layout Rules:** Styles setting up widths and placement of regions
* **Component Rules:** The majority of your rules. Should be in a partials directory. Partials should be semantically named for the component they apply to.
* **State Rules:** These are often utility styles applied or toggled by javascript. Quicktabs, collapsible sections, show/hide.
* **Theme Rules:** These are like skins that override specific sections.

\* The term ‘Component rules’ is a Drupal convention, in the SMACSS book they are called ‘Module rules’ but we use component to avoid confusion with Drupal modules. 

*With SMACSS, the intent is to keep the styles that pertain to a specific component with the rest of the component. That means that instead of having a single break point, either in a main CSS file or in a separate media query style sheet, place media queries around the component states.*

<a name="componenmqs"></a>
## Component Rules with Media Queries

**CSS Version**

```css
.summary {
  font-size: 18px;
}
@media screen and (min-width: 767px) {
  .summary {
    font-size: 20px;
  }
}
```

**SASS Version**

```scss
.summary {
  font-size: 18px;
  @media screen and (min-width: 767px) {
    font-size: 20px;
  }
}
```

<a name="csspreprocess"></a>
## CSS Preprocessing

CSS preprocessors allow themers to be more efficient when developing a sub theme. We prefer SASS, using scss syntax, and using Compass. These are the Zen 5 defaults and work well. We recommend using Compass for creating sprites for your site using two sprite directories, one for standard resolution, one for retina resolutions.

The majority of your scss files should be partials. These partials are then imported into a single scss file and compiled out as one file. For example:

```scss
@import "init";

/* SMACSS base rules */
@import "normalize";

/* Layout rules */
@import "layouts/responsive";

/* Component rules */
@import "components/misc";
@import "components/nav";
@import "components/header";
@import "components/footer";
```

<a name="effectivestyles"></a>
## Writing Effective Style Rules

When writing styles, the themer’s goal should be to write efficient CSS. This means using the least amount of selectors possible. The best performance in CSS is the ID, but this is often not a realistic selector to use because it limits it's reusability. The exceptions are for layout rules and unique rules for unique items, like the site-name. After that is the class selector, which should be the target of the majority of your rules. Though we write CSS left to right ( `#content .field-item p` ) a browser reads CSS right to left. So in the previous rule, it would first find every paragraph on the page. Then it invalidate the ones that aren’t inside a `.field-item` class. Then invalidate the remaining ones that aren’t inside of an element with the ID `#content`. When using a CSS Preprocessor, a lot of care needs to be taken in regards to selector depth. It’s extremely easy to nest selectors which will result in extremely inefficient styles.

Keep your styles generic when you can, think broad strokes. If you can, apply your style to `.field-item` instead of `.article .field-item`. Likewise, when you need to apply the style to a more limited scope, use the semantic class and not the drupal generic class. So, use `.view-articles` instead of simply `.view`.

**Example: You need to apply a style to an ul, li, and an a tag for a particular view of articles. You may be tempted to write SASS like this:**

```scss
.article-view {
  /* view styles */
  ul {
    /* ul styles */
    li {
      /* li styles */
      a {
        /* a styles */
      }
    }
  }
}
```

**The previous would compile to:**

```css
.article-view {/* view styles */}
.article-view ul {/* ul styles */}
.article-view ul li {/* li styles */}
.article-view ul li a {/* a styles */}
```

**A better way would be:**

```scss
.article-view {
  /* view styles */
  ul { */ ul styles */}
  li { /* li styles */}
  a {/* a styles */}
}
```

**Which compiles to:**

```css
.article-view {/* view styles */}
.article-view ul {/* ul styles */}
.article-view li {/* li styles */}
.article-view a {/* a styles */}
```

If you look at the first set (the bad one) in the previous example, the last rule requires the browser match 4 items. Since a browser reads right to left, this is extremely inefficient. Nested tags is the most expensive rule in regards to front-end performance. If the HTML tags have classes, like a typical drupal site would, the most efficient rule would use those.

For more information on CSS selector efficiency: https://developers.google.com/speed/docs/best-practices/rendering

If you find yourself fighting a module’s, or drupal core’s default stylesheet and need to remove it’s css file, you should use a hook_css_alter() to unset the file in template.php in your theme directory.

A great module that can be used to set up your theme’s generic styles is the style guide module ( https://drupal.org/project/styleguide ).

Though drupal.org style guidelines don’t consider css preprocessors very much, and some information seems outdated, the css guidelines are worth reading. https://drupal.org/node/1886770

<a name="mqtechniques"></a>
## Media Queries Coding Techniques

There are two ways to really build a responsive site. Which way you go, usually depends on the design provided, which determines the way you work and how you write your media queries.

**Mobile First:** When working mobile first, you should build from the smallest veiwport to the widest desktop. So when writing styles, the styles outside of a media query would work on all viewports and mobile viewports. Media queried rules would apply to larger viewports. Here are some sample media queries for mobile-first. Notice the use of min-width. Mobile only rule does use a max-width. This should be used in the case that the rule is **only mobile**.

```css
@media (max-width: 767px) {} /* mobile only */
@media (min-width: 768px) {} /* tablet and up */
@media (min-width: 768px) and (max-width: 959px) {} /* tablet only */
@media (min-width: 960px) {} /* desktop only */
```

**Desktop Down:** When working desktop down your rules outside of a media query should be for your desktop styles. Then you override them with media-queried rules for smaller viewports. Like with mobile-first, I do like to throw in a desktop only media query (it just makes life easier sometimes).

```css
@media (min-width: 960px) {} /* desktop only */
@media (max-width: 959px) {} /* tablet and down */
@media (max-width: 959px) and (min-width: 768px) {} /* tablet only */
@media (max-width: 767px) {} /* mobile only */
```

**Things to keep in mind**
- Design doesn't have to dictate methods, but it's often easier if you let it.
- All front-end developers need to be on the same page. Meaning, dev A can't work mobile first while dev B is doing desktop down.
- If developing with a mobile-first strategy, do it. Meaning, write styles and check in a browser at the smallest viewport before working your way up in regards to viewport size.
- A task isn't complete until all viewports are correct
- Sadly, regardless of how many breakpoints are defined by a designer, and the comps provided by the designer, unless design was done in a browser, there are going to be natural breaks in between breakpoints. Since the number and variety of devices continue to grow all the time, you usually can't ignore those. If you're defining your media queries or breakpoints as variables and/or using a mixin, I find it easier to handle one-offs as hand coded media queries because if you decide to adjust breakpoints globally, these rules generally aren't effected and you don't want them to change.

---

## Additional References

* [SMACSS Homepage](http://smacss.com/)
* [SMACSS in themes](http://www.acquia.com/blog/organize-your-styles-introduction-smacss)
* [Chrome - Optimize Browser Rendering](https://developers.google.com/speed/docs/best-practices/rendering)
* [Mozilla - Writing Efficient CSS](https://developer.mozilla.org/en-US/docs/Web/Guide/CSS/Writing_efficient_CSS)
* [CSS Architecture for Drupal 8](https://www.drupal.org/coding-standards/css/architecture)
* [Drupal 8 Theming Guide](https://www.drupal.org/theme-guide/8)
