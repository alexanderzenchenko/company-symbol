<?php

namespace App\Service\EmailService;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService implements EmailServiceInterface
{
    protected MailerInterface $mailer;
    protected LoggerInterface $logger;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param string $to
     * @param array $data
     * @return void
     */
    public function send(string $to, array $data): void
    {
        $mail = $this->prepareEmail($to, $data);

        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->info(
                sprintf(
                    '[Mailer] The mail has not been sent. Exception: %s. Message: %s',
                    $exception::class,
                    $exception->getMessage()
                )
            );
        }
    }

    /**
     * @param string $to
     * @param array $data
     * @return Email
     */
    protected function prepareEmail(string $to, array $data): Email
    {
        return (new Email())
            ->from('service@email.com')//TODO: get email from env variables
            ->to($to)
            ->subject($data['subject'])
            ->text($data['text']);
    }
}
