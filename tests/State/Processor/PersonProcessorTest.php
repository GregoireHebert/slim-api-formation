<?php

declare(strict_types=1);

namespace App\Tests\State\Processor;

use App\Domain\Enlist\NameInverter;
use App\Domain\Mailer\Mailer;
use App\Repository\PersonRepository;
use App\State\Processor\PersonProcessor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PersonProcessorTest extends TestCase
{
    #[Test]
    public function process(): void
    {
        $personRepositoryMock = $this->createMock(PersonRepository::class);
        $nameInverterMock = $this->createMock(NameInverter::class);
        $mailerMock = $this->createMock(Mailer::class);

        $processor = new PersonProcessor($personRepositoryMock, $nameInverterMock, $mailerMock);

        // ASSERTS
        $processor->process(
            //...
        );
    }
}
