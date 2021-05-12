<?php

require_once __DIR__ . '/../../config/settings.php';

use App\Validations\ExampleValidator;
use PHPUnit\Framework\TestCase;

Class ExampleValidatorTest extends TestCase
{
    public function tearDown() : void
    {
        unset($this->validator);
    }

    public function test_email_is_required()
    {
        $params = ['email' => '',];

        $this->validator = new ExampleValidator($params);

        $this->assertEquals(true, $this->validator->fails());

        $errorBag = $this->validator->getErrors();

        $this->assertEquals(true, $errorBag->has('email'));
    }

    public function test_email_must_be_valid_email()
    {
        $params = ['email' => 'validemail.com',];

        $this->validator = new ExampleValidator($params);

        $this->assertEquals(true, $this->validator->fails());

        $errorBag = $this->validator->getErrors();

        $this->assertEquals(true, $errorBag->has('email'));
    }
}
