<?php

if ($is_ah_env) {
  if ($is_ah_prod_env) {
    $settings['trusted_host_patterns'] = array(
      '^drupalgovcon\.org$',
      '^capitalcamp\.org$',
    );
  }
  elseif ($is_ah_stage_env) {
    $settings['trusted_host_patterns'] = array(
      '^capitalcampstg\.prod\.acquia-sites\com$',
    );
  }
  elseif ($is_ah_dev_env) {
    $settings['trusted_host_patterns'] = array(
      '^capitalcampdev\.prod\.acquia-sites\com$',
    );
  }
}
