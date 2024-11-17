# Une route, une classe

Les routes sont définies dans `routes.php`.
Oui, mais le code de chaque route devrait être ailleurs.
Dans un fichier qui lui est propre.

Dans un répertoire `src/Controller`, nous allons ajouter nos classes de contrôleurs.

Allons-y pour reprendre la route d'accueil avec `src/Controller/Home.php`.

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;

final class Home
{
    public function __invoke(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write('Hello world!');

        return $response;
    }
}
```

Nous pouvons corriger la définition de celle-ci dans `routes.php`.

```php
<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Controller\Home::class);
};
```

Simplement, si vous exécutez à nouveau votre page d'accueil dans le navigateur, 
une erreur de chargement !

Le répertoire `src` et le namespace `App` ne respectent pas psr-4.
Il faut créer un alias dans le fichier `composer.json`.

Pour cela ajouter sous la clé `require` : 

```json
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
```

Puis demander à composer d'en prendre connaissance : 

```shell
composer dumpautoload
```

Essayons de récupérer à nouveau un paramètre de route : 

Ajouter la définition

```php
$app->get('/{name}', \App\Controller\SayMyName::class);
```

Puis la classe

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SayMyName
{
    public function __invoke(ResponseInterface $response, string $name): ResponseInterface
    {
        $response->getBody()->write("Hello $name!");

        return $response;
    }
}
```

Mais pour que ça fonctionne, il faut corriger notre définition de l'app dans le container.

```php
$app = \DI\Bridge\Slim\Bridge::create($container);
```

C'est ce qui va permettre d'exploiter l'injection, Et de ne réclamer que le nécessaire dans les contrôleurs.

## Etape suivante :

Aller sur la branche `structure-code`
