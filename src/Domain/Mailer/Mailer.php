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
