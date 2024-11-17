# Bootstrap

Tout mettre dans `index.php`, n'est pas une bonne idée.

Commençons par déléguer la création du Container et de l'App.
Créer un répertoire `config` et dedans, un fichier `bootstrap.php`

```php
<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

// Build DI container instance
$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/container.php')
    ->build();

// Create App instance
return $container->get(App::class);
```

De ce fait, la seule qui restera dans notre index sera : 

```php
<?php

(require __DIR__ . '/../config/bootstrap.php')->run();
```

Dans le fichier bootstrap, vous avez remarqué la définition provenant de `container.php`. 
Créons ce fichier.

```php
<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return [
    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        // Register routes
        (require __DIR__ . '/routes.php')($app);

        return $app;
    },
];
```

Ce tableau de configuration permet de nourrir le container et l'application en même temps.
A nouveau, pour ne pas se retrouver avec des fichiers trop importants au long terme, la configuration des routes dans un fichier `routes.php`.

Ce fichier contiendra, bien entendu les routes.

```php
<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', function (\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
};
```

## Etape suivante :

Aller sur la branche `environnement`
