<?php

namespace App\Form\Model;

use App\Validator\CheckEmail;
use Symfony\Component\Validator\Constraints as Assert;

class FeedbackFormModel
{
    /**
     * @Assert\NotBlank(message="Поле 'Имя' не должен быть пустым")
     * @Assert\Length(max="80", maxMessage="Имя не должно превышать {limit} знаков")
     */
    public $name;

    /**
     * @Assert\NotBlank (message="Поле 'Емайл' не должен быть пустым")
     * @CheckEmail()
     */
    public $email;

    /**
     * @Assert\NotBlank (message="Поле 'Текст обращения' не должен быть пустым")
     * @Assert\Length (max="4000", maxMessage="'Текст обращения' не должно превышать {limit} знаков")
     */
    public $message;

    /**
     * @Assert\NotBlank(message="Забыли заполнить поле")
     */
    public $captcha;
}