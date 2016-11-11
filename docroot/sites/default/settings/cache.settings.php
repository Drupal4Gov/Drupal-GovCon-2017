<?php

/**
 * @file
 * Cache settings for the site.
 */
if ($is_ah_env) {
  $settings['cache']['default'] = 'cache.backend.memcache';
}
