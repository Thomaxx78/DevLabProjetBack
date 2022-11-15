<?php

class User
{
    public function __construct(
        public string $pseudo,
        public string $email,
        public string $password,
    )
    {

    }

    public function verify(): bool
    {
        $isValid = true;

        if ($this->email === '' || $this->pseudo === '' || $this->password === '') {
            $isValid = false;
        }
        return $isValid;
    }


}