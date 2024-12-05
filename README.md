# Tester name inverter

Code de la correction

## Tester un service

Un service seul, si son action n'a pas d'incidence sur la réponse, ne peux pas juste être testé ainsi.
Il faut le tester unitairement. C'est-à-dire si je l'appelle en direct, fait-il son travail ?

Créer le service Mailer : 

```php
<?php

declare(strict_types=1);

namespace App\Domain\Mailer;

class Mailer
{
    public function sendMail($subject, $to, $body): bool
    {
        if ($to !== 'gregoire@les-tilleuls.coop') {
            throw new \RuntimeException('expediteur interdit');
        }
        
        return true;
        // on fait comme si on savait envoyer les emails et gérer les bounces.
    }
}
```

Appelez-le depuis le processor d'une personne.
Maintenant testez cette classe seule.

## Etape suivante :

Aller sur la branche `phpunit-mailer`
