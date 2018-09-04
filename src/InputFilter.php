<?php
namespace Guestbook;


class InputFilter
{

    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }
}