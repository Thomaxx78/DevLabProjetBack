<?php

class User
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username,
        public string $description,
        public string $age,
        public string $logo,
    )
    {
    }

    public function verify(): bool
    {
        $isValid = true;

        if ($this->email === '' || $this->password === '' || $this->username === '' || $this->description === '' || $this->age === '' || $this->logo === '') {
            $isValid = false;
        }
        return $isValid;
    }
}