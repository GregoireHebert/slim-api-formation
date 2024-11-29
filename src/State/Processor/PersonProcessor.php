<?php

declare(strict_types=1);

namespace App\State\Processor;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\PersonRepository;

class PersonProcessor implements ProcessorInterface
{
    public function __construct(private readonly PersonRepository $personRepository)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof Delete) {
            $this->personRepository->remove($data);
            return $data;
        }

        $this->personRepository->save($data);

        return $data;
    }
}
