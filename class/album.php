<?php

class Album
{
    public function __construct(
        public string $name,
        public string $privacy,
        public int $user_id
    )
    {
    }

    public function verify(): bool
    {
        $isValid = true;

        if ($this->name === '') {
            $isValid = false;
        }
        return $isValid;
    }
}