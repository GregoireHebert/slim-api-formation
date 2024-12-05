# Tester Mailer

Code de la correction

## Tester un service avec une dépendance

Le `PersonProcessor` est un service qui possède des services en dépendances, et dans sa logique une condition.
Lorsque l'on teste un service, ses dépendances sont souvent ignorées avec des mocks.
les mocks permettent d'éviter les comportements non désirés comme l'envoie de mail, et de contrôler leur résultat comme dans la gestion des dates. 

```php
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
```

Le mock est un wrapper. Il y a un souci autour de NameInverter. Discutons-en.
A présent, testez le processor. Il faut tester tous les cas possibles !

## Et si votre envoi de mail se faisait par le biais d'un message bus synchrone ?

Ce serait plus difficile de s'assurer de son appel.
C'est pourquoi je vais vous demander d'imaginer une méthode pour savoir d'un service s'il a bien été exploité
et les inconvénients que cela peux avoir.
