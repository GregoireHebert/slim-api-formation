<?php

declare(strict_types=1);

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResources\Person;
use App\Repository\PersonRepository;
use Symfony\Component\Uid\UuidV7;

class PeopleProvider implements ProviderInterface
{
    public function __construct(private readonly PersonRepository $personRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->personRepository->findAll();
    }
}
