<?php

namespace App\Service;

interface EmailFilterInterface
{
    /**
     * Проверка на корректность емайла
     * @param string $email
     * @return bool
     */
    public function filter(string $email) : bool;
}