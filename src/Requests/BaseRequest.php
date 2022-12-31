<?php

namespace App\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class from which all data validation classes should inherit
 */
abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    /**
     * Validates a value against a constraint or a list of constraints.
     *
     * @return ConstraintViolationListInterface|false
     */
    public function validate(): ConstraintViolationListInterface|false
    {
        $errors = $this->validator->validate($this);

        $messages = ['message' => 'There was a validation error', 'errors' => []];

        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, 400);
            $response->send();

            exit();
        }
        return false;
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * Iterate over the request body and map fields to class properties
     *
     * @return void
     */
    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Auto request validation
     *
     * @return bool
     */
    protected function autoValidateRequest(): bool
    {
        return true;
    }
}