# Dependency Injection Container

Slim permet d'utiliser un container pour préparer, gérer et injecter les dépendances de l'application.

La librairie recommandée par Slim est php-di.

```shell
composer require php-di/php-di
```

Modifier l'index pour que l'application utilise le container.
```php
// Create Container using PHP-DI
$container = new Container();

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();
```

Les services sont à déclarer auprès du container.

```php
$container->set('toUpperService', function () {
    return new class(){
      public function toUpper($string) {
        return mb_strtoupper($string);
      }
    }
});
```

Une manière de l'utiliser dans un contrôleur 
```shell
$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $str = "Hello {$args['name']}!";

    if ($this->has('toUpperService')) {
        $toUpper = $this->get('toUpperService');
        $str = $toUpper->toUpper($str);
    }

    $response->getBody()->write($str);
    return $response;
});
```

Cependant, PHP-DI offre un bridge permettant l'autowiring.
C'est bien plus souple et permissif.

Nous pourrons déclarer plus clairement nos intentions au niveau de nos contrôleurs et services.

```shell
composer require php-di/slim-bridge
```

```php
$app = \DI\Bridge\Slim\Bridge::create($container);
```

Allez voir l'index pour comparer le code.
Les contrôleurs sont mieux isolés de l'application.
Peuvent eux-même être des services afin de bénéficier de l'injection de dépendance au constructeur.
Ils peuvent recevoir les parametres de requête, des placeholders de route et des services dans la méthode appelée.

## La fin du début

Slim, c'est ça.
Pour tout le reste, ce sera à vous de fournir un effort, ou d'utiliser des librairies.

Alors bien entendu, en l'état, ce n'est pas évident de concevoir une application qui devra vivre plusieurs années. C'est pourquoi nous allons commencer par bootstrapper le tout afin que ce soit paramétrable selon l'environnement, et réduire l'index au minimum, réograniser en plusieurs fichiers tout ce qui est nécessaire.

Puis nous verrons une stratégie d'organisation de notre code. 
Nous exposerons une resource d'API et augmenterons notre application à l'aide de middleware.
Et pour terminer, nous testerons et consoliderons notre code.

## Etape suivante :

Aller sur la branche `bootstrap`
