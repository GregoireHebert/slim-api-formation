<?php

declare(strict_types=1);

namespace App\State\Processor;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Enlist\NameInverter;
use App\Repository\PersonRepository;

class PersonProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly PersonRepository $personRepository,
        private readonly NameInverter $nameInverter,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation instanceof Delete) {
            $this->personRepository->remove($data);
            return $data;
        }

        $this->nameInverter->convert($data);
        $this->personRepository->save($data);

        return $data;
    }
}
