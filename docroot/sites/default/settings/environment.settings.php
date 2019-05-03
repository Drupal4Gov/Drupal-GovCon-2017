<?php

/**
 * @file
 * Local development override configuration feature.
 */

 use Acquia\Blt\Robo\Common\EnvironmentDetector;


// Environment specific settings that don't belong anywhere else.

// Environment_indicator settings
$config['environment_indicator_overwrite'] = TRUE;
$config['environment_indicator.indicator']['fg_color'] = '#ffffff';

if (EnvironmentDetector::isAhEnv()) {
  $config['environment_indicator.indicator']['name'] = ucfirst($_ENV['AH_SITE_ENVIRONMENT']);
}

if (EnvironmentDetector::isLocalEnv()) {
  $config['environment_indicator.indicator']['name'] = 'Local';
  $config['environment_indicator.indicator']['bg_color'] = '#3363aa';
}

if (EnvironmentDetector::isDevEnv()){
  $config['environment_indicator.indicator']['bg_color'] = '#33aa3c';
}

if(EnvironmentDetector::isStageEnv()) {
  $config['environment_indicator.indicator']['bg_color'] = '#ffBB00';
}

if (EnvironmentDetector::isProdEnv()) {
  $config['environment_indicator.indicator']['bg_color'] = '#aa3333';
}