<?php

namespace Tests;

use Guestbook\InputFilter;
use PHPUnit\Framework\TestCase;

class InputFilterTest extends TestCase
{
    private $inputFilter;

    protected function setUp()
    {
        $this->inputFilter = new InputFilter();
    }

    /**
     * @test
     */
    public function filter_GivenValueAndWithTag_ReturnsSanitizedValue()
    {

        $value = $this->inputFilter->filter('<br>');
        $this->assertEquals('', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueAndNameWithTag_ReturnsSanitizedValue()
    {
        $value = $this->inputFilter->filter('Test name<br>');
        $this->assertEquals('Test name', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueIsValid_ReturnsTheOriginalValue()
    {
        $value = $this->inputFilter->filter('Test name');
        $this->assertEquals('Test name', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueIsWitWhiteSpacesAtTheBeginning_ReturnsTheOriginalValue()
    {
        $value = $this->inputFilter->filter('                          Test name');
        $this->assertEquals('Test name', $value);
    }

    /**
     * @test
     */
    public function filter_GivenValueIsWithNewLineCharacter_ReturnsTheOriginalValue()
    {
        $value = $this->inputFilter->filter("Test name\n");
        $this->assertEquals('Test name', $value);
    }
}