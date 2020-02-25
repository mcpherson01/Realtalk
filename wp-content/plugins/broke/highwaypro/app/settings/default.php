<?php return array (
  'app' => 
  array (
    'id' => 'highwaypro',
    'shortId' => 'hwpro',
    'pluginFileName' => 'highwaypro',
  ),
  'schema' => 
  array (
    'applicationDatabase' => 'HighWayPro\\App\\Data\\Schema\\ApplicationDatabase',
  ),
  'directories' => 
  array (
    'app' => 
    array (
      'schema' => 'data/schema',
      'scripts' => 'scripts',
      'dashboard' => 'scripts/dashboard',
    ),
    'storage' => 
    array (
      'branding' => 'storage/branding',
    ),
  ),
  'environment' => 'production',
);