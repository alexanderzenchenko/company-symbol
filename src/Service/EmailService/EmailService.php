<?php

namespace App\Service\EmailService;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService implements EmailServiceInterface
{
    protected MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
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
            //TODO: log exception
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
            ->from('service@email.com')
            ->to($to)
            ->subject($data['subject'])
            ->text($data['text']);
    }
}
