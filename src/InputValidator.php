<?php

namespace Guestbook;


class InputValidator
{

    public function validate($name, $email, $message)
    {
        $errors = [];
        foreach (['Name' => $name, 'Email' => $email, 'Message' => $message] as $key => $value) {
            if ($this->validateEmpty($value)) {
                $errors[] = $key . ' required';
            }
            if($key === 'Email' && $this->validateEmail($value)) {
                $errors[] = $key . ' is not correct';
            }
        }
        if ($errors) {
            throw new \InvalidArgumentException(implode(',', $errors));
        }
    }

    /**
     * @param $value
     * @return bool
     */
    private function validateEmpty($value): bool
    {
        return !$value && $value !== '0';
    }

    /**
     * @param $value
     * @return bool
     */
    private function validateEmail($value): bool
    {
        return $value && !filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}