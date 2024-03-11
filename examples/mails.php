<?php

class Email
{
    public function __construct(protected string $email)
    {
        EmailValidator::validateEmail($email);
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

class EmailValidator
{
    public static function validateEmail(string $email): void
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is not valid');
        }
    }
}


class EmailSender
{
    public function __construct(protected Email $email) { }

    public function sendMail(string $subj, string $msg): bool
    {
        return mail($this->email->getEmail(), $subj, $msg);
    }
}





$emailObj = new Email('example@gmail.com');
$sender = new EmailSender($emailObj);

if ($sender->sendMail('subj', 'Hello')) {
    echo 'відправлено на email ' . $emailObj->getEmail();
} else {
    echo 'не відправлено';

}

echo PHP_EOL;

echo '=========== кінець програми ===========';
echo PHP_EOL;