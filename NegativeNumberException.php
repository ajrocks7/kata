<?php declare(strict_types = 1);

class NegativeNumberException extends Exception
{

    public function __construct(string $message = '', int $code = 422) {
        parent::__construct($message, $code);
        $this->message = "$message";
        $this->code = $code;
    }
}