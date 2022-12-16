<?php

namespace App\Tests\Service\EmailService;

use App\Service\EmailService\EmailService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

class EmailServiceTest extends TestCase
{

    public function testSend()
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->once())
            ->method('send');

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())
            ->method('info');

        $emailService = new EmailService($mailer, $logger, 'test@email.com');
        $emailService->send('test@email.com', [
            'subject' => '',
            'text' => '',
        ]);
    }
}
