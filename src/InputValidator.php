<?php

namespace Guestbook;


class InputValidator
{

    public function validate($name, $email, $message)
    {
        $errors = [];
        foreach (['Name' => $name, 'Email' => $email, 'Message' => $message] as $k => $v) {
            if (!$v && $v !== '0') {
                $errors[] = $k . ' required';
            }
            if($k === 'Email' && $v && !filter_var($v, FILTER_VALIDATE_EMAIL)) {
                $errors[] = $k . ' is not correct';
            }
        }
        if ($errors) {
            throw new \InvalidArgumentException(implode(',', $errors));
        }
    }
}