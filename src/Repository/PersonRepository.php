<?php

declare(strict_types=1);

namespace App\Repository;

use App\ApiResources\Person;
use Symfony\Component\Uid\UuidV7;

class PersonRepository
{
    private array $people = [];

    public function __construct()
    {
        $this->simulateDB();
    }

    public function findAll(): array
    {
        return $this->people;
    }

    public function findOneById(UuidV7|string $id): ?Person
    {
        if (!is_string($id)) {
            $id = $id->toRfc4122();
        }

        return $this->people[$id] ?? null;
    }

    public function save(Person $person): void
    {
        // TODO SAVE
    }

    public function remove(Person $person): void
    {
        // TODO SAVE
    }

    private function simulateDB(): void
    {
        $greg = new Person();
        $greg->id = UuidV7::fromRfc4122('01937351-6ecf-79db-9919-7c17943b9bdd');
        $greg->name = 'Greg';
        $greg->birthdate = new \DateTimeImmutable('1985-11-05');

        $guy = new Person();
        $guy->id = UuidV7::fromRfc4122('01937713-9249-7031-bbdb-726a4fbbb7a6');
        $guy->name = 'Guy Fawkes';
        $guy->birthdate = new \DateTimeImmutable('1605-11-05');

        $this->people[$greg->id->toRfc4122()] = $greg;
        $this->people[$guy->id->toRfc4122()] = $guy;
    }
}
