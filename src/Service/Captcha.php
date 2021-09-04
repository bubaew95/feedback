<?php

namespace App\Service;

class Captcha
{
    public function get()
    {
        $a = $this->getRand();
        $b = $this->getRand();
        return sprintf("%d + %d = ", $a, $b);
    }

    private function getRand($number = 30)
    {
        return random_int(1, $number);
    }
}