<?php

// Application default settings

// Error reporting
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Timezone
date_default_timezone_set('Europe/Paris');

$settings = [
    'env' => $_ENV['APP_ENV']
];

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,
];

$settings['cache'] = [
    'cache_dir' => PROJECT_ROOT_DIR . '/var/cache',
];

$settings['cors'] = [
    'Origin' => '*',
    'Headers' => '*',
    'Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
];

return $settings;
