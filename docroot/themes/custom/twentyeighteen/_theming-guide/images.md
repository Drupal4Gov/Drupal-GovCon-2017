# Theming Guide: Images in Drupal

* [Create Render Array for Original Image](#origrenderarray)
* [Create Render Array with Image Style](#stylerenderarray)
* [Create Image Object from URI](#imguri)
* [Return Image Information from File ID](#imgfiduri)
* [Compressing Images with Gulp](#gulpcompr)

<a name="origrenderarray"></a>
## Create Render Array for Original Image

Some situations will arise in which you will need to create an original version of an image to render in Twig. In the following example we will create a render array to render image within your template. 

### Filename

`example.theme`

### File contents

```php
use Drupal\file\Entity\File;

function EXAMPLE_preprocess_node(&$variables) {

  $fid = 1; // image file id
  $file_uri = File::load($fid)->getFileUri(); // original file uri
  $image = \Drupal::service('image.factory')->get($file_uri); // image.factory service to build object

  if ($image->isValid()) {
    $variables['original_image_render_array'] = [
      '#theme' => 'image',
      '#uri' => $image->getSource(),
      '#width' => $image->getWidth(),
      '#height' => $image->getHeight(),
      '#alt' => 'alt text',
      '#title' => 'title text',
      '#attributes' => [
        'class' => 'my-img-class'
      ]
    ];
  }

}
```

### Filename

`node.html.twig`

### File contents

```twig
<div> {{ original_image_render_array }} </div>
```

<a name="stylerenderarray"></a>
## Create Render Array with Image Style

There are common scenarios in which you will need to create alternate versions of an image to render in Twig. In the following example we will create a proper render array to print a thumbnail version of an image within your template. 

### Filename

`example.theme`

### File contents

```php
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

function EXAMPLE_preprocess_node(&$variables) {

  $fid = 1; // image file id
  $style = 'thumbnail'; // image style

  $thumb_style = ImageStyle::load($style); // image style configuration entity
  $file_uri = File::load($fid)->getFileUri(); // original file uri
  $image_uri = $thumb_style->buildUrl($file_uri); // original file uri
  $image = \Drupal::service('image.factory')->get($image_uri); // image.factory service to build object

  // Create render array with proper markup options.
  if ($image->isValid()) { 
    $variables['image_styled_render_array'] = [
      '#theme' => 'image',
      '#uri' => $image_uri,
      '#width' => $image->getWidth(),
      '#height' => $image->getHeight(),
      '#alt' => 'alt text',
      '#title' => 'title text',
      '#attributes' => [
        'id' => 'my-thumb-id',
        'class' => 'my-thumb-class'
      ]
    ];
  }

}
```

### Filename

`node.html.twig`

### File contents

```twig
<div> {{ image_styled_render_array }} </div>
```

<a name="imguri"></a>
## Create Image Object from URI

In scenarios in which will need to reference image properties from the URI, you can make use of the image.factory service. 

### Filename

`example.theme`

### File contents

```php
function EXAMPLE_preprocess_node(&$variables) {
  $img_uri = 'public://test/test-dog.jpg';
  $image_obj = \Drupal::service('image.factory')->get($img_uri);
}
```

<a name="imgfiduri"></a>
## Return Image Information from File ID

When you will need to retrieve the URI based on the `fid`, you can use the `File` class with the `getFileUri` function. Other useful utility functions are included in this class when needing file information from the `file_managed` table. 

### Filename

`example.theme`

### File contents

```php
use Drupal\file\Entity\File;

function EXAMPLE_preprocess_node(&$variables) { 

  file_uri  = File::load($fid)->getFileUri(); // uri
  filename  = File::load($fid)->getFilename(); // file name
  filesize  = File::load($fid)->getSize(); // file size
  fileowner = File::load($fid)->getOwner(); // file owner
  file_url_abs = File::load($fid)->url(); // get absolute path
  file_url_rel = file_url_transform_relative(file_url_abs); // get relative path
    
}

```

<a name="gulpcompr"></a>
## Compressing Images with Gulp

There are instances where your theme will use a good amount of images for common elements on your site. To assist with performance, we typically use the gulp-imagemin package to minify images. 

We start by creating 2 folders with our images folder: `images/src` which will contain the original images and `images/dist` which is designated to the compressed versions. 

In our package.json we include the new package dependency by adding `"gulp-imagemin": "3.1.x"` and updating with packages with `npm update`.

Now that the setup is complete, we can add a new Gulp task specifically for minifying our theme images with the following code: 

```js
var imagemin = require('gulp-imagemin');

gulp.task('imagemin', function () {
  debugger;
  return gulp.src('images/src/*.{gif,jpg,png}')
    .pipe(imagemin({
      progressive: true,
      interlaced: true
    }))
    .pipe(gulp.dest('images/dist'))
});
```

After you run the new image task with `gulp imagemin`, the images in `src/` will be compressed and copied to `dist/` as shown here: 

![normal](https://content.screencast.com/users/BedimStudios/folders/Jing/media/9664c1e6-fb09-4a91-8855-e9b84bedf819/00001982.png "") ![normal](https://content.screencast.com/users/BedimStudios/folders/Jing/media/a74122bb-44cb-4e17-9e5f-036a9db13a5d/00001983.png "")

---

## Additional References

* [Render Arrays in Drupal 8](https://www.drupal.org/docs/8/api/render-api/render-arrays)
* [GulpJS homepage](http://gulpjs.com/)
* [Image Min Gulp library](https://www.npmjs.com/package/gulp-imagemin)

