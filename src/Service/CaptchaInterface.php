<?php

namespace App\Service;

interface CaptchaInterface
{
    /**
     * @return string
     */
    public function get() : string;
}