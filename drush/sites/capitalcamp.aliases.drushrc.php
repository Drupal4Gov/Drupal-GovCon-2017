<?php

//if (!isset($drush_major_version)) {
//  $drush_version_components = explode('.', DRUSH_VERSION);
//  $drush_major_version = $drush_version_components[0];
//}
// Site capitalcamp, environment dev
$aliases['dev'] = array(
  'root' => '/var/www/html/capitalcamp.dev/docroot',
  'ac-site' => 'capitalcamp',
  'ac-env' => 'dev',
  'ac-realm' => 'prod',
  'uri' => 'capitalcampdev.prod.acquia-sites.com',
  'remote-host' => 'staging-7801.prod.hosting.acquia.com',
  'remote-user' => 'capitalcamp.dev',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['dev.livedev'] = array(
  'parent' => '@capitalcamp.dev',
  'root' => '/mnt/gfs/capitalcamp.dev/livedev/docroot',
);

//if (!isset($drush_major_version)) {
//  $drush_version_components = explode('.', DRUSH_VERSION);
//  $drush_major_version = $drush_version_components[0];
//}
// Site capitalcamp, environment prod
$aliases['prod'] = array(
  'root' => '/var/www/html/capitalcamp.prod/docroot',
  'ac-site' => 'capitalcamp',
  'ac-env' => 'prod',
  'ac-realm' => 'prod',
  'uri' => 'capitalcamp.prod.acquia-sites.com',
  'remote-host' => 'ded-2297.prod.hosting.acquia.com',
  'remote-user' => 'capitalcamp.prod',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['prod.livedev'] = array(
  'parent' => '@capitalcamp.prod',
  'root' => '/mnt/gfs/capitalcamp.prod/livedev/docroot',
);

//if (!isset($drush_major_version)) {
//  $drush_version_components = explode('.', DRUSH_VERSION);
//  $drush_major_version = $drush_version_components[0];
//}
// Site capitalcamp, environment test
$aliases['test'] = array(
  'root' => '/var/www/html/capitalcamp.test/docroot',
  'ac-site' => 'capitalcamp',
  'ac-env' => 'test',
  'ac-realm' => 'prod',
  'uri' => 'capitalcampstg.prod.acquia-sites.com',
  'remote-host' => 'staging-7892.prod.hosting.acquia.com',
  'remote-user' => 'capitalcamp.test',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['test.livedev'] = array(
  'parent' => '@capitalcamp.test',
  'root' => '/mnt/gfs/capitalcamp.test/livedev/docroot',
);
