<?php

namespace App\Service;

class EmailFilter implements EmailFilterInterface
{

    /**
     * Проверка на корректность емайла
     * @param string $email
     * @return bool
     */
    public function filter(string $email) : bool
    {
        if(preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-.]+(ru|com|org)$/i", $email)) {
            return true;
        }
        return  false;

    }
}