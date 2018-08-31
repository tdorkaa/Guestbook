<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class InputValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function validate_GivenInputsEmpty_ThrowException()
    {
        $inputValidator = new \Guestbook\InputValidator();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name required,Email required,Message required');
        $inputValidator->validate('', '', '');
    }

    /**
     * @test
     */
    public function validate_GivenOneInputEmpty_ThrowException()
    {
        $inputValidator = new \Guestbook\InputValidator();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name required');
        $inputValidator->validate('', 'a', 'a');
    }

    /**
     * @test
     */
    public function validate_GivenNameNotEmpty_ThrowException()
    {
        try {
            $inputValidator = new \Guestbook\InputValidator();
            $inputValidator->validate('0', '', '');
            $this->fail('An exception was expected');
        }
        catch (\InvalidArgumentException $exception)
        {
            $this->assertEquals('Email required,Message required', $exception->getMessage());
        }
    }
}