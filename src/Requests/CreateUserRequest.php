<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Data validation when creating a new user
 */
class CreateUserRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    protected string $email;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        minMessage: 'Your password must be at least {{ limit }} characters long',
    )]
    #[Assert\NotCompromisedPassword]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
        message: 'The password must contain at least one uppercase letter, at least one lowercase letter, and at least one number',
    )]
    protected string $password;
}