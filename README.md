# Hello-world

Slim s'appuie sur le pattern front-controller.
Un seul fichier index, va recevoir toutes les requêtes et charger le code PHP dynamiquement.

Dans un répertoire public, créer un fichier `index.php`.

```php
<?php

// Déclarer les namespaces responsable des réponses et requêtes.
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// Déclarer le namespace de la classe qui peut fournir le noyau de slim
use Slim\Factory\AppFactory;

// Parce que nous utilisons composer, importer son autoload.
require __DIR__ . '/../vendor/autoload.php';

// Créer une instance de slim
$app = AppFactory::create();

// Ajouter une route pour laquelle Slim peut répondre.
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

// Exécuter l'application
$app->run();
```

Pour obtenir Hello world dans votre navigateur, il vous faudra un serveur.
Commençons par utiliser celui de PHP.

`php -S localhost:8000 -t public`

Zoomez sur le code de la définition de la route.
Un path, un callable qui reçoit la requête, une réponse (attention ces objets sont immutables) 
et doit renvoyer une réponse. C'est tout.

Ou presque.

```php
// Ajouter une route pour laquelle Slim peut répondre.
$app->get('/{name}', function (Request $request, Response $response, array $args) {
    // insérez le name dans la réponse à l'aide de $args
    $response->getBody()->write("Hello !");
    return $response;
});
```

## Etape suivante :

Aller sur la branche `middleware`
