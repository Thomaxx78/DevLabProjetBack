<?php

class User
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username,
    )
    {
    }

    public function verify(): bool
    {
        $isValid = true;

        if ($this->email === '' || $this->password === '' || $this->username === '' ) {
            $isValid = false;
        }
        return $isValid;
    }
}