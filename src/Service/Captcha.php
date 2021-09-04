<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Captcha implements CaptchaInterface
{
    /**
     * @var SessionInterface $session
     */
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function get() : string
    {
        $a = $this->getRand();
        $b = $this->getRand();
        $this->session->set('captcha', ($a + $b));
        return sprintf("%d + %d = ", $a, $b);
    }

    /**
     * @param int $number
     * @return int
     * @throws \Exception
     */
    private function getRand($number = 30): int
    {
        return random_int(1, $number);
    }
}