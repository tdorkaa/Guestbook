<?php

namespace Tests;

use Guestbook\InputFilter;
use PHPUnit\Framework\TestCase;

class InputFilterTest extends TestCase
{
    /**
     * @test
     */
    public function filter_GivenValueAndWithTag_ReturnsSanitizedValue()
    {
        $inputFilter = new InputFilter();
        $value = $inputFilter->filter('<br>');
        $this->assertEquals('', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueAndNameWithTag_ReturnsSanitizedValue()
    {
        $inputFilter = new InputFilter();
        $value = $inputFilter->filter('Test name<br>');
        $this->assertEquals('Test name', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueIsValid_ReturnsTheOriginalValue()
    {
        $inputFilter = new InputFilter();
        $value = $inputFilter->filter('Test name');
        $this->assertEquals('Test name', $value);
    }
}