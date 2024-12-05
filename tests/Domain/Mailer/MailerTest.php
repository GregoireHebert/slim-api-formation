<?php

declare(strict_types=1);

namespace App\Tests\Domain\Mailer;

use App\Domain\Mailer\Mailer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    #[Test]
    public function forbiddenEmail()
    {
        $mailer = new Mailer();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('expediteur interdit');
        $mailer->sendMail('sujet', 'email', 'data');
    }

    #[Test]
    public function validEmail()
    {
        $mailer = new Mailer();

        $result = $mailer->sendMail('sujet', 'gregoire@les-tilleuls.coop', 'data');
        self::assertTrue($result);
    }
}
