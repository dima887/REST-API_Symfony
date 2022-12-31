<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Data validation when updating a user
 */
class UpdateUserRequest extends BaseRequest
{
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    protected string $email;

    protected string $username;

    #[Assert\Length(
        min: 2,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
    )]
    protected ?string $firstName;

    #[Assert\Length(
        min: 2,
        minMessage: 'Your last name must be at least {{ limit }} characters long',
    )]
    protected ?string $lastName;

    #[Assert\Regex(
        pattern: '/^\+\d{7,}$/',
        message: 'The phone number must start with "+" and contain at least 7 digits',
    )]
    protected ?string $phone;
}