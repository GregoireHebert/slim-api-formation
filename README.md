# Api

Avant de se lancer, commençons par nous familiariser avec les settings et les middlewares.
En créant celui qui répondra avec les CORS.

La logique se trouvera dans `src/Middlewares/CorsMiddleware.php`.

```php
<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;

final class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(private App $app)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'OPTIONS') {
            $response = $this->app->getResponseFactory()->createResponse();
        } else {
            $response = $handler->handle($request);
        }

        $settings = $this->app->getContainer()->get('settings');

        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', $settings['cors']['Origin'])
            ->withHeader('Access-Control-Allow-Headers', $settings['cors']['Headers'])
            ->withHeader('Access-Control-Allow-Methods', $settings['cors']['Methods'])
            ->withHeader('Cache-Control', $settings['cors']['Cache-Control'])
            ->withHeader('Pragma', 'no-cache');

        if (ob_get_contents()) {
            ob_clean();
        }

        return $response;
    }
}
```

Pour l'appeler, on va démarrer en créer un fichier responsable de le charger ainsi que les suivants.
Mettons-le dans `src/config/middlewares.php`.

```php
<?php

use Slim\App;
use App\Middlewares\CorsMiddleware;

return function (App $app) {
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(CorsMiddleware::class);
};
```

Et comme pour les routes, importons-le après les routes dans le container.

```php
(require __DIR__ . '/middlewares.php')($app);
```

## Etape suivante :

Aller sur la branche `api`
