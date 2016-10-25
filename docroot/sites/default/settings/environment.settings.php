<?php

/**
 * @file
 * Local development override configuration feature.
 */


// Environment specific settings that don't belong anywhere else.

// Environment_indicator settings
$config['environment_indicator_overwrite'] = TRUE;
$config['environment_indicator.indicator']['fg_color'] = '#ffffff';

if ($is_ah_env) {
  $config['environment_indicator.indicator']['name'] = ucfirst($_ENV['AH_SITE_ENVIRONMENT']);
}

if ($is_local_env) {
  $config['environment_indicator.indicator']['name'] = 'Local';
  $config['environment_indicator.indicator']['bg_color'] = '#3363aa';
}

if ($is_ah_dev_env){
  $config['environment_indicator.indicator']['bg_color'] = '#33aa3c';
}

if($is_ah_stage_env) {
  $config['environment_indicator.indicator']['bg_color'] = '#ffBB00';
}

if ($is_ah_prod_env) {
  $config['environment_indicator.indicator']['bg_color'] = '#aa3333';
}