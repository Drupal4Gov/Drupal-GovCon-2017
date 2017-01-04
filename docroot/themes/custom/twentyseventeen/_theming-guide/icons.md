# Theming Guide: Icons

## SVG
Inline svg icons are colorable, scalable and easy to extend. This theme uses an
SVG sprite that is created by a gulp task. (See https://css-tricks.com/svg-sprites-use-better-icon-fonts/)

## How to add new icons
To add new icons, simply add the svg file to the /image directory and run the
gulp build task again. Make sure the svg does not have a fill color set in the
code if you want it to inherit the color of the parent element.

## Icon markup
See the styleguide for markup examples.
