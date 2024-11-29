<?php

declare(strict_types=1);

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PersonRepository;
use Slim\Exception\HttpNotFoundException;

class PersonProvider implements ProviderInterface
{
    public function __construct(private readonly PersonRepository $personRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (null === $person = $this->personRepository->findOneById($uriVariables['identifier'])) {
            throw new HttpNotFoundException($context['slimRequest']);
        }

        return $person;
    }
}
