<?php
namespace Tests;

use Guestbook\InputValidator;
use Guestbook\InvalidInputException;
use PHPUnit\Framework\TestCase;

class InputValidatorTest extends TestCase
{
    /**
     * @var InputValidator
     */
    private $inputValidator;
    
    protected function setUp()
    {
        $this->inputValidator = new InputValidator();
    }

    /**
     * @test
     */
    public function validate_GivenValidParams_NotThrowsException()
    {
        $this->inputValidator->validate('test name', 'test@test.test', 'message');
        $this->expectNotToPerformAssertions();

    }

    /**
     * @test
     */
    public function validate_GivenInputsEmpty_ThrowsException()
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('Name required,Email required,Message required');
        $this->inputValidator->validate('', '', '');
    }

    /**
     * @test
     */
    public function validate_GivenOneInputEmpty_ThrowsException()
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('Name required');
        $this->inputValidator->validate('', 'a', 'a');
    }

    /**
     * @test
     */
    public function validate_GivenNameNotEmpty_ThrowsException()
    {
        try {
            $this->inputValidator->validate('0', '', '');
            $this->fail('An exception was expected');
        }
        catch (InvalidInputException $exception)
        {
            $this->assertEquals('Email required,Message required', $exception->getMessage());
        }
    }

    /**
     * @test
     */
    public function validate_GivenEmailIsInvalid_ThrowsException()
    {
        try {
            $this->inputValidator->validate('test name', 'test@', 'message');
            $this->fail('An exception was expected');
        }
        catch (InvalidInputException $exception)
        {
            $this->assertEquals('Email is not correct', $exception->getMessage());
        }
    }
}