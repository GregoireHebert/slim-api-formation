<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Traits\HttpJson;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use App\Controller\Api;
use PHPUnit\Framework\TestCase;
use Slim\Exception\HttpNotFoundException;

#[UsesClass(Api::class)] // pour la couverture de code
class ApiTest extends TestCase
{
    use HttpJson;

    #[Test]
    public function PageNotFound(): void
    {
        $request = $this->createJsonRequest('GET', '/api/existe-pas');

        $this->expectException(HttpNotFoundException::class);
        $this->app->handle($request);
    }
}
