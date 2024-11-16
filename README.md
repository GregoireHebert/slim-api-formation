# Middleware

Slim intercepte la requête HTTP entrante, et avant de la donner a notre controlleur.
va lui faire parcourir des middlewares.

Un middleware est une fonction ou une classe à qui la requête est fournie, ainsi qu'un request handler.

Au choix, on peut détecter une situation et :
- modifier/augmenter la requete.
- obtenir la réponse des middlewares suivants et l'augmenter.
- court-circuiter les middlewares suivants et retourner une réponse directement.

Concrètement, de la logique bas niveau que l'on souhaite pour toutes les requêtes / réponses. 

```php
// A middleware can act then call the next one
$firstToBeCalledMiddleware = function (Request $request, RequestHandler $handler) use ($app) {
    // Example: Check for a specific header before proceeding
    // if the header is absent, reject by sending immediately a response 401.

    // Proceed with the next middleware
    return $handler->handle($request);
};

// A middleware can call the next one then act
$secondToBeCalledMiddleware = function (Request $request, RequestHandler $handler) {
    // Proceed with the next middleware
    $response = $handler->handle($request);
    
    // Modify the response after the application has processed the request
    $response = $response->withHeader('X-Added-Header', 'some-value');
    
    return $response;
};

// they are stacked in a LIFO.
$app->add($secondToBeCalledMiddleware);
$app->add($firstToBeCalledMiddleware);

// ...

$app->run();
```

Un middleware peut aussi être attaché à une route ou groupe de routes.
Et se déclenchent seulement si la route correspond.

## Etape suivante :

Aller sur la branche `DI`
