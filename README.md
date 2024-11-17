# Environnement

Pour pouvoir obtenir des comportements adaptés à l'environnement,
nous allons charger des fichiers de clés de configurations à partir des variables d'environnement de la machine.

Encore une fois, créons un fichier `settings.php` pour déléguer ce comportement.

```php
<?php

// Detect environment
$_ENV['APP_ENV'] ??= $_SERVER['APP_ENV'] ?? 'dev';

// Load default settings
$settings = require __DIR__ . '/defaults.php';

// Overwrite default settings with environment specific local settings
$configFiles = [
    __DIR__ . sprintf('/local.%s.php', $_ENV['APP_ENV']),
    __DIR__ . '/env.php',
    __DIR__ . '/../../env.php',
];

foreach ($configFiles as $configFile) {
    if (!file_exists($configFile)) {
        continue;
    }

    $local = require $configFile;
    if (is_callable($local)) {
        $settings = $local($settings);
    }
}

return $settings;
```

Il faut maintenant le charger auprès du container.

```php
// container.php

return [
    // Application settings
    'settings' => fn () => require __DIR__ . '/settings.php',
    // ...
];
```

Vous l'avez remarqué, il faut, pour ce fichier `settings` il faut charger des valeurs nécessaires.
Un `defaults.php`. 
Ensuite, des valeurs nécessaires, mais pouvant s'adapter a l'environnement.
Enfin des valeurs pouvant être apportées par un développeur pour tester des choses.

Le fichier par défaut : 

```php
<?php

// Application default settings

// Error reporting
error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// Timezone
date_default_timezone_set('Europe/Paris');

$settings = [];

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,
];

return $settings;
```

Ensuite, puisque nous sommes en développement, un fichier `local.dev.php` pour cet environnement ! 

```php
<?php

// Dev environment

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    $settings['error']['display_error_details'] = true;

    return $settings;
};
```

C'est ce tableau `$settings` qui contiendra les clés de configuration de slim, mais aussi de toutes les autres librairies ou services que nous pourrions écrire contiendra.

## Etape suivante :

Aller sur la branche `class-route`
