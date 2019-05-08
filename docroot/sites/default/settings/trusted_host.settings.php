<?php


use Acquia\Blt\Robo\Common\EnvironmentDetector;

if (EnvironmentDetector::isAhEnv()) {
  if (EnvironmentDetector::isProdEnv()) {
    $settings['trusted_host_patterns'] = array(
      '^drupalgovcon\.org$',
      '^capitalcamp\.org$',
      '^www\.drupalgovcon\.org$',
      '^capitalcamp\.prod\.acquia-sites\.com$',

    );
  }
  elseif (EnvironmentDetector::isStageEnv()) {
    $settings['trusted_host_patterns'] = array(
      '^capitalcampstg\.prod\.acquia-sites\.com$',
    );
  }
  elseif (EnvironmentDetector::isDevEnv()) {
    $settings['trusted_host_patterns'] = array(
      '^capitalcampdev\.prod\.acquia-sites\.com$',
    );
  }
}