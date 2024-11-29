<?php

declare(strict_types=1);

namespace App\Domain\Enlist;

use App\ApiResources\Person;

final readonly class NameInverter
{
    public function convert(Person $person): void
    {
        $person->verlant = strrev($person->name);
    }
}
