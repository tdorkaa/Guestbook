<?php
namespace Guestbook;

class InputFilter
{

    public function filter($value)
    {
        $value = $this->sanitizeString($value);
        $value = trim($value);
        return $value;
    }

    private function sanitizeString($value) {
        return filter_var($value, FILTER_SANITIZE_STRING);
    }
}
