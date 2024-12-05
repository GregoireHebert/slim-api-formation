<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\Traits\HttpJson;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[UsesClass(\App\ApiResources\Person::class)]
class PersonTest extends TestCase
{
    use HttpJson;

    #[Test]
    public function invertName(): void
    {
        $request = $this->createJsonRequest(
            'POST', '/api/people',
            [
                'name' => 'jean-guy' //  on évite les prénoms palindromes, merci !
            ]
        );
        $response = $this->app->handle($request);

        $this->assertJsonDataContains('verlant', 'yug-naej', $response);
        $this->assertJsonDataContains('name', 'jean-guy', $response);
    }
}
