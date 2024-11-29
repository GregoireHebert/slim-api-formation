<?php

declare(strict_types=1);

namespace App\ApiResources;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\State\Processor\PersonProcessor;
use App\State\Provider\PeopleProvider;
use App\State\Provider\PersonProvider;
use Symfony\Component\Uid\UuidV7;

#[GetCollection(uriTemplate: '/api/people', provider: PeopleProvider::class)]
#[Post(uriTemplate: '/api/people', uriVariables: ['identifier'], processor: PersonProcessor::class)]
#[Get(uriTemplate: '/api/people/{identifier}', uriVariables: ['identifier'], provider: PersonProvider::class)]
#[Put(uriTemplate: '/api/people/{identifier}', uriVariables: ['identifier'], provider: PersonProvider::class, processor: PersonProcessor::class)]
#[Delete(uriTemplate: '/api/people/{identifier}', uriVariables: ['identifier'], provider: PersonProvider::class, processor: PersonProcessor::class)]
class Person
{
    public ?UuidV7 $id = null;
    public ?string $name = null;
    public ?\DateTimeImmutable $birthdate = null;
}
